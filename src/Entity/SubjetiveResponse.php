<?php

namespace App\Entity;

use App\Repository\SubjetiveResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjetiveResponseRepository::class)]
class SubjetiveResponse extends Response
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'subjetiveResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizResponse $quizResponse = null;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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
