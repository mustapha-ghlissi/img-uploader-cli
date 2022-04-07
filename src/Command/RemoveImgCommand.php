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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RemoveImgCommand extends Command
{
    protected static $defaultName = 'app:remove-img';
    protected static $defaultDescription = 'Add a short description for your command';
    private ParameterBagInterface $bag;
    private FileHelper $fileHelper;

    /**
     * RemoveImgCommand constructor.
     * @param FileHelper $fileHelper
     * @param ParameterBagInterface $bag
     * @param string|null $name
     */
    public function __construct(FileHelper $fileHelper, ParameterBagInterface $bag, string $name = null)
    {
        parent::__construct($name);
        $this->fileHelper = $fileHelper;
        $this->bag = $bag;
    }


    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->ask('Enter image name', null,
            function ($fileName) use ($io) {
                if ($fileName) {
                    $pos = strrpos($fileName, '.');

                    if (!$pos) {
                        $io->error("Invalid image name.\nPlease make sure to enter a full image name including the extension.");
                        return Command::FAILURE;
                    }

                    $path = $this->bag->get('images_directory') . '/' . $fileName;
                    if (!file_exists($path)) {
                        $io->error('No image found for the given path.');
                        return Command::FAILURE;
                    }

                    $this->fileHelper->removeFile($path);
                    $io->success('Image deleted successfully.');
                    return Command::SUCCESS;
                }
                $io->error('No image found for the given name.');
                return Command::FAILURE;
            }
        );

        return Command::SUCCESS;
    }
}
