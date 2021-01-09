<?php

namespace App\Http\Resources;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoDigitalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'tipo_id' => $this->tipo_id,
            'tipo' => ProdutoEnum::getDescription($this->tipo_id),
            'valor' => $this->valor,
            'link' => $this->link->link,
            'criado_em' => $this->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
