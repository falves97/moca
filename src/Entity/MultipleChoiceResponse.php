<?php

namespace App\Entity;

use App\Repository\MultipleChoiceResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultipleChoiceResponseRepository::class)]
class MultipleChoiceResponse extends Response
{
    /**
     * @var Collection<int, Alternative>
     */
    #[ORM\ManyToMany(targetEntity: Alternative::class)]
    private Collection $alternatives;

    #[ORM\ManyToOne(inversedBy: 'multipleChoiceResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizResponse $quizResponse = null;

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
        }

        return $this;
    }

    public function removeAlternative(Alternative $alternative): static
    {
        $this->alternatives->removeElement($alternative);

        return $this;
    }

    public function getQuizResponse(): ?QuizResponse
    {
        return $this->quizResponse;
    }

    public function setQuizResponse(?QuizResponse $quizResponse): static
    {
        $this->quizResponse = $quizResponse;

        return $this;
    }
}
