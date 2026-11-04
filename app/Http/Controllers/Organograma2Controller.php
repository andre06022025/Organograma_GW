<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Organograma2Controller extends Controller
{
    public function index()
    {
        $arvore = Colaborador::getArvoreOrganograma();

        return view('organograma2.index', compact('arvore'));
    }

    public function salvarPosicoes(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'ordens' => ['required', 'array'],
            'ordens.*.id' => ['required', 'integer', 'exists:colaboradores,id'],
            'ordens.*.ordem' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($dados['ordens'] as $item) {
            Colaborador::whereKey($item['id'])->update(['ordem' => $item['ordem']]);
        }

        return response()->json(['ok' => true]);
    }
}
