<?php

use Locations\ReadmeCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

require_once './vendor/autoload.php';

class ReadMeCommandTest extends TestCase {

    public function testReadMeIsCorrect() {

        $application = new Application();
        $application->add(new ReadmeCommand());

        $command = $application->find('readme');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));

        $this->assertRegExp('/This is the default command for test/', $commandTester->getDisplay());
    }
}
