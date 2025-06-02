<?php

namespace App\Controller\Admin;

use App\Entity\ImageFile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageFileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImageFile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            Field::new('file', 'Imagem')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions([
                    'allow_delete' => false,
                ])
                ->onlyOnForms(),
        ];
    }
}
