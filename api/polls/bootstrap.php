<?php

require __DIR__ . './../vendor/autoload.php';

$app = new Citsk\Application\App('/api/polls');

$app->registerFiles([
    './config/app.php',
]);

$app->initialize();
