<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_id')->nullable()->after('setor');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('set null');
            $table->index('grupo_id');
        });
    }

    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            $table->dropIndex(['grupo_id']);
            $table->dropColumn('grupo_id');
        });
    }
};