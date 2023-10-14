<?php

namespace Routing\Router;

use Exception;
use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Маршрутизатор
 */
class Router
{

    /**
     * Карта маршрутов
     * приложения
     *
     * @var array
     */
    private $map = [];

    /**
     * Построенные маршруты
     *
     * @var array
     */
    private $routes = [];

    public function __construct(RouteMap $routeMap)
    {
        $this->map = $routeMap->getRoutes();
    }

    /**
     * Инициализирует маршруты
     * в приложении
     *
     * @param App $app
     *
     * @return App
     */
    public function initRoutes(App $app): App
    {
        $container = $app->getContainer();
        $this->constructRoutes($this->map);
        foreach ($this->getRoutes() as $route) {
            $method = $route['method'];
            $path = $route['path'];
            $class = $route['class'];
            $action = $route['action'];
            $fullpath = '/' . trim($path, '/');
            $app->$method($fullpath, function (ServerRequestInterface $request, ResponseInterface $response, array $args) use ($container, $class, $action) {
                return (new $class($container, $request, $response, $args))->$action();
            });
        }
        return $app;
    }

    /**
     * Получает массив маршрутов
     * в обратном порядке
     */
    private function getRoutes(): array
    {
        return array_reverse($this->routes);
    }

    /**
     * Строит маршруты
     *
     * @param array $map
     * @param string $pathPrefix
     *
     * @return void
     */
    private function constructRoutes(array $map, string $pathPrefix = ''): void
    {
        foreach ($map as $path => $class) {
            if (is_array($class)) {
                $this->constructRoutes($class, $pathPrefix . $path);
            } else {
                foreach($class::MAP as $method => $description) {
                    if (!array_key_exists($method, Methods::METHODS)) {
                        throw new Exception('Метод ' . $method . ' в классе ' . $class . ' не поддерживается!');
                    }
                    foreach ($description as $subPath => $action) {
                        $this->routes[] = [
                            'path' => $pathPrefix . $path . ($subPath == '/' ? '' : $subPath),
                            'class' => $class,
                            'method' => strtolower($method),
                            'action' => $action,
                        ];
                    }
                }
            }
        }
    }
}
