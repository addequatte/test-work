<?php

namespace Addequatte\Newspaper;

use Addequatte\Newspaper\Services\RouterService;

class Application
{
    private RouterService $routeService;


    public function __construct()
    {
        $this->routeService = new RouterService();
    }

    public function run():void
    {
        $this->routeService->do();
    }
}