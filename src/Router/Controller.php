<?php

namespace Routing\Router;

use Messages\Message;
use Messages\MessageType;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\StatusCode;

/**
 * Абстрактный контроллер
 */
abstract class Controller
{

    /**
     * Контейнер
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Запрос
     *
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * Ответ
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Аргументы
     *
     * @var array
     */
    protected $args;

    /**
     * Карта маршрутов контроллера
     *
     * @var array
     */
    public const MAP = [
        Methods::GET => [
            '/' => 'index',
        ],
    ];

    /**
     * Контекст html страницы
     *
     * @var array
     */
    protected $context = [];

    /**
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->container->get('eloquent');
        $this->assert();
    }

    /**
     * Добавляет контекст на html старницу
     */
    protected function assert(): void {}

    /**
     * Получает IP
     *
     * @return string
     */
    protected function getIp(): string
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    /**
     * Получает UserAgent
     *
     * @return string
     */
    protected function getUserAgent(): string
    {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    /**
     * Рендерит html страницу
     *
     * @param string $template
     *
     * @return ResponseInterface
     */
    protected function html(string $template): ResponseInterface
    {
        $view = $this->container->get('twig')->render($template, $this->context);

        $body = $this->response->getBody();
        $body->write($view);

        return $this->response
            ->withStatus(StatusCode::HTTP_OK)
            ->withBody($body);
    }

    /**
     * JSON ответ
     *
     * @param array $arr
     *
     * @return ResponseInterface
     */
    protected function json(array $arr): ResponseInterface
    {
        $body = $this->response->getBody();
        $body->write(json_encode($arr));

        return $this->response
            ->withStatus(StatusCode::HTTP_OK)
            ->withAddedHeader('Accept', 'application/json')
            ->withAddedHeader('Content-Type', 'application/json')
            ->withBody($body);
    }

    /**
     * Перенаправляет на другую страницу
     *
     * @param string $url
     *
     * @return ResponseInterface
     */
    protected function redirect(string $url = '/'): ResponseInterface
    {
        return $this->response->withRedirect($url); // Метод существует - не ошибка
    }

    /**
     * 404
     *
     * @return ResponseInterface
     */
    protected function notFound(): ResponseInterface
    {
        $message = new Message('Ресурс не найден', MessageType::WARNING);
        return $this->json($message->toArray());
    }

    /**
     * Дефолтный метод маршрута
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $message = new Message('Использование дефолтного метода маршрута должно быть переопределено!', MessageType::WARNING);
        return $this->json($message->toArray());
    }

}
