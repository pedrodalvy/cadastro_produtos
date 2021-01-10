<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoDesconto extends Model
{
    protected $table = 'produtos_descontos';
    protected $fillable = [
        'produto_id',
        'valor',
        'data_limite'
    ];
    protected $dates = [
        'data_limite'
    ];
}
