<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity('email')]
#[UniqueEntity('username')]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discriminator', type: 'string')]
#[DiscriminatorMap(['user' => User::class, 'student' => Student::class, 'professor' => Professor::class])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    protected ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    protected array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 180)]
    protected ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    protected ?string $lastName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    protected ?string $username = null;

    protected ?string $plainPassword;

    #[ORM\OneToOne(targetEntity: AvatarFile::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?AvatarFile $avatar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getAvatar(): ?AvatarFile
    {
        return $this->avatar;
    }

    public function setAvatar(?AvatarFile $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
