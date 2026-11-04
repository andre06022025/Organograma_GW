<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->dropColumn(['contrato', 'data_contrato', 'informacoes']);
        });
    }

    public function down(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->string('contrato', 150)->nullable();
            $table->date('data_contrato')->nullable();
            $table->text('informacoes')->nullable();
        });
    }
};
