<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('rotulo', 150)->nullable()->after('nome_completo');
            $table->string('regiao', 100)->nullable()->after('setor');
            $table->string('nivel', 20)->nullable()->after('regiao');
            $table->string('nivel_card', 50)->nullable()->after('nivel');
            $table->string('area', 20)->nullable()->after('nivel_card');
            $table->string('cor', 20)->default('roxo')->after('area');
            $table->unsignedSmallInteger('ordem')->default(0)->after('cor');
            $table->boolean('ric')->default(false);

            $table->index('nivel');
            $table->index('area');
        });
    }

    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropIndex(['nivel']);
            $table->dropIndex(['area']);
            $table->dropColumn(['rotulo', 'regiao', 'nivel', 'nivel_card', 'area', 'cor', 'ordem', 'ric']);
        });
    }
};
