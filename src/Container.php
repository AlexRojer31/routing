<?php

namespace Routing;

use Routing\ServiceProvider\ApplicationProvider;
use Routing\ServiceProvider\ApplicationProviderInterface;
use Slim\Container as SlimContainer;

/**
 * Контейнер
 */
class Container extends SlimContainer
{

    /**
     * кофигурация приложения
     *
     * @var array
     */
    protected $config;

    /**
     * Сервис провайдеры
     *
     * @var array
     */
    protected $serviceProviders;

    /**
     * @param array $config
     * @param array<ApplicationProviderInterface> $serviceProviders
     */
    public function __construct(array $config = [], array $serviceProviders = [])
    {
        parent::__construct($config);
        $this->config = $config;
        $this->serviceProviders = array_merge([
            ApplicationProvider::class,
        ], $serviceProviders);
        $this->setServices();
    }

    /**
     * Устанавливает сервисы
     * приложения
     *
     * @var array
     */
    protected function setServices(): void
    {
        foreach($this->serviceProviders as $serviceProvider) {
            (new $serviceProvider())->register($this);
        }
    }

    public function getConfig(): array
    {
        return $this->config;
    }

}
