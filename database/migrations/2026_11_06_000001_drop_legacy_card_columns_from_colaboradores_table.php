<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // As posições passam a viver em `card_posicoes` (JSON por área).
        // As colunas antigas viram redundantes e são removidas.
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn([
                'card_coluna',
                'card_linha',
                'card_colspan',
                'card_rowspan',
                'card_texto',
                'card_align',
                'card_valign',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->unsignedSmallInteger('card_coluna')->nullable()->after('ric');
            $table->unsignedSmallInteger('card_linha')->nullable()->after('card_coluna');
            $table->unsignedSmallInteger('card_colspan')->nullable()->after('card_linha');
            $table->unsignedSmallInteger('card_rowspan')->default(1)->after('card_colspan');
            $table->string('card_texto', 255)->nullable()->after('card_rowspan');
            $table->string('card_align', 10)->default('center')->after('card_texto');
            $table->string('card_valign', 10)->default('center')->after('card_align');
        });
    }
};
