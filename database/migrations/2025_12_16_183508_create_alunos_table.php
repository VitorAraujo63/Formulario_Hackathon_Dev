<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->date('data_nascimento');
            $table->string('email_aluno')->nullable();
            $table->string('telefone_aluno')->nullable();
            $table->string('escola');
            $table->string('serie');
            $table->string('nome_responsavel');
            $table->string('email_responsavel');
            $table->string('telefone_responsavel');
            $table->boolean('tem_conhecimento_previo')->default(false);
            $table->text('descricao_conhecimento')->nullable(); 
            $table->string('onde_nos_conheceu')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alunos');
    }
};