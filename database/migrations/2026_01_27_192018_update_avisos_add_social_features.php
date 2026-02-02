<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Alterar a tabela existente 'avisos'
        Schema::table('avisos', function (Blueprint $table) {
            // Adiciona a imagem se não existir
            if (!Schema::hasColumn('avisos', 'imagem')) {
                $table->string('imagem')->nullable()->after('conteudo');
            }
            // Adiciona o fixado se não existir
            if (!Schema::hasColumn('avisos', 'fixado')) {
                $table->boolean('fixado')->default(false)->after('visivel_todos');
            }
        });

        // 2. Criar a tabela de curtidas (que não existia na sua versão)
        if (!Schema::hasTable('aviso_likes')) {
            Schema::create('aviso_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('aviso_id')->constrained('avisos')->onDelete('cascade');
                $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade');
                $table->timestamp('created_at'); // Data da curtida

                // Garante que o aluno só curte uma vez o mesmo aviso
                $table->unique(['aviso_id', 'aluno_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('aviso_likes');

        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['imagem', 'fixado']);
        });
    }
};
