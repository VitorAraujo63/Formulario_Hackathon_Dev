<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela de Definição de Permissões (O que existe no sistema)
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Gerenciar Alunos"
            $table->string('slug')->unique(); // Ex: "manage_alunos" (usado no código)
            $table->string('group')->nullable(); // Para organizar no visual (Ex: "Acadêmico")
            $table->timestamps();
        });

        // 2. Tabela Pivô (Quem tem qual permissão)
        Schema::create('mentor_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentores')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');

            // Evita duplicatas
            $table->unique(['mentor_id', 'permission_id']);
        });

        // Vamos popular as permissões iniciais automaticamente
        DB::table('permissions')->insert([
            ['name' => 'Gerenciar Alunos', 'slug' => 'manage_alunos', 'group' => 'Acadêmico'],
            ['name' => 'Fazer Chamada', 'slug' => 'manage_chamada', 'group' => 'Acadêmico'],
            ['name' => 'Mural de Avisos', 'slug' => 'manage_avisos', 'group' => 'Comunicação'],
            ['name' => 'Upload de Aulas', 'slug' => 'manage_aulas', 'group' => 'Conteúdo'],
            ['name' => 'Gerenciar Equipe (Admin)', 'slug' => 'manage_mentores', 'group' => 'Administrativo'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_permissions');
        Schema::dropIfExists('permissions');
    }
};
