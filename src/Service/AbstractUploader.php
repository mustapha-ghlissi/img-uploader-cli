<?php


namespace App\Service;

use App\Helper\FileHelper;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class AbstractUploader
{
    /**
     * @param File $file
     * @param string $fileName
     * @return mixed
     */
    abstract protected function upload(File $file, string $fileName);
}