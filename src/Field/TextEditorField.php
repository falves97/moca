<?php

namespace App\Field;

use App\Form\TextEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class TextEditorField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(TextEditorType::class)
            ->setTemplatePath('field/text_editor.html.twig')
            ->addFormTheme('@Tinymce/form/tinymce_type.html.twig');
    }
}
