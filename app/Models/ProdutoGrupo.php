<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProdutoGrupo extends Model
{
    protected $table = 'produtos_grupos';
    protected $fillable = ['produto_id', 'grupo_id'];
}
