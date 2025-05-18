<?php

namespace App\Form;

use EmilePerron\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextEditorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'sanitize_html' => true,
        ]);

        $resolver->setAllowedTypes('sanitize_html', 'bool');
    }

    public function getParent(): string
    {
        return TinymceType::class;
    }
}
