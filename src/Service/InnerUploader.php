<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class InnerUploader extends AbstractUploader
{
    /**
     * @var ParameterBagInterface $bag
     */
    private ParameterBagInterface $bag;

    /**
     * @var Filesystem $filesystem
     */
    private Filesystem $filesystem;

    /**
     * InnerUploader constructor.
     * @param ParameterBagInterface $bag
     */
    public function __construct(ParameterBagInterface $bag)
    {
        $this->bag = $bag;
    }

    /**
     * @param File $file
     * @param string $fileName
     * @return string
     */
    public function upload(File $file, string $fileName): string
    {
        try {
            $file->move($this->bag->get('images_directory'), $fileName);
        } catch (FileException $e) {
        }

        return $fileName;
    }
}