<?php

use Locations\TownCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

require_once './vendor/autoload.php';

class TownCommandTest extends TestCase {

    private $application;
    private $command;
    private $commandTester;

    public function __construct($name = null, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->application = new Application();
        $this->application->add(new TownCommand());
        $this->command = $this->application->find('town:name');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * test 2 city names
     */
    public function testTwoCityNames() {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'cities' => ['Little', 'London,', 'Dalblair']
        ));
        $this->assertContains('UK locations for: Little London, Dalblair', $this->commandTester->getDisplay(true), "test 2 city names");
    }

    /**
     * test 3 city names
     */
    public function testThreeCityNames() {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'cities' => ['Little', 'London,', 'Dalblair,', 'Conisholme']
        ));

        $this->assertContains('UK locations for: Little London, Dalblair, Conisholme'
                , $this->commandTester->getDisplay(true), "test 3 city names");
    }

    /**
     * test less city names
     */
    public function testLessCityNames() {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'cities' => ['Little', 'London']
        ));

        $this->assertContains('Required at least 2 or maximum 3 city'
                , $this->commandTester->getDisplay(true), "test less city names");
    }

    /**
     * test more city names 
     */
    public function testMoreCityNames() {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'cities' => ['Colbost,', 'London,', 'Dalblair,', 'Conisholme']
        ));

        $this->assertContains('Required at least 2 or maximum 3 city'
                , $this->commandTester->getDisplay(true), "test more city names");
    }

}
