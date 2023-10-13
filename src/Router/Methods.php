<?php

namespace Routing\Router;

/**
 * Методы запросов
 */
class Methods
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public const METHODS = [
        self::GET => 'Получить',
        self::POST => 'Добавить',
        self::PUT => 'Обновить',
        self::DELETE => 'Удалить',
    ];
}
