<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('chamadas', function (Blueprint $table) {
            // Remove a restrição de ser único
            // O nome do índice geralmente é "tabela_coluna_unique"
            $table->dropUnique('chamadas_codigo_acesso_unique');
        });
    }

    public function down()
    {
        Schema::table('chamadas', function (Blueprint $table) {
            $table->unique('codigo_acesso');
        });
    }
};
