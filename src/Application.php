<?php

namespace App;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        if ($container->has('console.command_loader')) {
            $this->setCommandLoader($container->get('console.command_loader'));
        }
    }
}