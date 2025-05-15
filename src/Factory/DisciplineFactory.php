<?php

namespace App\Factory;

use App\Entity\Discipline;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Discipline>
 */
final class DisciplineFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Discipline::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'class' => self::faker()->randomNumber(5),
            'description' => self::faker()->text,
            'knowledgeArea' => self::faker()->text(20),
            'name' => self::faker()->name,
            'year' => self::faker()->numberBetween(2000, 2030),
            'professor' => ProfessorFactory::new(),
            'students' => StudentFactory::new()->many(2),
            'modules' => ModuleFactory::new()->many(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Discipline $discipline): void {})
        ;
    }
}
