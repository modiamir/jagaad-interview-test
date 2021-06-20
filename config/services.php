<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Console\Command\Command;

return function(ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();
    $services = $configurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
        ->instanceof(Command::class)
            ->tag('console.command')
    ;

    // Define Parameters Here
    // ...

    // Register Service Here
    $services->load('App\\', '../src/*')
        ->exclude('../src/Application.php');

};
