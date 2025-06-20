<?php

namespace App\Controller\Admin;

use App\Entity\Module;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ModuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Module::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Módulo')
            ->setEntityLabelInPlural('Módulos')
            ->setSearchFields(['name'])
            ->setDefaultSort(['name' => 'ASC'])
            ->setPaginatorPageSize(100)
            ->setPageTitle('index', '%entity_label_plural%')
            ->setPageTitle('detail', fn (Module $module) => (string) $module->getName());
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
            AssociationField::new('discipline', 'Disciplina')
                ->autocomplete(),
            Field::new('name', 'Nome'),
            Field::new('description', 'Descrição'),
            CollectionField::new('lessons', 'Lições')
                ->useEntryCrudForm(LessonCrudController::class)
                ->addJsFiles(
                    'bundles/tinymce/ext/tinymce/tinymce.min.js',
                    'bundles/tinymce/ext/tinymce-webcomponent.js',
                )
                ->hideOnIndex(),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $query = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            return $query;
        } else {
            $query
                ->innerJoin('entity.discipline', 'discipline')
                ->leftJoin('discipline.student', 'discipline_student')
                ->andWhere('discipline.professor = :user OR discipline_student = :user')
                ->setParameter('user', $user);

            return $query;
        }
    }
}
