<?php

namespace Locations;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Input\InputArgument;
use BeSimple\SoapClient\SoapFaultWithTracingData;
use Symfony\Component\Console\Helper\Table;
use Locations\ServiceProvider;

class TownCommand extends Command {

    /**
     * Configures CLI command
     */
    protected function configure() {
        $this->setName("town:name")
                ->setDescription("Searches UK locations by city 2 or 3 (town) names. "
                        . "Required at least two and\or maximum three city (town) names at one. "
                        . "City names should be separated by comma (,)")
                ->addArgument("cities", InputArgument::IS_ARRAY, "REQUIRED! City names should be separated by ','")
                ->addUsage("sample:info Little London, Londonderry, London Wall")
        ;
    }

    /**
     * Executes CLI command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws SoapFaultWithTracingData
     * @internal TASK: 2...exactly for two or three cities at one
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $inputCities = $input->getArgument('cities');
        $arguments = ServiceProvider::normalizeCityNames($inputCities);
        $argCount = count($arguments);
        if ($argCount > 1 && $argCount < 4) {
            $res=[];
            $output->writeln(sprintf("UK locations for: %s", implode(' ', $inputCities)));
            try {
                $ukLocations = new ServiceProvider();
                $res = $ukLocations->soapCall($arguments);
            } catch (SoapFaultWithTracingData $fault) {
                throw $fault;
            }

            if (count($res)) {
                $table = new Table($output);
                $table->setHeaders(array('PostCode', 'Town', 'County'));
                $rows = [];
                foreach ($res as $value) {
                    $rows[] = [$value->PostCode, $value->Town, $value->County];
                }
                $table->setRows($rows);
                $table->render();
            } else {
                $output->writeln("<info>No results</info>");
            }
        } else {
            $output->writeln(sprintf("<error>Required at least 2 or maximum 3 city (town) names:</error> %s (%d)", implode(' ', $inputCities), $argCount));
        }
    }

}
