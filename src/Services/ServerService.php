<?php

namespace Addequatte\Newspaper\Services;

class ServerService
{
    private array $server;

    public function __construct()
    {
        $this->server = $_SERVER;
    }

    public function get(string $key): mixed
    {
        return $this->server[$key] ?? null;
    }
}