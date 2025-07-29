<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Título',
                'attr' => ['placeholder' => 'Digite um questionamento ou tópico para discussão'],
            ])
            ->add('content', TrixType::class, [
                'label' => 'Conteúdo',
                'attr' => [
                    'placeholder' => 'Descreva em detalhes o seu questionamento ou tópico',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
