<?php

namespace App\Entity;

use App\Repository\MultipleChoiceQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MultipleChoiceQuestionRepository::class)]
class MultipleChoiceQuestion extends Question
{
    /**
     * @var Collection<int, Alternative>
     */
    #[ORM\OneToMany(targetEntity: Alternative::class, mappedBy: 'multipleChoiceQuestion', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Assert\Count(min: 2, max: 5)]
    protected Collection $alternatives;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'multipleChoiceQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Quiz $quiz = null;

    public function __construct()
    {
        $this->alternatives = new ArrayCollection();
    }

    /**
     * @return Collection<int, Alternative>
     */
    public function getAlternatives(): Collection
    {
        return $this->alternatives;
    }

    public function addAlternative(Alternative $alternative): static
    {
        if (!$this->alternatives->contains($alternative)) {
            $this->alternatives->add($alternative);
            $alternative->setMultipleChoiceQuestion($this);
        }

        return $this;
    }

    public function removeAlternative(Alternative $alternative): static
    {
        if ($this->alternatives->removeElement($alternative)) {
            // set the owning side to null (unless already changed)
            if ($alternative->getMultipleChoiceQuestion() === $this) {
                $alternative->setMultipleChoiceQuestion(null);
            }
        }

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
}
