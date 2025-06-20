<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends User
{
    /**
     * @var Collection<int, Discipline>
     */
    #[ORM\ManyToMany(targetEntity: Discipline::class, mappedBy: 'students')]
    protected Collection $disciplines;

    /**
     * @var Collection<int, QuizResponse>
     */
    #[ORM\OneToMany(targetEntity: QuizResponse::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $quizResponses;

    public function __construct()
    {
        $this->setRoles(['ROLE_STUDENT']);
        $this->disciplines = new ArrayCollection();
        $this->quizResponses = new ArrayCollection();
    }

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): static
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines->add($discipline);
            $discipline->addStudent($this);
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): static
    {
        if ($this->disciplines->removeElement($discipline)) {
            $discipline->removeStudent($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    /**
     * @return Collection<int, QuizResponse>
     */
    public function getQuizResponses(): Collection
    {
        return $this->quizResponses;
    }

    public function addQuizResponse(QuizResponse $quizResponse): static
    {
        if (!$this->quizResponses->contains($quizResponse)) {
            $this->quizResponses->add($quizResponse);
            $quizResponse->setStudent($this);
        }

        return $this;
    }

    public function removeQuizResponse(QuizResponse $quizResponse): static
    {
        if ($this->quizResponses->removeElement($quizResponse)) {
            // set the owning side to null (unless already changed)
            if ($quizResponse->getStudent() === $this) {
                $quizResponse->setStudent(null);
            }
        }

        return $this;
    }
}
