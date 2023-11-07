<?php

namespace App\Core\Enum;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';

    public static function fromString(string $method): ?self
    {
        switch (strtoupper($method)) {
            case 'GET':
                return self::GET;
            case 'POST':
                return self::POST;
            case 'PUT':
                return self::PUT;
            case 'PATCH':
                return self::PATCH;
            case 'DELETE':
                return self::DELETE;
            default:
                return null;
        }
    }

    public static function getValues(): array
    {
        return [
            self::GET,
            self::POST,
            self::PATCH,
            self::PUT,
            self::DELETE,
        ];
    }
}
