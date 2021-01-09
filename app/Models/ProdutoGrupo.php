<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProdutoGrupo extends Model
{
    protected $table = 'produtos_grupos';
    protected $with = ['produto'];

    public function produto(): HasOne
    {
        return $this->hasOne(Produto::class, 'id', 'produto_id');
    }
}
