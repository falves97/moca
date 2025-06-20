<?php

namespace App\Controller\Admin;

use App\Entity\QuizResponse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class QuizResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuizResponse::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            AssociationField::new('student', 'Aluno')
                ->setDisabled(),
            AssociationField::new('quiz', 'Quiz')
                ->setDisabled(),
            CollectionField::new('subjetiveResponses', 'Respostas Subjetivas')
                ->useEntryCrudForm(SubjetiveResponseCrudController::class)
                ->allowAdd(false)
                ->allowDelete(false),
            CollectionField::new('multipleChoiceResponses', 'Respostas de Múltipla Escolha')
                ->useEntryCrudForm(MultipleChoiceResponseCrudController::class)
                ->allowAdd(false)
                ->allowDelete(false),
        ];
    }
}
