<?php

use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('__BASE_DIR__', dirname(__DIR__));

try{
    (new Dotenv())->usePutenv()->bootEnv(__BASE_DIR__ . '/.env');

    $application = new \Addequatte\Newspaper\Application();

    $application->run();
}catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}

