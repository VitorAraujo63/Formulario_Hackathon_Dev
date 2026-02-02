<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Criar a tabela de SESSÕES DE CHAMADA (O evento da aula ao vivo)
        Schema::create('chamadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentores');
            $table->string('titulo')->nullable(); // Ex: "Aula de React - Dia 25"
            $table->string('codigo_acesso', 10)->unique(); // Token da sala
            $table->boolean('ativa')->default(true);
            $table->timestamps();
        });

        // 2. Atualizar a tabela PRESENCAS existente
        Schema::table('presencas', function (Blueprint $table) {
            // Removemos campos que não servirão para o modelo dinâmico
            // (Se tiver dados, faça backup antes!)
            $table->dropColumn(['data', 'presente']);

            // Adicionamos o vínculo com a sessão de chamada
            $table->foreignId('chamada_id')->after('id')->constrained('chamadas')->onDelete('cascade');

            // Adicionamos controle de horário exato e se foi manual
            $table->timestamp('registrado_em')->useCurrent();
            $table->boolean('manual')->default(false);

            // Garante que o aluno não ganhe presença dupla na mesma chamada
            $table->unique(['chamada_id', 'aluno_id']);
        });
    }

    public function down(): void
    {
        // Reverter é complexo pois perdemos dados, mas aqui está a estrutura
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropForeign(['chamada_id']);
            $table->dropColumn(['chamada_id', 'registrado_em', 'manual']);
            $table->date('data')->nullable();
            $table->boolean('presente')->default(false);
        });

        Schema::dropIfExists('chamadas');
    }
};
