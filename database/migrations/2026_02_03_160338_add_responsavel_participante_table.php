<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->unique()->after('email');
            $table->string('nome_responsavel')->nullable()->after('nascimento');
            $table->string('cpf_responsavel')->nullable()->after('nome_responsavel');
            $table->string('telefone_responsavel')->nullable()->after('cpf_responsavel');
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'nome_responsavel', 'cpf_responsavel', 'telefone_responsavel']);
        });
    }
};