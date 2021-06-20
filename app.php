#!/usr/bin/env php

<?php

use App\Application;

$container = require __DIR__ . '/bootstrap/bootstrap_container.php';

$app = new Application($container);
$app->run();
