<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogProduto extends Model
{
    protected $table = 'log_produtos';
    protected $fillable = [
        'valores_antigos',
        'valores_novos',
        'produto_id',
        'usuario_id',
    ];
}
