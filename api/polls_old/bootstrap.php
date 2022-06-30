<?php

require __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . "./Utils/functions.php";

\Dotenv\Dotenv::createImmutable(__DIR__)->load();

return new RegionalPolls\Http\Router;
