<?php

namespace App\Http\Resources;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'tipo' => ProdutoEnum::getDescription($this->tipo_id),
            'visualizado' => $this->visualizado
        ];
    }
}
