<?php

namespace App\DataFixtures;

use App\Factory\DisciplineFactory;
use App\Factory\ProfessorFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = UserFactory::createOne(['email' => 'admin@email.com', 'password' => 'senha', 'roles' => ['ROLE_ADMIN']]);
        $student = StudentFactory::createOne(['email' => 'student@email.com', 'password' => 'senha']);
        $professor = ProfessorFactory::createOne(['email' => 'professor@email.com', 'password' => 'senha', 'roles' => ['ROLE_ADMIN', 'ROLE_PROFESSOR']]);

        $discipline = DisciplineFactory::createOne([
            'name' => 'Matemática',
            'description' => 'Matemática',
            'knowledgeArea' => 'Matemática',
            'year' => 2023,
            'professor' => $professor,
            'students' => [$student],
        ]);

        $manager->flush();
    }
}
