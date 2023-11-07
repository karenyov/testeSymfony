<?php

namespace App\Core\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Core\Enum\Operacao;

class OperacaoType extends AbstractEnumType
{
    public const NAME = 'operacao';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'CHAR(1)';
    }

    public static function getEnumsClass(): string
    {
        return Operacao::class;
    }
}
