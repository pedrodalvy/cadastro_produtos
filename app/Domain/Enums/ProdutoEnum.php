<?php

namespace App\Domain\Enums;

use BenSampo\Enum\Enum;

class ProdutoEnum extends Enum
{
    public const PRODUTO_SIMPLES = 1;
    public const PRODUTO_DIGITAL = 2;
    public const PRODUTO_CONFIGURAVEL = 3;
    public const PRODUTO_AGRUPADO = 4;

    public const DESCRICOES = [
        self::PRODUTO_SIMPLES => 'Produto Simples',
        self::PRODUTO_DIGITAL => 'Produto Digital',
        self::PRODUTO_CONFIGURAVEL => 'Produto Configurável',
        self::PRODUTO_AGRUPADO => 'Produto Agrupado',
    ];


    public static function getDescription($value): string
    {
        return self::DESCRICOES[$value] ?? '';
    }
}
