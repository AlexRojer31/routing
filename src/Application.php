<?php

namespace Routing;

use Routing\Router\RouteMap;
use Routing\Router\Router;
use Slim\App;

/**
 * Приложение
 */
class Application
{

    /**
     * Запускает приложение
     *
     * @param array $config
     * @param array $providers
     * @param array $routes
     */
    public static function start(array $config = [], array $providers = [], array $routes = []): void
    {
        $container = new Container($config, $providers);
        $router = new Router(new RouteMap($routes));
        $app = new App($container);
        $app = $router->initRoutes($app);

        $app->run();
    }

}
