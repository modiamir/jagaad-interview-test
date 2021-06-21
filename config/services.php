<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    $services->set(CamelCaseToSnakeCaseNameConverter::class, CamelCaseToSnakeCaseNameConverter::class);
    $services->set(PhpDocExtractor::class, PhpDocExtractor::class);
    $services->set(ArrayDenormalizer::class, ArrayDenormalizer::class);
    $services
        ->set(ObjectNormalizer::class, ObjectNormalizer::class)
        ->args([null, service(CamelCaseToSnakeCaseNameConverter::class), null, service(PhpDocExtractor::class)])
    ;
    $services
        ->set(Serializer::class, Serializer::class)
        ->args([
            [service(ObjectNormalizer::class), service(ArrayDenormalizer::class)]
        ])
    ;

};
