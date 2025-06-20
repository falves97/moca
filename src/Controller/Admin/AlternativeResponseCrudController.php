<?php

namespace App\Controller\Admin;

use App\Entity\Alternative;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AlternativeResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alternative::class;
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
                    'readonly' => true,
                ],
            ]),
            BooleanField::new('isCorrect', 'Correta')
            ->setDisabled(),
        ];
    }
}
