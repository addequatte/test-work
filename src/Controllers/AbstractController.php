<?php

namespace Addequatte\Newspaper\Controllers;

use Addequatte\Newspaper\Services\RequestService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AbstractController
{
    private Environment $twig;

    /**
     * @var RequestService
     */
    private RequestService $requestService;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(__BASE_DIR__ . '/templates'));

        $this->requestService = new RequestService();
    }

    /**
     * @return Environment
     */
    protected function twig(): Environment
    {
        return $this->twig;
    }

    /**
     * @return RequestService
     */
    protected function request(): RequestService
    {
        return $this->requestService;
    }
}