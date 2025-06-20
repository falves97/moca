<?php

namespace App\Controller\Admin;

use App\Entity\MultipleChoiceResponse;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MultipleChoiceResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MultipleChoiceResponse::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            TextEditorField::new('question.statement', 'Enunciado da Questão')
                ->setFormTypeOptions([
                    'attr' => [
                        'readonly' => true,
                    ],
                ]),
            CollectionField::new('alternatives', 'Alternativas')
                ->setFormTypeOption('attr', [
                    'readonly' => true,
                ])
                ->useEntryCrudForm(AlternativeResponseCrudController::class)
                ->allowAdd(false)
                ->allowDelete(false),
            IntegerField::new('points', 'Pontos')
                ->setFormTypeOption('attr', [
                    'min' => 0,
                    'max' => 100,
                ]),
        ];
    }
}
