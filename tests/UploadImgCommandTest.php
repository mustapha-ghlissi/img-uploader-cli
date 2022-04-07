<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UploadImgCommandTest extends KernelTestCase
{
    public function testExecute(){
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find('app:upload-img');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['/home/olinky/Desktop/success.jpg']);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Image uploaded successfully with name:', $output);
    }
}