<?php

namespace Routing\ServiceProvider;

use Routing\Container;

interface ApplicationProviderInterface
{
    /**
     * Регистрация сервисов в контейнере
     */
    public function register(Container $c): void;
}
