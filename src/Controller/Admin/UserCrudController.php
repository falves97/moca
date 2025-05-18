<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(),
            IdField::new('id')
                ->hideOnForm(),
            AssociationField::new('avatar', 'Avatar')
                ->setCrudController(AvatarFileCrudController::class)
                ->renderAsEmbeddedForm()
                ->onlyOnForms(),
            ImageField::new('avatar.name', 'Avatar')
                ->setBasePath('/upload/images/avatars/')
                ->hideOnForm(),
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
            FormField::addRow(),
            TextField::new('plainPassword')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Senha',
                        'hash_property_path' => 'password',
                    ],
                    'second_options' => ['label' => 'Repita a Senha'],
                    'mapped' => false,
                ])
                ->onlyOnForms()
                ->setRequired(Crud::PAGE_NEW == $pageName),
        ];
    }
}
