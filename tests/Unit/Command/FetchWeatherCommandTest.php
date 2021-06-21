<?php

namespace Tests\Unit\Command;

use App\Command\FetchWeatherCommand;
use App\WeatherLogger\ConsoleWeatherLogger;
use Hamcrest\Core\IsInstanceOf;
use Mockery\MockInterface;
use App\Action\FetchWeatherActionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\TestCase;

class FetchWeatherCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_calls_give_action(): void
    {
        // Arrange
        /** @var FetchWeatherActionInterface $fetchWeatherAction */
        $fetchWeatherAction = $this->initializeFetchWeatherAction();
        $sut = $this->initializeCommand($fetchWeatherAction);
        $input = new StringInput('');
        $output = new NullOutput();

        // Act
        $result = $sut->execute($input, $output);

        // Assert
        /** @var MockInterface $fetchWeatherAction */
        $fetchWeatherAction
            ->shouldHaveBeenCalled()
            ->once()
            ->with(IsInstanceOf::anInstanceOf(ConsoleWeatherLogger::class))
        ;
        $this->assertEquals(Command::SUCCESS, $result);
    }

    private function initializeFetchWeatherAction(): MockInterface
    {
        return $this->spy(FetchWeatherActionInterface::class);
    }

    private function initializeCommand(FetchWeatherActionInterface $fetchWeatherAction): FetchWeatherCommand
    {
        return new FetchWeatherCommand($fetchWeatherAction);
    }
}
