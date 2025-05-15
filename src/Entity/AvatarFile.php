<?php

namespace App\Entity;

use App\Repository\AvatarFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AvatarFileRepository::class)]
#[Vich\Uploadable]
class AvatarFile extends ImageFile
{
    #[Vich\UploadableField(mapping: 'avatars', fileNameProperty: 'name', size: 'size', mimeType: 'mimeType', originalName: 'originalName', dimensions: 'dimensions')]
    private ?File $file = null;
}
