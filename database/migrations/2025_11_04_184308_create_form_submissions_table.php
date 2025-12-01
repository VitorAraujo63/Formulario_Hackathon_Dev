<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('curso')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('sobre')->nullable();

            $table->string('selected_area');
            $table->json('user_answers');

            $table->integer('score_total');
            $table->integer('score_facil');
            $table->integer('score_media');
            $table->integer('score_dificil');
            $table->string('calculated_level');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
