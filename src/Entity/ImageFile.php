<?php

namespace App\Entity;

use App\Repository\ImageFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageFileRepository::class)]
#[InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discriminator', type: 'string')]
#[ORM\DiscriminatorMap(['image' => ImageFile::class, 'avatar' => AvatarFile::class])]
#[Vich\Uploadable]
class ImageFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'name', size: 'size', mimeType: 'mimeType', originalName: 'originalName', dimensions: 'dimensions')]
    private ?File $file = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $originalName = null;

    #[ORM\Column]
    private ?string $mimeType = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $size = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private ?array $dimensions = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    public ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(?array $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function __serialize(): array
    {
        return [$this->id, $this->name, $this->originalName, $this->mimeType, $this->size, $this->dimensions, $this->updatedAt];
    }

    public function __unserialize(array $data): void
    {
        [$this->id, $this->name, $this->originalName, $this->mimeType, $this->size, $this->dimensions, $this->updatedAt] = $data;
    }
}
