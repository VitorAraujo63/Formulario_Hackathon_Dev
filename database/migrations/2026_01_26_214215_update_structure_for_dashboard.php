<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Adicionar senha e status aos alunos para permitir login
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('password')->after('email_responsavel'); // Senha criptografada
            $table->string('status')->default('ativo'); // ativo/inativo
            $table->rememberToken();
        });

        // 2. Tabela de Aulas (Uploads/Links)
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('banner_path')->nullable(); // Caminho da imagem
            $table->string('arquivo_path')->nullable(); // PDF ou URL
            $table->string('tipo')->default('pdf'); // 'pdf' ou 'video_url'
            $table->timestamp('data_disponivel')->nullable();
            $table->timestamps();
        });

        // 3. Tabela de Avisos (Para o mural dos alunos)
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('conteudo');
            $table->foreignId('mentor_id')->constrained('mentores'); // Quem criou
            $table->boolean('visivel_todos')->default(true);
            $table->timestamps();
        });

        // 4. Tabela de Presenças (Chamada)
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->foreignId('aula_id')->nullable()->constrained('aulas'); // Pode ser vinculado a uma aula ou apenas data
            $table->date('data');
            $table->boolean('presente')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presencas');
        Schema::dropIfExists('avisos');
        Schema::dropIfExists('aulas');
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropColumn(['password', 'status', 'remember_token']);
        });
    }
};
