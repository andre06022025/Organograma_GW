<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('operador')->after('password');
            $table->string('status')->default('ativo')->after('role');
            $table->string('cargo', 100)->nullable()->after('status');
            $table->string('telefone', 20)->nullable()->after('cargo');
            $table->string('ramal', 20)->nullable()->after('telefone');
            $table->string('unidade', 100)->nullable()->after('ramal');
            $table->string('foto_path', 500)->nullable()->after('unidade');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->after('foto_path');
            $table->foreignId('gestor_id')->nullable()->constrained('users')->after('grupo_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grupo_id');
            $table->dropConstrainedForeignId('gestor_id');
            $table->dropColumn(['foto_path', 'unidade', 'ramal', 'telefone', 'cargo', 'status', 'role']);
        });
    }
};
