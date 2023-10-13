<?php

namespace Routing\Router;

/**
 * Карта маршрутов
 */
class RouteMap
{
    /**
     * Карта маршрутов
     * приложения
     *
     * @var array
     */
    private $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
