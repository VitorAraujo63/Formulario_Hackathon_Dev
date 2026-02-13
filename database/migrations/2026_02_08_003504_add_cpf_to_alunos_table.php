<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->unique()->after('email_aluno');
        });
    }

    public function down(): void
{
    Schema::table('alunos', function (Blueprint $table) {
        if (Schema::hasColumn('alunos', 'cpf')) {
            $table->dropColumn('cpf');
        }
    });
}
};