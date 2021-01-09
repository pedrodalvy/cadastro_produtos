<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo_id',
        'valor',
        'visualizado'
    ];

    public function link(): HasOne
    {
        return $this->hasOne(ProdutoLink::class, 'produto_id', 'id');
    }
}
