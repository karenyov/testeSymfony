<?php

namespace App\Core\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Core\Enum\HttpMethod;

class HttpMethodType extends AbstractEnumType
{
    public const NAME = 'httpMethod';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR(10)';
    }

    public static function getEnumsClass(): string
    {
        return HttpMethod::class;
    }
}
