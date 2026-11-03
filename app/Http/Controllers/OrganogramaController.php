<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\JsonResponse;

class OrganogramaController extends Controller
{
    /**
     * Ordem de exibição dos blocos (setores) por área.
     * Setores fora desta lista são agrupados ao final.
     */
    private const ORDEM_SETORES = [
        'producao' => [
            'Sistemas 1',
            'Sistemas 2',
            'Sistemas 3+4',
            'Sistemas 5',
            'Sistemas 6',
            'Sistemas 7',
            'Sistemas 8',
            'Sistemas 9',
        ],
        'apoio' => [
            'LABOR',
            'LICENC',
            'Manutenção de Poços',
            'Manutenção + Lodo',
            'CCO',
            'Engenharia de Processos',
        ],
    ];

    public function index()
    {
        $colaboradores = Colaborador::ativos()
            ->with(['grupo', 'gestor'])
            ->porNivel()
            ->get();

        $colunas = [
            'producao' => $this->montarColuna('producao', $colaboradores),
            'apoio' => $this->montarColuna('apoio', $colaboradores),
        ];

        // RIC é uma gestão compartilhada: reaproveita os mesmos colaboradores,
        // mas renderiza um card separado para cada um.
        $ric = $colaboradores->where('ric', true)
            ->sortBy('nome_completo')
            ->values();

        if ($ric->isNotEmpty()) {
            $colunas['apoio']['grupos'][] = [
                'titulo' => 'RIC',
                'membros' => $ric,
                'badge' => 'Gestão compartilhada',
                'areaForcada' => 'apoio',
            ];
        }

        $raiz = $colaboradores->firstWhere('nivel', 'direcao')
            ?? $colaboradores->firstWhere('gestor_id', null);

        $estatisticas = [
            'total' => $colaboradores->count(),
        ];

        return view('organograma.index', compact('colunas', 'raiz', 'estatisticas'));
    }

    private function montarColuna(string $area, $todos): array
    {
        $daArea = $todos->where('area', $area);

        $superintendencias = $daArea
            ->where('nivel', 'superintendencia')
            ->sortBy('ordem')
            ->values();

        $membros = $daArea->whereNotIn('nivel', ['superintendencia']);

        // Destaques transversais (ex.: Gerência Corporativa)
        $destaques = $membros
            ->where('setor', 'Gerência Corporativa')
            ->sortBy('ordem')
            ->values();

        $membros = $membros->where('setor', '!=', 'Gerência Corporativa');

        $ordem = self::ORDEM_SETORES[$area] ?? [];

        $grupos = [];
        foreach ($ordem as $setor) {
            $membrosSetor = $membros
                ->where('setor', $setor)
                ->sortBy('ordem')
                ->values();

            if ($membrosSetor->isNotEmpty()) {
                $grupos[] = [
                    'titulo' => $setor,
                    'membros' => $membrosSetor,
                    'badge' => null,
                    'areaForcada' => null,
                ];
            }
        }

        // Setores não mapeados (segurança para dados futuros)
        $naoMapeados = $membros->whereNotIn('setor', $ordem)->groupBy('setor');
        foreach ($naoMapeados as $setor => $itens) {
            $grupos[] = [
                'titulo' => $setor ?: 'Sem setor',
                'membros' => $itens->sortBy('ordem')->values(),
                'badge' => null,
                'areaForcada' => null,
            ];
        }

        return [
            'titulo' => Colaborador::AREAS[$area],
            'area' => $area,
            'superintendencias' => $superintendencias,
            'destaques' => $destaques,
            'grupos' => $grupos,
        ];
    }

    public function detalhes($id): JsonResponse
    {
        $colaborador = Colaborador::with(['gestor', 'grupo'])->findOrFail($id);

        return response()->json([
            'id' => $colaborador->id,
            'nome' => $colaborador->nome_completo,
            'cargo' => $colaborador->cargo,
            'nivel' => $colaborador->nivel,
            'label_nivel' => $colaborador->nivel_label,
            'cor_nivel' => $colaborador->cor_nivel,
            'area' => $colaborador->area,
            'setor' => $colaborador->setor,
            'area_atuacao' => $colaborador->setor,
            'responsabilidades' => null,
            'email' => $colaborador->email,
            'ramal' => null,
            'foto_url' => $colaborador->foto_url,
            'grupo' => $colaborador->grupo ? [
                'id' => $colaborador->grupo->id,
                'nome' => $colaborador->grupo->nome,
                'numero' => $colaborador->grupo->numero,
            ] : null,
            'gestor' => $colaborador->gestor ? [
                'nome' => $colaborador->gestor->nome_completo,
                'cargo' => $colaborador->gestor->cargo,
            ] : null,
        ]);
    }
}
