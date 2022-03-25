<?php

namespace Addequatte\Newspaper\Services;

class RequestService
{
    private array $get = [];

    private array $post = [];

    private array $request = [];

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get(string $key = '', string $default = ''): mixed
    {
        return $key ? $this->get[$key] ?? $default : $this->get;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function post(string $key = '', string $default = ''): mixed
    {
        return $key ? $this->post[$key] ?? $default : $this->post;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function request(string $key = '', string $default = ''): mixed
    {
        return $key ? $this->request[$key] ?? $default : $this->request;
    }
}