<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200);
            $table->string('tipo', 10); // ETA ou EPAR
            $table->timestamps();

            $table->unique(['nome', 'tipo']);
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadastros');
    }
};
