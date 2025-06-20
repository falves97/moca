<?php

namespace App\Form;

use App\Entity\Alternative;
use App\Entity\MultipleChoiceResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultipleChoiceResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var MultipleChoiceResponse $multipleChoiceResponse */
        $multipleChoiceResponses = $builder->getData();

        $builder
            ->add('alternatives', EntityType::class, [
                'class' => Alternative::class,
                'choice_label' => 'statement',
                'choices' => $multipleChoiceResponses->getQuestion()->getAlternatives(),
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'label_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MultipleChoiceResponse::class,
        ]);
    }
}
