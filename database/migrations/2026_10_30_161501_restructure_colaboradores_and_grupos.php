<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Recriar tabela grupos (apenas nome e número/id)
        // ATENÇÃO: não remover a tabela `users` aqui. Ela é criada pela migration
        // 0001_01_01_000000_create_users_table e alterada por
        // 2026_10_30_170000_add_custom_fields_to_users_table (que depende dela existir).
        Schema::dropIfExists('user_sistema');
        Schema::dropIfExists('grupos');
        
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('numero', 20)->unique(); // Número do grupo
            $table->timestamps();
        });

        // 2. Recriar tabela colaboradores com os campos solicitados
        Schema::dropIfExists('colaboradores');
        
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 150);
            $table->string('cargo', 100);
            $table->string('foto_path', 500)->nullable();
            $table->unsignedBigInteger('gestor_id')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('setor', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('gestor_id')->references('id')->on('colaboradores')->onDelete('set null');
            $table->index(['setor', 'cargo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
        Schema::dropIfExists('grupos');
    }
};