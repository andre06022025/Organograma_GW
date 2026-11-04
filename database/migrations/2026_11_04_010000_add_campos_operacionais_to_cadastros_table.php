<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->string('operacao', 150)->nullable()->after('tipo');
            $table->json('operadores')->nullable()->after('operacao');
            $table->unsignedInteger('numero_pocos')->nullable()->after('operadores');
            $table->unsignedInteger('quantidade_operadores')->nullable()->after('numero_pocos');
        });
    }

    public function down(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->dropColumn(['operacao', 'operadores', 'numero_pocos', 'quantidade_operadores']);
        });
    }
};
