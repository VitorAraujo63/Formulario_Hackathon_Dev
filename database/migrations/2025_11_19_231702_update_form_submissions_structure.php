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
        Schema::table('form_submissions', function (Blueprint $table) {
            // 1. Alterar 'sobre' de STRING (255) para TEXT (ilimitado)
            // O método ->change() modifica a coluna existente
            $table->text('sobre')->nullable()->change();

            // 2. Renomear 'score_media' para 'score_medio'
            // Verificamos se a coluna antiga existe antes de renomear para evitar erros
            if (Schema::hasColumn('form_submissions', 'score_media')) {
                $table->renameColumn('score_media', 'score_medio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // Reverter TEXT para STRING
            $table->string('sobre', 255)->nullable()->change();

            // Reverter 'score_medio' para 'score_media'
            if (Schema::hasColumn('form_submissions', 'score_medio')) {
                $table->renameColumn('score_medio', 'score_media');
            }
        });
    }
};
