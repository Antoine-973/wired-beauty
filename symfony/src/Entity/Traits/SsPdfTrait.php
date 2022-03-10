<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\SerializerInterface;


trait SsPdfTrait
{
    /**
     * @Vich\UploadableField(mapping="scientistsStudies", fileNameProperty="path")
     *
     * @var File $file
     */
    private $file;

    /**
     * @param UploadedFile $file
     */
    public function setFile(?File $file = null)
    {
        $this->file = $file;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

}