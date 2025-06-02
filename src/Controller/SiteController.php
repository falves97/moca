<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\DisciplineRepository;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/', name: 'site_')]
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

        return $this->render('site/discipline/show.html.twig', [
            'discipline' => $discipline,
        ]);
    }

    #[Route('/ranking', name: 'ranking')]
    public function ranking(): Response
    {
        // This is a placeholder for the ranking page logic.
        // You can implement the logic to fetch and display rankings here.

        return $this->render('site/ranking.html.twig');
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
}
