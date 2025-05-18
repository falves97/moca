<?php

namespace App\Entity;

use App\Repository\AlternativeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlternativeRepository::class)]
class Alternative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $statement = null;

    #[ORM\Column()]
    private bool $isCorrect = false;

    #[ORM\ManyToOne(targetEntity: MultipleChoiceQuestion::class, inversedBy: 'alternatives')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MultipleChoiceQuestion $multipleChoiceQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatement(): ?string
    {
        return $this->statement;
    }

    public function setStatement(string $statement): static
    {
        $this->statement = $statement;

        return $this;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getMultipleChoiceQuestion(): ?MultipleChoiceQuestion
    {
        return $this->multipleChoiceQuestion;
    }

    public function setMultipleChoiceQuestion(?MultipleChoiceQuestion $multipleChoiceQuestion): static
    {
        $this->multipleChoiceQuestion = $multipleChoiceQuestion;

        return $this;
    }
}
