<?php

namespace App\Domain\Enums;

use BenSampo\Enum\Enum;

class ProdutoEnum extends Enum
{
    public const PRODUTO_SIMPLES = 1;
    public const PRODUTO_DIGITAL = 2;
    public const PRODUTO_CONFIGURAVEL = 3;
    public const PRODUTO_AGRUPADO = 4;
}
