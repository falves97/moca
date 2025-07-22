<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TrixType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'trix';
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
