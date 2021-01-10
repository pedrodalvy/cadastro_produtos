<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_produtos', function (Blueprint $table) {
            $table->id();
            $table->json('valores_antigos');
            $table->json('valores_novos');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('usuario_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_produtos');
    }
}
