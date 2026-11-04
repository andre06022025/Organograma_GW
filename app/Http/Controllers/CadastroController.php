<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function index(Request $request)
    {
        $query = Cadastro::query();

        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where('nome', 'like', "%{$termo}%");
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // A paginação/ordenação é feita pelo DataTable no cliente.
        $cadastros = $query->orderBy('nome')->get();

        $tipos = Cadastro::query()
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        return view('cadastros.index', compact('cadastros', 'tipos'));
    }
}
