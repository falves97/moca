<?php

namespace App\Controller\Admin;

use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class QuizCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quiz::class;
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
                ->autocomplete(),
            CollectionField::new('subjectiveQuestions', 'Questões Subjetivas')
                ->useEntryCrudForm(SubjectiveQuestionCrudController::class)
                ->addJsFiles(
                    'bundles/tinymce/ext/tinymce/tinymce.min.js',
                    'bundles/tinymce/ext/tinymce-webcomponent.js',
                )->onlyWhenCreating(),
            CollectionField::new('subjectiveQuestions', 'Questões Subjetivas')
                ->useEntryCrudForm(SubjectiveQuestionCrudController::class)
                ->onlyWhenUpdating(),
            CollectionField::new('multipleChoiceQuestions', 'Questões de Múltipla Escolha')
                ->useEntryCrudForm(MultipleChoiceQuestionCrudController::class)
                ->addJsFiles(
                    'bundles/tinymce/ext/tinymce/tinymce.min.js',
                    'bundles/tinymce/ext/tinymce-webcomponent.js',
                )->onlyWhenCreating(),
            CollectionField::new('multipleChoiceQuestions', 'Questões de Múltipla Escolha')
                ->useEntryCrudForm(MultipleChoiceQuestionCrudController::class)
                ->onlyWhenUpdating(),
        ];
    }
}
