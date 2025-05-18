<?php

namespace App\Controller\Admin;

use App\Entity\Discipline;
use App\Field\TextEditorField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class DisciplineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Discipline::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Disciplina')
            ->setEntityLabelInPlural('Disciplinas')
            ->setSearchFields(['name', 'class', 'year'])
            ->setDefaultSort(['name' => 'ASC'])
            ->setPaginatorPageSize(100)
            ->setPageTitle('index', '%entity_label_plural%')
            ->setPageTitle('detail', fn (Discipline $discipline) => (string) $discipline->getName());
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-12'),
            IdField::new('id')
                ->hideOnForm(),
            Field::new('name', 'Nome'),
            TextEditorField::new('description', 'Descrição'),
            Field::new('knowledgeArea', 'Área de Conhecimento'),
            Field::new('class', 'Turma'),
            IntegerField::new('year', 'Ano'),
            AssociationField::new('professor', 'Professor')->hideOnForm(),
            AssociationField::new('professor', 'Professor')
                ->setCrudController(ProfessorCrudController::class)
                ->autocomplete()
                ->onlyOnForms(),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $query = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if ($this->isGranted('ROLE_ADMIN')) {
            return $query;
        } else {
            $query
                ->innerJoin('entity.student', 'student')
                ->andWhere('entity.professor = :professor')
                ->orWhere('student = :student')
                ->setParameter(':professor', $this->getUser())
                ->setParameter(':student', $this->getUser());

            return $query;
        }
    }
}
