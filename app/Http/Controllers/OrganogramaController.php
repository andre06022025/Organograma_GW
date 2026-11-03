<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrganogramaController extends Controller
{
    public function index()
    {
        $arvore = Colaborador::getArvoreOrganograma();
        $estatisticas = [
            'total' => Colaborador::ativos()->count(),
        ];

        return view('organograma.index', compact('arvore', 'estatisticas'));
    }

    public function api(): JsonResponse
    {
        $arvore = Colaborador::getArvoreOrganograma();
        return response()->json(['arvore' => $arvore]);
    }

    public function buscar(Request $request): JsonResponse
    {
        $termo = $request->get('q', '');

        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        $resultados = Colaborador::ativos()
            ->where(function ($q) use ($termo) {
                $q->where('nome_completo', 'like', "%{$termo}%")
                  ->orWhere('cargo', 'like', "%{$termo}%")
                  ->orWhere('setor', 'like', "%{$termo}%");
            })
            ->limit(20)
            ->get(['id', 'nome_completo', 'cargo', 'setor', 'foto_url'])
            ->map(fn($c) => [
                'id' => $c->id,
                'nome' => $c->nome_completo,
                'cargo' => $c->cargo,
                'setor' => $c->setor,
                'foto_url' => $c->foto_url,
            ]);

        return response()->json($resultados);
    }

    public function detalhes($id): JsonResponse
    {
        $colaborador = Colaborador::with(['gestor', 'grupo'])->findOrFail($id);

        return response()->json([
            'id' => $colaborador->id,
            'nome' => $colaborador->nome_completo,
            'cargo' => $colaborador->cargo,
            'nivel' => null,
            'label_nivel' => 'Colaborador',
            'cor_nivel' => 'bg-lte-orange',
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
            'pode_ver_confidencial' => false,
        ]);
    }
}