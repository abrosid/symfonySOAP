#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Locations\TownCommand;
use Locations\ReadmeCommand;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * @internal TASK:1. Create an php cli application...
 */
$app = new Application("UK Locations", "0.0.1");

/**
 * Custom default command to display "readme" info
 */
$defaultCommand = new ReadmeCommand();
$app->add($defaultCommand);
$app->setDefaultCommand($defaultCommand->getName());

/**
 * Handling errors by Event Dispatcher
 */
$dispatcher = new EventDispatcher();
$dispatcher->addListener(ConsoleEvents::ERROR, function(ConsoleErrorEvent $event) {
    $output = $event->getOutput();
    $command = $event->getCommand();
    if ($command) {
        $output->writeln(sprintf("An error has occured on command: <info>%s<info>", $command->getName()));
    } else {
        $output->writeln("<error>Command is not defined:<info> try to use list ");
    }
});
$app->setDispatcher($dispatcher);

/**
 * Registering CLI commands
 */
$app->add(new TownCommand());

//Here we go...
$app->run();
