<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->unsignedBigInteger('gestor_id')->nullable()->after('tipo');
            $table->string('sistema', 100)->nullable()->after('gestor_id');
            $table->string('contrato', 150)->nullable()->after('sistema');
            $table->date('data_contrato')->nullable()->after('contrato');
            $table->text('informacoes')->nullable()->after('data_contrato');

            $table->foreign('gestor_id')->references('id')->on('colaboradores')->onDelete('set null');
            $table->index('gestor_id');
            $table->index('sistema');
        });
    }

    public function down(): void
    {
        Schema::table('cadastros', function (Blueprint $table) {
            $table->dropForeign(['gestor_id']);
            $table->dropIndex(['gestor_id']);
            $table->dropIndex(['sistema']);
            $table->dropColumn(['gestor_id', 'sistema', 'contrato', 'data_contrato', 'informacoes']);
        });
    }
};
