<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chamadas', function (Blueprint $table) {
            // Cria campo para guardar o token anterior
            $table->string('previous_token', 20)->nullable()->after('current_token');
        });
    }

    public function down(): void
    {
        Schema::table('chamadas', function (Blueprint $table) {
            $table->dropColumn('previous_token');
        });
    }
};
