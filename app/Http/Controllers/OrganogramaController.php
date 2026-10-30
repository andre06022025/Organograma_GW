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
        $colaborador = Colaborador::with('gestor')->findOrFail($id);

        $user = auth()->user();
        $podeVerConfidencial = $user ? $user->isGestao() : false;

        return response()->json([
            'id' => $colaborador->id,
            'nome' => $colaborador->nome_completo,
            'cargo' => $colaborador->cargo,
            'setor' => $colaborador->setor,
            'email' => $colaborador->email,
            'foto_url' => $colaborador->foto_url,
            'gestor' => $colaborador->gestor ? [
                'nome' => $colaborador->gestor->nome_completo,
                'cargo' => $colaborador->gestor->cargo,
            ] : null,
            'pode_ver_confidencial' => $podeVerConfidencial,
        ]);
    }
}