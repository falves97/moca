<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    private ?Module $module = null;

    /**
     * @var Collection<int, MultipleChoiceQuestion>
     */
    #[ORM\OneToMany(targetEntity: MultipleChoiceQuestion::class, mappedBy: 'quiz', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $multipleChoiceQuestions;

    /**
     * @var Collection<int, SubjetiveQuestion>
     */
    #[ORM\OneToMany(targetEntity: SubjetiveQuestion::class, mappedBy: 'quiz', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $subjectiveQuestions;

    public function __construct()
    {
        $this->multipleChoiceQuestions = new ArrayCollection();
        $this->subjectiveQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return Collection<int, MultipleChoiceQuestion>
     */
    public function getMultipleChoiceQuestions(): Collection
    {
        return $this->multipleChoiceQuestions;
    }

    public function addMultipleChoiceQuestion(MultipleChoiceQuestion $multipleChoiceQuestion): static
    {
        if (!$this->multipleChoiceQuestions->contains($multipleChoiceQuestion)) {
            $this->multipleChoiceQuestions->add($multipleChoiceQuestion);
            $multipleChoiceQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeMultipleChoiceQuestion(MultipleChoiceQuestion $multipleChoiceQuestion): static
    {
        if ($this->multipleChoiceQuestions->removeElement($multipleChoiceQuestion)) {
            // set the owning side to null (unless already changed)
            if ($multipleChoiceQuestion->getQuiz() === $this) {
                $multipleChoiceQuestion->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubjetiveQuestion>
     */
    public function getSubjectiveQuestions(): Collection
    {
        return $this->subjectiveQuestions;
    }

    public function addSubjectiveQuestion(SubjetiveQuestion $subjectiveQuestion): static
    {
        if (!$this->subjectiveQuestions->contains($subjectiveQuestion)) {
            $this->subjectiveQuestions->add($subjectiveQuestion);
            $subjectiveQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeSubjectiveQuestion(SubjetiveQuestion $subjectiveQuestion): static
    {
        if ($this->subjectiveQuestions->removeElement($subjectiveQuestion)) {
            // set the owning side to null (unless already changed)
            if ($subjectiveQuestion->getQuiz() === $this) {
                $subjectiveQuestion->setQuiz(null);
            }
        }

        return $this;
    }
}
