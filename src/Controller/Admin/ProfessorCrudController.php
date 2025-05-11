<?php

namespace App\Controller\Admin;

use App\Entity\Professor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ProfessorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Professor')
            ->setEntityLabelInPlural('Professores')
            ->setSearchFields(['firstName', 'lastName'])
            ->setDefaultSort(['firstName' => 'ASC'])
            ->setPaginatorPageSize(100)
            ->setPageTitle('index', '%entity_label_plural%')
            ->setPageTitle('detail', fn (Professor $professor) => (string) $professor->getFullName());
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn('col-sm-8 col-xxl-6');
        yield TextField::new('firstName', 'Nome');
        yield TextField::new('lastName', 'Apelido');
        yield TextField::new('email', 'Email');
        yield TextField::new('username', 'Usuário');
        yield TextField::new('plainPassword')
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Senha', 'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Repita a Senha'],
                'mapped' => false,
            ])
            ->onlyOnForms()
            ->setRequired(Crud::PAGE_NEW == $pageName);
    }
}
