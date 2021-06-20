<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$containerBuilder = new ContainerBuilder();
$loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__.'/../config'));
$loader->load('services.php');
$containerBuilder->addCompilerPass(new AddConsoleCommandPass());
$containerBuilder->compile();

return $containerBuilder;
