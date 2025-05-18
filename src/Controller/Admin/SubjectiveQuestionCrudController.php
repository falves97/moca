<?php

namespace App\Controller\Admin;

use App\Entity\SubjetiveQuestion;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class SubjectiveQuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubjetiveQuestion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            TextEditorField::new('statement', 'Enunciado'),
            IntegerField::new('maximumPossiblePoints', 'Pontos Máximos')
                ->setFormTypeOption('attr', [
                    'min' => 1,
                    'max' => 100,
                ]),
        ];
    }
}
