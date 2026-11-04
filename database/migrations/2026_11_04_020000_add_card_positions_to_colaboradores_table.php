<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->unsignedSmallInteger('card_coluna')->nullable()->after('ric');
            $table->unsignedSmallInteger('card_linha')->nullable()->after('card_coluna');
            $table->unsignedSmallInteger('card_colspan')->nullable()->after('card_linha');
        });
    }

    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn(['card_coluna', 'card_linha', 'card_colspan']);
        });
    }
};
