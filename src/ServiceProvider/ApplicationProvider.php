<?php

namespace Routing\ServiceProvider;

use Routing\Container;
use Illuminate\Database\Capsule\Manager;
use Twig_Environment;
use Twig_Loader_Filesystem;

class ApplicationProvider implements ApplicationProviderInterface
{
    public function register(Container $c): void
    {
        $c['twig'] = function ($c) {
            return new Twig_Environment(new Twig_Loader_Filesystem($c->getConfig()['templates']));
        };
        $c['eloquent'] = function($c) {
            $eloquent = new Manager();
            $eloquent->addConnection($c->getConfig()['db']);
            $eloquent->bootEloquent();
            return $eloquent;
        };
    }
}
