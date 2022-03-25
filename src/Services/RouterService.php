<?php

namespace Addequatte\Newspaper\Services;


use Addequatte\Newspaper\Exceptions\NotExistRouteMethod;

class RouterService
{
    private array $get = [];

    private array $post = [];

    /**
     * @var ServerService
     */
    private ServerService $serverService;


    /**
     * @throws NotExistRouteMethod
     */
    public function __construct()
    {
        $this->serverService = new ServerService();
        $this->init();
    }

    /**
     * @return void
     * @throws NotExistRouteMethod
     */
    private function init(): void
    {
        foreach (require_once __BASE_DIR__ . '/config/routes.php' as $path => $route) {

            $foo = $this->matchInitMethod($path);

            $clearPath = preg_replace('/^.+\|/', '', $path);

            $this->$foo($clearPath, $route['class'], $route['foo']);
        }
    }

    /**
     * @param string $path
     * @param string $class
     * @param string $foo
     * @return void
     */
    public function get(string $path, string $class, string $foo): void
    {
        $this->set($path, $class, $foo);
    }

    /**
     * @param string $path
     * @param string $class
     * @param string $foo
     * @return void
     */
    public function post(string $path, string $class, string $foo): void
    {
        $this->set($path, $class, $foo, 'post');
    }

    /**
     * @param string $path
     * @param string $class
     * @param string $foo
     * @param string $type
     * @return void
     */
    private function set(string $path, string $class, string $foo, string $type = 'get'): void
    {
        $this->$type[$path] =
            [
                'class' => $class,
                'foo' => $foo
            ];
    }

    /**
     * @param string $path
     * @return string
     */
    private function prepare(string $path): string
    {
        return preg_replace(['/<.+?>/', '/\//'], ['(.+)', '\/'], $path);
    }

    /**
     * @param string $reqPath
     * @param $routePath
     * @return array
     */
    private function matchParams(string $reqPath, $routePath): array
    {
        $result = [];

        preg_match_all('/<(.+?)>/', $routePath, $routeMatch);

        $prepare = $this->prepare($routePath);

        preg_match_all('/' . $prepare . '/', $reqPath, $reqMatch);

        foreach ($routeMatch[1] ?? [] as $key => $param) {
            $result[$param] = $reqMatch[$key + 1][0] ?? null;
        }
        return $result;
    }

    /**
     * @param string $path
     * @return string
     * @throws NotExistRouteMethod
     */
    private function matchInitMethod(string $path): string
    {
        preg_match('/(^.+)\|/', $path, $match);

        $match = $match[1] ?? 'GET';
        switch ($match) {
            case 'GET':
                return 'get';
            case 'POST':
                return 'post';
            default:
                throw new NotExistRouteMethod('Не поддерживаемый метод запроса ' . $match);
        }
    }

    /**
     * @return string
     * @throws NotExistRouteMethod
     */
    private function matchRequestMethod(): string
    {
        $method = $this->serverService->get('REQUEST_METHOD');

        switch ($method) {
            case 'GET':
                return 'getRoute';
            case 'POST':
                return 'postRoute';
            default:
                throw new NotExistRouteMethod('Не поддерживаемый метод запроса ' . $method);
        };
    }


    /**
     * @param string $path
     * @return array|null
     */
    private function getRoute(string $path): ?array
    {
        return  $this->route($path);
    }

    /**
     * @param string $path
     * @return array|null
     */
    private function postRoute(string $path): ?array
    {
        return  $this->route($path, 'post');
    }

    /**
     * @param string $path
     * @param string $type
     * @return array|null
     */
    private function route(string $path, string $type = 'get'): ?array
    {
        foreach ($this->$type as $get => $item) {
            $prepared = $this->prepare($get);
            if(preg_match('/^' . $prepared . '$/', $path)) {
                return [$get, $item];
            }
        }
        return null;
    }

    /**
     * @return void
     * @throws NotExistRouteMethod
     */
    public function do()
    {
        $path = $this->serverService->get('REQUEST_URI');

        $foo = $this->matchRequestMethod();

        if (list($routePath, $route) = $this->$foo($path)) {

            $params = $this->matchParams($path, $routePath);

            $fn = $route['foo'];

            (new $route['class'])->$fn(...$params);
        }
    }
}