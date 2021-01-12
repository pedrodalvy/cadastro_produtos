<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfiguracaoProdutoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'atributo' => $this->nome,
            'valor' => (string)$this->valor,
        ];
    }
}
