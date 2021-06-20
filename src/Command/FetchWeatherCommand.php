<?php

namespace App\Command;

use App\Action\FetchWeatherActionInterface;
use App\WeatherLogger\ConsoleWeatherLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\OutputInterface as ConsoleOutputInterface;

class FetchWeatherCommand extends Command
{
    protected static $defaultName = 'cities:fetch-weather';

    private FetchWeatherActionInterface $fetchWeatherAction;

    public function __construct(FetchWeatherActionInterface $fetchWeatherAction)
    {
        parent::__construct();
        $this->fetchWeatherAction = $fetchWeatherAction;
    }

    public function execute(InputInterface $input, ConsoleOutputInterface $output)
    {
        $logger = $this->createWeatherLogger($output);
        ($this->fetchWeatherAction)($logger);

        return self::SUCCESS;
    }

    protected function createWeatherLogger(OutputInterface $output): ConsoleWeatherLogger
    {
        return new ConsoleWeatherLogger($output);
    }
}
