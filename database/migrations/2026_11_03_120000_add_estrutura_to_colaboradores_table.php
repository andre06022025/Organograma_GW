<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->string('nivel', 20)->nullable()->after('setor');
            $table->string('area', 20)->nullable()->after('nivel');
            $table->unsignedSmallInteger('ordem')->default(0)->after('area');
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
            $table->dropColumn(['nivel', 'area', 'ordem', 'ric']);
        });
    }
};
