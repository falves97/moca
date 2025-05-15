<?php

namespace App\Factory;

use App\Entity\Student;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Student>
 */
final class StudentFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private ?UserPasswordHasherInterface $passwordHasher = null,
    ) {
    }

    public static function class(): string
    {
        return Student::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->email,
            'firstName' => self::faker()->firstName,
            'lastName' => self::faker()->lastName,
            'password' => self::faker()->text(),
            'roles' => ['ROLE_STUDENT'],
            'username' => self::faker()->userName,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Student $student) {
                if (null !== $this->passwordHasher) {
                    $student->setPassword($this->passwordHasher->hashPassword($student, $student->getPassword()));
                }
            });
    }
}
