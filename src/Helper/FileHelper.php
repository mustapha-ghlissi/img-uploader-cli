<?php


namespace App\Helper;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileHelper
{
    public const EXT_PNG = 'png';
    public const EXT_JPG = 'jpg';
    public const EXT_JPEG = 'jpeg';

    /**
     * @var SluggerInterface|null
     */
    private SluggerInterface $slugger;

    /**
     * @var Filesystem|null
     */
    private Filesystem $filesystem;

    /**
     * FileHelper constructor.
     * @param SluggerInterface $slugger
     * @param Filesystem $filesystem
     */
    public function __construct(SluggerInterface $slugger, Filesystem $filesystem)
    {
        $this->slugger = $slugger;
        $this->filesystem = $filesystem;
    }

    /**
     * @return string[]
     */
     private static function getExtensions(): array {
        return [
            self::EXT_JPG,
            self::EXT_JPEG,
            self::EXT_PNG,
        ];
    }

    /**
     * @param string $path
     * @param string $originalFilename
     * @param string $extension
     * @return array
     */
    public function generateTmpFile(string $path, string $originalFilename, string $extension): array {

        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename. '-' . uniqid() . '.' . $extension;
        $tmpPath = $this->filesystem->tempnam('/tmp', $fileName, ".{$extension}");
        copy($path, $tmpPath);
        return [
            'file' => new File($tmpPath, $originalFilename),
            'fileName' => $fileName,
        ];
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function checkExtension(string $extension): bool {
        return in_array($extension, self::getExtensions());
    }

    /**$
     * @param string $path
     * @return bool
     */
    public function removeFile(string $path): bool {
        if (file_exists($path)) {
            unlink($path);
            return true;
        }

        return false;
    }
}