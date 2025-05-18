<?php

namespace App\Entity;

use App\Repository\SubjetiveQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjetiveQuestionRepository::class)]
class SubjetiveQuestion extends Question
{
    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'subjectiveQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Quiz $quiz = null;

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
