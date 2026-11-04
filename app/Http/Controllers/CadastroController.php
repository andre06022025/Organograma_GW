<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function create()
    {
        $cadastro = new Cadastro();

        return view('cadastros.create', compact('cadastro'));
    }

    public function store(Request $request): RedirectResponse
    {
        Cadastro::create($this->validar($request));

        return redirect()
            ->route('cadastros.index')
            ->with('success', 'Cadastro criado com sucesso!');
    }

    public function edit(Cadastro $cadastro)
    {
        return view('cadastros.edit', compact('cadastro'));
    }

    public function update(Request $request, Cadastro $cadastro): RedirectResponse
    {
        $cadastro->update($this->validar($request));

        return redirect()
            ->route('cadastros.index')
            ->with('success', 'Cadastro atualizado com sucesso!');
    }

    private function validar(Request $request): array
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:200'],
            'tipo' => ['required', Rule::in(array_keys(Cadastro::TIPOS))],
            'operacao' => ['nullable', 'string', 'max:150'],
            'operadores' => ['nullable', 'array', 'max:4'],
            'operadores.*' => ['nullable', 'string', 'max:150'],
            'numero_pocos' => ['nullable', 'integer', 'min:0'],
            'quantidade_operadores' => ['nullable', 'integer', 'min:0'],
        ], [
            'nome.required' => 'Informe o nome do cadastro.',
            'tipo.required' => 'Selecione o tipo (ETA ou EPAR).',
            'operadores.max' => 'Informe no máximo 4 operadores.',
        ]);

        $operadores = collect($dados['operadores'] ?? [])
            ->filter(fn ($nome) => filled($nome))
            ->values()
            ->all();

        $dados['operadores'] = $operadores ?: null;

        return $dados;
    }
}
