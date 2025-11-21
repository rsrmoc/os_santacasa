<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastroProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastro_produtos', function (Blueprint $table) {
            $table->id('cd_cad_produto');
            $table->foreignId('cd_cadastro')->constrained('cadastro', 'cd_cadastro');
            $table->foreignId('cd_produto')->constrained('produto', 'cd_produto');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cadastro_produtos');
    }
};
