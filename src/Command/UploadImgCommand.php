<?php

namespace App\Command;

use App\Helper\FileHelper;
use App\Service\InnerUploader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UploadImgCommand extends Command
{
    protected static $defaultName = 'app:upload-img';
    protected static $defaultDescription = 'CLI app for uploading images';
    private InnerUploader $innerUploader;
    private FileHelper $fileHelper;

    /**
     * UploadImgCommand constructor.
     * @param FileHelper $fileHelper
     * @param InnerUploader $innerUploader
     * @param string|null $name
     */
    public function __construct(FileHelper $fileHelper, InnerUploader $innerUploader, string $name = null)
    {
        parent::__construct($name);
        $this->fileHelper = $fileHelper;
        $this->innerUploader = $innerUploader;
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title("Image CLI Uploader");
        $io->ask('Enter the image path', null,
            function ($path) use ($io) {
                if ($path) {
                    $pos = strrpos($path, '.');

                    if (!$pos) {
                        $io->error('Invalid image path.');
                        return Command::FAILURE;
                    }

                    $originalFilename = substr($path, 0, $pos);
                    $extension = strtolower(substr($path, $pos + 1, strlen($path)-1));

                    if ($this->fileHelper->checkExtension($extension)) {
                        if (!file_exists($path)) {
                            $io->error('No image found for the given path.');
                            return Command::FAILURE;
                        }
                        $tmpFile = $this->fileHelper->generateTmpFile($path, $originalFilename, $extension);
                        $file = $tmpFile['file'];
                        $fileName = $tmpFile['fileName'];
                        $fileName = $this->innerUploader->upload($file, $fileName);
                        $io->success(sprintf('Image uploaded successfully with name: %s', $fileName));
                        return Command::SUCCESS;
                    }

                    $io->error('Invalid file format: only files with formats png, jpg, jpeg are allowed.');
                    return Command::FAILURE;
                }
                $io->error('No image found for the given path.');
                return Command::FAILURE;
            }
        );

        return Command::SUCCESS;
    }
}
