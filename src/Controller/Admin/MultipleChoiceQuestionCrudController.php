<?php

namespace App\Controller\Admin;

use App\Entity\MultipleChoiceQuestion;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MultipleChoiceQuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MultipleChoiceQuestion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            TextEditorField::new('statement', 'Enunciado')
                ->setFormTypeOptions([
                    'attr' => [
                        'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image media',
                    ],
                ]),
            IntegerField::new('maximumPossiblePoints', 'Pontos Máximos')
                ->setFormTypeOption('attr', [
                    'min' => 1,
                    'max' => 100,
                ]),
            CollectionField::new('alternatives', 'Alternativas')
                ->useEntryCrudForm(AlternativeCrudController::class),
        ];
    }
}
