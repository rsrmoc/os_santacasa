<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastro', function (Blueprint $table) {
            $table->id('cd_cadastro');
            $table->string('nome_paciente', 100);
            $table->char('tipo_convenio', 3);
            $table->string('nome_convenio', 100)->nullable();
            $table->string('nome_medico', 100);
            $table->foreignId('cd_hospital')->constrained('hospital', 'cd_hospital');
            $table->date('data_cirurgia')->nullable();
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
        Schema::dropIfExists('cadastro');
    }
};
