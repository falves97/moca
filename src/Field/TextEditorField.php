<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EmilePerron\TinymceBundle\Form\Type\TinymceType;

class TextEditorField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(TinymceType::class)
            ->setTemplatePath('field/text_editor.html.twig')
            ->addFormTheme('@Tinymce/form/tinymce_type.html.twig');
    }
}
