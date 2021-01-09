<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoLink extends Model
{
    protected $table = 'produtos_link';
    protected $fillable = ['link'];
}
