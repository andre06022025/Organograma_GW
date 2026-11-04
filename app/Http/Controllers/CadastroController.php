<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Colaborador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CadastroController extends Controller
{
    public function index(Request $request)
    {
        $query = Cadastro::with('gestor');

        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where('nome', 'like', "%{$termo}%");
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('gestor')) {
            $query->where('gestor_id', $request->gestor);
        }

        if ($request->filled('sistema')) {
            $query->where('sistema', $request->sistema);
        }

        // A paginação/ordenação é feita pelo DataTable no cliente.
        $cadastros = $query->orderBy('nome')->get();

        $tipos = Cadastro::query()
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        $gestores = $this->gestores();
        $sistemas = Cadastro::SISTEMAS;

        return view('cadastros.index', compact('cadastros', 'tipos', 'gestores', 'sistemas'));
    }

    public function create()
    {
        $cadastro = new Cadastro();
        $gestores = $this->gestores();
        $sistemas = Cadastro::SISTEMAS;

        return view('cadastros.create', compact('cadastro', 'gestores', 'sistemas'));
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
        $gestores = $this->gestores();
        $sistemas = Cadastro::SISTEMAS;

        return view('cadastros.edit', compact('cadastro', 'gestores', 'sistemas'));
    }

    public function update(Request $request, Cadastro $cadastro): RedirectResponse
    {
        $cadastro->update($this->validar($request));

        return redirect()
            ->route('cadastros.index')
            ->with('success', 'Cadastro atualizado com sucesso!');
    }

    private function gestores()
    {
        return Colaborador::whereNull('deleted_at')
            ->orderBy('nome_completo')
            ->get(['id', 'nome_completo', 'cargo']);
    }

    private function validar(Request $request): array
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:200'],
            'tipo' => ['required', Rule::in(array_keys(Cadastro::TIPOS))],
            'gestor_id' => ['nullable', Rule::exists('colaboradores', 'id')],
            'sistema' => ['nullable', Rule::in(array_keys(Cadastro::SISTEMAS))],
            'contrato' => ['nullable', 'string', 'max:150'],
            'data_contrato' => ['nullable', 'date'],
            'informacoes' => ['nullable', 'string'],
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
