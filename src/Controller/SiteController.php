<?php

namespace App\Controller;

use App\Entity\MultipleChoiceResponse;
use App\Entity\QuizResponse;
use App\Entity\Student;
use App\Entity\SubjetiveResponse;
use App\Form\QuizResponseType;
use App\Repository\DisciplineRepository;
use App\Repository\LessonRepository;
use App\Repository\QuizRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(name: 'site_')]
final class SiteController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    #[Route('/discipline', name: 'disciplines', methods: ['GET'])]
    public function discipline(Request $request, DisciplineRepository $repository): Response
    {
        $disciplines = new Pagerfanta(new QueryAdapter($repository->findAllPaginatedQueryBuilder()));
        $disciplines->setMaxPerPage(10);
        $disciplines->setCurrentPage($request->query->get('page', 1));

        return $this->render('site/discipline/index.html.twig', [
            'disciplines' => $disciplines,
        ]);
    }

    #[Route('/discipline/{id}', name: 'discipline_show', methods: ['GET'])]
    public function disciplineShow(DisciplineRepository $repository, int $id): Response
    {
        $discipline = $repository->find($id);

        if (!$discipline) {
            throw $this->createNotFoundException('Discipline not found');
        }

        /** @var Student $user */
        $user = $this->getUser();
        $studentFinishedQuizzes = $user
            ?->getQuizResponses()
            ->filter(function (QuizResponse $response) use ($discipline) {
                return $response->getQuiz()->getModule()->getDiscipline() === $discipline;
            })
            ->map(fn (QuizResponse $response) => $response->getQuiz());

        $disciplinePercentage = 0;

        if ($user) {
            $finishedQuizzes = $user->getQuizResponses()->filter(function (QuizResponse $response) use ($discipline) {
                return $response->getQuiz()->getModule()->getDiscipline() === $discipline;
            })->count();
            $totalQuizzes = $discipline->getModules()->reduce(function ($totalQuizzes, $module) {
                return $totalQuizzes + $module->getQuizzes()->count();
            });
            if ($totalQuizzes > 0) {
                $disciplinePercentage = ($finishedQuizzes / $totalQuizzes) * 100;
            }
        }

        return $this->render('site/discipline/show.html.twig', [
            'discipline' => $discipline,
            'studentFinishedQuizzes' => $studentFinishedQuizzes,
            'disciplinePercentage' => $disciplinePercentage,
        ]);
    }

    #[Route('/lesson/{id<\d+>}', name: 'lesson_show', methods: ['GET'])]
    #[IsGranted('ROLE_STUDENT')]
    public function lessonShow(LessonRepository $repository, int $id): Response
    {
        $lesson = $repository->find($id);

        if (!$lesson) {
            throw $this->createNotFoundException('Lesson not found');
        }

        // Check if the user is enrolled in the discipline of the lesson
        $user = $this->getUser();
        if ($user instanceof Student) {
            $disciplines = $user->getDisciplines();
            $isEnrolled = false;
            foreach ($disciplines as $discipline) {
                if ($lesson->getModule()->getDiscipline() === $discipline && $discipline->getStudents()->contains($user)) {
                    $isEnrolled = true;
                    break;
                }
            }

            if (!$isEnrolled) {
                $this->addFlash('error', 'Você não está matriculado nesta disciplina.');

                return $this->redirectToRoute('site_discipline_show', ['id' => $lesson->getModule()->getDiscipline()->getId()]);
            }
        }

        return $this->render('site/lesson.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/enroll/{discipline<\d+>}', name: 'enroll', methods: ['POST'])]
    #[IsGranted('ROLE_STUDENT')]
    public function enroll(DisciplineRepository $repository, int $discipline, EntityManagerInterface $entityManager): Response
    {
        $discipline = $repository->find($discipline);

        if (!$discipline) {
            throw $this->createNotFoundException('Discipline not found');
        }

        $user = $this->getUser();
        //        xdebug_break();
        if ($user instanceof Student) {
            // Check if the user is already enrolled in the discipline
            if ($discipline->getStudents()->contains($this->getUser())) {
                $this->addFlash('error', 'Você já está matriculado nesta disciplina.');
            } else {
                // Enroll the student in the discipline
                $user->addDiscipline($discipline);
                $entityManager->persist($user);
                $entityManager->persist($discipline);
                $entityManager->flush();
                $this->addFlash('success', 'Você foi matriculado com sucesso na disciplina: '.$discipline->getName());
            }
        } else {
            $this->addFlash('error', 'Somente alunos podem se matricular em disciplinas.');
        }

        return $this->redirectToRoute('site_discipline_show', ['id' => $discipline->getId()]);
    }

    #[Route('/quiz/{id<\d+>}', name: 'quiz', methods: ['GET', 'POST'])]
    public function quiz(Request $request, QuizRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $id = (int) $request->attributes->get('id');
        $quiz = $repository->find($id);

        if (!$quiz) {
            throw $this->createNotFoundException('Quiz not found');
        }

        // Check if the user is enrolled in the discipline of the quiz
        $user = $this->getUser();

        if (!$user instanceof Student) {
            $this->addFlash('error', 'Você precisa estar logado como aluno para responder a este quiz.');

            return $this->redirectToRoute('site_discipline_show', ['id' => $quiz->getModule()->getDiscipline()->getId()]);
        }

        $disciplines = $user->getDisciplines();
        $isEnrolled = false;
        foreach ($disciplines as $discipline) {
            if ($quiz->getModule()->getDiscipline() === $discipline && $discipline->getStudents()->contains($user)) {
                $isEnrolled = true;
                break;
            }
        }

        if (!$isEnrolled) {
            $this->addFlash('error', 'Você não está matriculado nesta disciplina.');

            return $this->redirectToRoute('site_discipline_show', ['id' => $quiz->getDiscipline()->getId()]);
        }

        if ($user->getQuizResponses()->exists(function ($key, $quizResponse) use ($quiz) {
            return $quizResponse->getQuiz()->getId() === $quiz->getId();
        })) {
            $this->addFlash('success', 'Você já respondeu a este quiz.');

            return $this->redirectToRoute('site_quiz_result', ['id' => $quiz->getId()]);
        }

        $quizResponse = new QuizResponse();
        $quizResponse->setQuiz($quiz);
        $quizResponse->setStudent($user);

        // Initialize responses for the quiz
        foreach ($quiz->getSubjectiveQuestions() as $subjectiveQuestion) {
            $subjetiveResponse = new SubjetiveResponse();
            $subjetiveResponse->setQuestion($subjectiveQuestion);
            $subjetiveResponse->setQuizResponse($quizResponse);
            $quizResponse->addSubjetiveResponse($subjetiveResponse);
        }

        foreach ($quiz->getMultipleChoiceQuestions() as $multipleChoiceQuestion) {
            $multipleChoiceResponse = new MultipleChoiceResponse();
            $multipleChoiceResponse->setQuestion($multipleChoiceQuestion);
            $multipleChoiceResponse->setQuizResponse($quizResponse);
            $quizResponse->addMultipleChoiceResponse($multipleChoiceResponse);
        }

        $quizForm = $this->createForm(QuizResponseType::class, $quizResponse);

        $quizForm->handleRequest($request);

        if ($quizForm->isSubmitted() && $quizForm->isValid()) {
            // Save the quiz response
            $entityManager->persist($quizResponse);
            foreach ($quizResponse->getSubjetiveResponses() as $subjetiveResponse) {
                $entityManager->persist($subjetiveResponse);
            }
            foreach ($quizResponse->getMultipleChoiceResponses() as $multipleChoiceResponse) {
                $entityManager->persist($multipleChoiceResponse);
            }

            $entityManager->flush();

            // Add a success message
            $this->addFlash('success', 'Sua resposta foi salva com sucesso!');

            return $this->redirectToRoute('site_quiz_result', ['id' => $quiz->getModule()->getDiscipline()->getId()]);
        }

        return $this->render('site/quiz/quiz.html.twig', [
            'quiz' => $quiz,
            'quizForm' => $quizForm,
        ]);
    }

    #[Route('/quiz/{id<\d+>}/result', name: 'quiz_result', methods: ['GET'])]
    public function quizResult(QuizRepository $repository, int $id): Response
    {
        $quiz = $repository->find($id);

        if (!$quiz) {
            throw $this->createNotFoundException('Quiz not found');
        }

        // Check if the user is enrolled in the discipline of the quiz
        $user = $this->getUser();
        if (!$user instanceof Student) {
            $this->addFlash('error', 'Você precisa estar logado como aluno para ver o resultado deste quiz.');

            return $this->redirectToRoute('site_discipline_show', ['id' => $quiz->getModule()->getDiscipline()->getId()]);
        }

        $disciplines = $user->getDisciplines();
        $isEnrolled = false;
        foreach ($disciplines as $discipline) {
            if ($quiz->getModule()->getDiscipline() === $discipline && $discipline->getStudents()->contains($user)) {
                $isEnrolled = true;
                break;
            }
        }

        if (!$isEnrolled) {
            $this->addFlash('error', 'Você não está matriculado nesta disciplina.');

            return $this->redirectToRoute('site_discipline_show', ['id' => $quiz->getModule()->getDiscipline()->getId()]);
        }

        // Fetch the quiz response for the user
        $quizResponse = $user->getQuizResponses()->filter(function (QuizResponse $response) use ($quiz) {
            return $response->getQuiz()->getId() === $quiz->getId();
        })->first();

        if (!$quizResponse) {
            throw $this->createNotFoundException('Você ainda não respondeu a este quiz.');
        }

        return $this->render('site/quiz/result.html.twig', [
            'quiz' => $quiz,
            'quizResponse' => $quizResponse,
        ]);
    }

    #[Route('/lesson/{id<\d+>}/complete', name: 'lesson_complete', methods: ['POST'])]
    #[IsGranted('ROLE_STUDENT')]
    public function lessonComplete(LessonRepository $repository, int $id, EntityManagerInterface $entityManager): Response
    {
        $lesson = $repository->find($id);

        if (!$lesson) {
            throw $this->createNotFoundException('Lesson not found');
        }

        // Check if the user is enrolled in the discipline of the lesson
        $user = $this->getUser();
        if (!$user instanceof Student) {
            $this->addFlash('error', 'Você precisa estar logado como aluno para finalizar esta lição.');

            return $this->redirectToRoute('site_discipline_show', ['id' => $lesson->getModule()->getDiscipline()->getId()]);
        }

        if (!$user->getLessons()->contains($lesson)) {
            $user->addLesson($lesson);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Lição finalizada com sucesso!');
        } else {
            $this->addFlash('error', 'Você já finalizou esta lição.');
        }

        return $this->redirectToRoute('site_lesson_show', ['id' => $lesson->getId()]);
    }

    #[Route('/ranking', name: 'ranking', methods: ['GET'])]
    public function ranking(StudentRepository $repository): Response
    {
        $students = $repository->findAll();
        $studentsPoints = [];

        usort($students, function (Student $a, Student $b) use (&$studentsPoints) {
            $fnReduce = static function (int $aPoints, QuizResponse $quizResponse) {
                $subjectivePoints = $quizResponse->getSubjetiveResponses()->reduce(static function (int $subjectivePoints, SubjetiveResponse $subjetiveResponse) {
                    return $subjectivePoints + ($subjetiveResponse->getPoints() ?? 0);
                }, 0);
                $multipleChoicePoints = $quizResponse->getMultipleChoiceResponses()->reduce(static function (int $multipleChoicePoints, MultipleChoiceResponse $multipleChoiceResponse) {
                    return $multipleChoicePoints + ($multipleChoiceResponse->getPoints() ?? 0);
                }, 0);

                return $aPoints + $subjectivePoints + $multipleChoicePoints;
            };

            $aPoints = $a->getQuizResponses()->reduce($fnReduce, 0);

            $bPoints = $b->getQuizResponses()->reduce($fnReduce, 0);
            $studentsPoints[$a->getId()] = $aPoints;
            $studentsPoints[$b->getId()] = $bPoints;

            return $bPoints <=> $aPoints; // Sort in descending order
        });

        return $this->render('site/ranking.html.twig', [
            'students' => $students,
            'studentsPoints' => $studentsPoints,
        ]);
    }
}
