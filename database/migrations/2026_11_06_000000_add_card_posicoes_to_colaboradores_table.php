<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Barras de liderança cujas posições salvas vieram da v1.9.7 (depois
     * revertida no código) e que hoje provocam sobreposição na coluna 7 da
     * Área de Apoio. São zeradas para voltar ao layout definido na view.
     */
    private const LIDERANCA = [
        'thiago@empresa.com.br',
        'renato.capuano@empresa.com.br',
        'arthur@empresa.com.br',
        'capuano@empresa.com.br',
    ];

    public function up(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            // JSON com uma entrada por área do organograma:
            // {"producao":{"posicao":{...},"align":"center","valign":"center"}}
            $table->longText('card_posicoes')->nullable()->after('ric');
        });

        // Migra as posições legadas (colunas card_*) para o formato por área.
        DB::table('colaboradores')
            ->whereNotNull('card_coluna')
            ->orderBy('id')
            ->chunk(100, function ($colaboradores) {
                foreach ($colaboradores as $colaborador) {
                    if (in_array($colaborador->email, self::LIDERANCA, true)) {
                        continue;
                    }

                    $area = $colaborador->area ?: 'producao';

                    $slot = [
                        'posicao' => [
                            'coluna' => (int) $colaborador->card_coluna,
                            'linha' => (int) $colaborador->card_linha,
                            'colspan' => (int) ($colaborador->card_colspan ?: 1),
                            'rowspan' => (int) ($colaborador->card_rowspan ?: 1),
                        ],
                        'align' => $colaborador->card_align ?: 'center',
                        'valign' => $colaborador->card_valign ?: 'center',
                    ];

                    if ($colaborador->card_texto !== null && $colaborador->card_texto !== '') {
                        $slot['texto'] = $colaborador->card_texto;
                    }

                    $atual = DB::table('colaboradores')
                        ->where('id', $colaborador->id)
                        ->value('card_posicoes');

                    $posicoes = json_decode((string) $atual, true) ?: [];
                    $posicoes[$area] = $slot;

                    DB::table('colaboradores')
                        ->where('id', $colaborador->id)
                        ->update(['card_posicoes' => json_encode($posicoes, JSON_UNESCAPED_UNICODE)]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropColumn('card_posicoes');
        });
    }
};
