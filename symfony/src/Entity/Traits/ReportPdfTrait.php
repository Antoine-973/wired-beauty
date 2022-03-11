<?php

namespace App\Entity\Traits;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


trait ReportPdfTrait
{
    /**
     * @Vich\UploadableField(mapping="report", fileNameProperty="path")
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