<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Nome',
                'constraints' => [
                    new NotBlank(['message' => 'Digite seu nome']),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Sobrenome',
                'constraints' => [
                    new NotBlank(['message' => 'Digite seu sobrenome']),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank(['message' => 'Digite seu email']),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'As senhas devem coincidir.',
                'first_options' => ['label' => 'Senha', 'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Confirmar Senha'],
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
