<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use App\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            AssociationField::new('module', 'Módulo')
                ->autocomplete()
                ->setRequired(true),
            TextField::new('name', 'Nome'),
            TextEditorField::new('content', 'Conteúdo')
            ->setFormTypeOptions([
                'attr' => [
                    'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image media',
                ],
            ]),
        ];
    }
}
