<?php

namespace App\Entity;

use App\Repository\DefaultAvatarFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: DefaultAvatarFileRepository::class)]
#[Vich\Uploadable]
class DefaultAvatarFile extends ImageFile
{
    #[Vich\UploadableField(mapping: 'avatars', fileNameProperty: 'name', size: 'size', mimeType: 'mimeType', originalName: 'originalName', dimensions: 'dimensions')]
    private ?File $file = null;
}
