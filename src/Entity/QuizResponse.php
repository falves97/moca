<?php

namespace App\Entity;

use App\Repository\QuizResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizResponseRepository::class)]
class QuizResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'quizResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;


    /**
     * @var Collection<int, SubjetiveResponse>
     */
    #[ORM\OneToMany(targetEntity: SubjetiveResponse::class, mappedBy: 'quizResponse', orphanRemoval: true)]
    private Collection $subjetiveResponses;

    /**
     * @var Collection<int, MultipleChoiceResponse>
     */
    #[ORM\OneToMany(targetEntity: MultipleChoiceResponse::class, mappedBy: 'quizResponse', orphanRemoval: true)]
    private Collection $multipleChoiceResponses;

    public function __construct()
    {
        $this->subjetiveResponses = new ArrayCollection();
        $this->multipleChoiceResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * @return Collection<int, SubjetiveResponse>
     */
    public function getSubjetiveResponses(): Collection
    {
        return $this->subjetiveResponses;
    }

    public function addSubjetiveResponse(SubjetiveResponse $subjetiveResponse): static
    {
        if (!$this->subjetiveResponses->contains($subjetiveResponse)) {
            $this->subjetiveResponses->add($subjetiveResponse);
            $subjetiveResponse->setQuizResponse($this);
        }

        return $this;
    }

    public function removeSubjetiveResponse(SubjetiveResponse $subjetiveResponse): static
    {
        if ($this->subjetiveResponses->removeElement($subjetiveResponse)) {
            // set the owning side to null (unless already changed)
            if ($subjetiveResponse->getQuizResponse() === $this) {
                $subjetiveResponse->setQuizResponse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultipleChoiceResponse>
     */
    public function getMultipleChoiceResponses(): Collection
    {
        return $this->multipleChoiceResponses;
    }

    public function addMultipleChoiceResponse(MultipleChoiceResponse $multipleChoiceResponse): static
    {
        if (!$this->multipleChoiceResponses->contains($multipleChoiceResponse)) {
            $this->multipleChoiceResponses->add($multipleChoiceResponse);
            $multipleChoiceResponse->setQuizResponse($this);
        }

        return $this;
    }

    public function removeMultipleChoiceResponse(MultipleChoiceResponse $multipleChoiceResponse): static
    {
        if ($this->multipleChoiceResponses->removeElement($multipleChoiceResponse)) {
            // set the owning side to null (unless already changed)
            if ($multipleChoiceResponse->getQuizResponse() === $this) {
                $multipleChoiceResponse->setQuizResponse(null);
            }
        }

        return $this;
    }
}
