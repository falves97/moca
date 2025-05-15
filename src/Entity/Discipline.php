<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DisciplineRepository::class)]
class Discipline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Professor::class, inversedBy: 'disciplines')]
    private ?Professor $professor = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $knowledgeArea = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $class = null;

    /**
     * @var Collection<int, Module>
     */
    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'discipline')]
    private Collection $modules;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'disciplines')]
    private Collection $students;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): static
    {
        $this->professor = $professor;

        return $this;
    }

    public function getKnowledgeArea(): ?string
    {
        return $this->knowledgeArea;
    }

    public function setKnowledgeArea(string $knowledgeArea): static
    {
        $this->knowledgeArea = $knowledgeArea;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): static
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setDiscipline($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getDiscipline() === $this) {
                $module->setDiscipline(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->students->removeElement($student);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
