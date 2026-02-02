<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->nullable()->constrained('mentores')->onDelete('set null'); // Quem fez?
            $table->string('acao'); // Ex: 'Criou Mentor', 'Excluiu Mentor'
            $table->text('descricao'); // Detalhes: 'Criou o mentor João'
            $table->string('ip_address')->nullable(); // Para segurança extra
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
