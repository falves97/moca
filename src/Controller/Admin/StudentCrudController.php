<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Aluno')
            ->setEntityLabelInPlural('Alunos')
            ->setSearchFields(['firstName', 'lastName'])
            ->setDefaultSort(['firstName' => 'ASC'])
            ->setPaginatorPageSize(100)
            ->setPageTitle('index', '%entity_label_plural%')
            ->setPageTitle('detail', fn (Student $student) => (string) $student->getFullName());
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::INDEX, 'ROLE_ADMIN')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-sm-8 col-xxl-6'),
            TextField::new('firstName', 'Nome')
                ->onlyOnForms(),
            TextField::new('lastName', 'Sobrenome')
                ->onlyOnForms(),
            TextField::new('fullName', 'Nome Completo')
                ->hideOnForm(),
            TextField::new('username', 'Nome de usuário'),
            EmailField::new('email', 'E-mail'),
            ChoiceField::new('roles', 'Cargos')
                ->allowMultipleChoices()
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'Professor' => 'ROLE_PROFESSOR',
                    'Aluno' => 'ROLE_STUDENT',
                ]),
            TextField::new('plainPassword')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Senha', 'hash_property_path' => 'password'],
                    'second_options' => ['label' => 'Repita a Senha'],
                    'mapped' => false,
                ])
                ->onlyOnForms()
                ->setRequired(Crud::PAGE_NEW == $pageName),
        ];
    }
}
