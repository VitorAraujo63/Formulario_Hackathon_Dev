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
        Schema::table('aulas', function (Blueprint $table) {
        // Adicionando o que falta
        $table->foreignId('aula_categoria_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        $table->boolean('publicada')->default(false)->after('descricao');
        $table->boolean('fixada')->default(false)->after('publicada');

        // Removendo campos que agora serão múltiplos na tabela de recursos
        $table->dropColumn(['arquivo_path', 'tipo']);

        // Renomeando para seguir o padrão se desejar
        $table->renameColumn('data_disponivel', 'data_prevista');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
