<?php

namespace App\Form;

use App\Entity\QuizResponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var QuizResponse $quizResponse */
        $quizResponse = $builder->getData();

        foreach ($quizResponse->getSubjetiveResponses() as $subjetiveResponse) {
            $builder->add('subjetiveResponse'.$subjetiveResponse->getQuestion()->getId(), SubjectiveResponseType::class, [
                'data' => $subjetiveResponse,
                'mapped' => false,
                'label' => $subjetiveResponse->getQuestion()->getStatement(),
                'label_html' => true,
            ]);
        }

        foreach ($quizResponse->getMultipleChoiceResponses() as $multipleChoiceResponse) {
            $builder->add('multipleChoiceResponse'.$multipleChoiceResponse->getQuestion()->getId(), MultipleChoiceResponseType::class, [
                'data' => $multipleChoiceResponse,
                'mapped' => false,
                'label' => $multipleChoiceResponse->getQuestion()->getStatement(),
                'label_html' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizResponse::class,
        ]);
    }
}
