<?php

namespace App\Http\Resources;

use App\Domain\Enums\ProdutoEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoAgrupadoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'tipo_id' => $this->tipo_id,
            'tipo' => ProdutoEnum::getDescription($this->tipo_id),
            'valor' => (float)$this->valor_atual,
            'criado_em' => $this->created_at->format('Y-m-d H:i:s'),
            'atualizado_em' => $this->updated_at->format('Y-m-d H:i:s'),
            'produtos_agrupados' => ProdutoSimplesResource::collection($this->produtosAgrupados)
        ];
    }
}
