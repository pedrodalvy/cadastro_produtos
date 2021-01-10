<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    public function configuracoes(): HasMany
    {
        return $this->hasMany(ProdutoConfiguracao::class, 'produto_id', 'id');
    }

    public function grupo(): HasOneThrough
    {
        return $this->hasOneThrough(
            __CLASS__,
            ProdutoGrupo::class,
            'produto_id',
            'id',
            'id',
            'grupo_id'
        );
    }

    public function agrupar(): HasOne
    {
        return $this->hasOne(ProdutoGrupo::class, 'grupo_id', 'id');
    }

    public function produtosAgrupados(): HasManyThrough
    {
        return $this->hasManyThrough(
            __CLASS__,
            ProdutoGrupo::class,
            'grupo_id',
            'id',
            'id',
            'produto_id'
        );
    }
}
