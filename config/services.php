<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\ApiClient\CityApiClientInterface;
use App\ApiClient\ForecastApiClientInterface;
use App\DataProvider\CityProvider;
use App\DataProvider\CityProviderInterface;
use App\DataProvider\ForecastProvider;
use App\DataProvider\ForecastProviderInterface;
use App\Normalizer\CityDenormalizer;
use App\Normalizer\Denormalizer;
use App\Normalizer\ForecastDenormalizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    $services->set(Denormalizer::class, Denormalizer::class)
        ->args([
            [service(ForecastDenormalizer::class), service(CityDenormalizer::class)]
        ]);

    $services->set(HttpClientInterface::class)->factory([HttpClient::class, 'create']);

    $services->set(CityProviderInterface::class, CityProvider::class)
        ->args([service(CityApiClientInterface::class), service(Denormalizer::class)]);

    $services->set(ForecastProviderInterface::class, ForecastProvider::class)
        ->args([service(ForecastApiClientInterface::class), service(Denormalizer::class)]);

    $services->alias(DenormalizerInterface::class, Serializer::class);
};
