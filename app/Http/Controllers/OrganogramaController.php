<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\JsonResponse;

class OrganogramaController extends Controller
{
    public function index()
    {
        $colaboradores = Colaborador::ativos()
            ->with(['grupo', 'gestor'])
            ->porNivel()
            ->get();

        // Mapa por e-mail: o layout em grade referencia cada pessoa pela chave.
        $m = $colaboradores->keyBy('email');

        $raiz = $colaboradores->firstWhere('nivel', 'direcao')
            ?? $colaboradores->firstWhere('gestor_id', null);

        $estatisticas = [
            'total' => $colaboradores->count(),
        ];

        return view('organograma.index', compact('m', 'raiz', 'estatisticas'));
    }

    public function detalhes($id): JsonResponse
    {
        $colaborador = Colaborador::with(['gestor', 'grupo'])->findOrFail($id);

        return response()->json([
            'id' => $colaborador->id,
            'nome' => $colaborador->nome_completo,
            'cargo' => $colaborador->cargo,
            'nivel' => $colaborador->nivel,
            'nivel_card' => $colaborador->nivel_card_texto,
            'label_nivel' => $colaborador->nivel_label,
            'cor' => $colaborador->cor,
            'cor_nivel' => $colaborador->cor_nivel,
            'area' => $colaborador->area,
            'setor' => $colaborador->setor,
            'regiao' => $colaborador->regiao,
            'area_atuacao' => $colaborador->regiao ?: $colaborador->setor,
            'email' => $colaborador->email,
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
