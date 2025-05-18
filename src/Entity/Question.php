<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discriminator', type: 'string')]
#[ORM\DiscriminatorMap(['question' => Question::class, 'multiple_choice' => MultipleChoiceQuestion::class, 'subjective' => SubjetiveQuestion::class])]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $statement = null;

    #[ORM\Column]
    #[Assert\Positive]
    protected ?int $maximumPossiblePoints = null;

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

    public function getMaximumPossiblePoints(): ?int
    {
        return $this->maximumPossiblePoints;
    }

    public function setMaximumPossiblePoints(int $maximumPossiblePoints): static
    {
        $this->maximumPossiblePoints = $maximumPossiblePoints;

        return $this;
    }
}
