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
        Schema::table('favoritos', function (Blueprint $table) {
            $table->unique(['usuario_id', 'publicacao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {
         $table->dropUnique(['usuario_id', 'publicacao_id']);
        });
    }
};
