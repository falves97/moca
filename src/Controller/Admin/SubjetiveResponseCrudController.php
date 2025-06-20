<?php

namespace App\Controller\Admin;

use App\Entity\SubjetiveResponse;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class SubjetiveResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubjetiveResponse::class;
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
            TextareaField::new('content', 'Resposta')
                ->setDisabled(),
            IntegerField::new('points', 'Pontos')
                ->setFormTypeOption('attr', [
                    'min' => 0,
                    'max' => 100,
                ]),
        ];
    }
}
