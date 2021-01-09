<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoConfiguracao extends Model
{
    protected $table = 'produtos_configuracoes';
    protected $fillable = [
        'nome',
        'valor',
    ];
}
