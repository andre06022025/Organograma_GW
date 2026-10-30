<?php

namespace App\Http\Controllers;

use App\Models\OrganogramaArea;
use App\Models\OrganogramaPessoa;
use App\Models\OrganogramaSistema;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class OrganogramaSistemaController extends Controller
{
    public function index()
    {
        $sistemas = OrganogramaSistema::with(['area.superintendencia', 'coordenador', 'pessoasAtivas'])
            ->where('ativo', true)
            ->ordenados()
            ->paginate(50)
            ->withQueryString();

        return view('organograma.sistemas.index', compact('sistemas'));
    }

    public function create()
    {
        $areas = OrganogramaArea::ativas()->ordenadas()->get(['id', 'nome', 'tipo']);
        $coordenadores = OrganogramaPessoa::ativos()
            ->whereIn('nivel', ['coordenacao', 'gerencia'])
            ->ordenados()
            ->get(['id', 'nome', 'cargo', 'nivel', 'sistema_id']);

        return view('organograma.sistemas.create', compact('areas', 'coordenadores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);
        
        OrganogramaSistema::create($dados);

        return redirect()
            ->route('organograma.sistemas.index')
            ->with('success', 'Sistema cadastrado com sucesso!');
    }

    public function edit(OrganogramaSistema $sistema)
    {
        $areas = OrganogramaArea::ativas()->ordenadas()->get(['id', 'nome', 'tipo']);
        $coordenadores = OrganogramaPessoa::ativos()
            ->whereIn('nivel', ['coordenacao', 'gerencia'])
            ->ordenados()
            ->get(['id', 'nome', 'cargo', 'nivel', 'sistema_id']);

        return view('organograma.sistemas.edit', compact('sistema', 'areas', 'coordenadores'));
    }

    public function update(Request $request, OrganogramaSistema $sistema): RedirectResponse
    {
        $dados = $this->validar($request, $sistema);
        
        $sistema->update($dados);

        return redirect()
            ->route('organograma.sistemas.index')
            ->with('success', 'Sistema atualizado com sucesso!');
    }

    public function destroy(OrganogramaSistema $sistema): RedirectResponse
    {
        $vinculos = $sistema->pessoasAtivas()->count();
        
        if ($vinculos > 0) {
            return redirect()
                ->route('organograma.sistemas.index')
                ->with('error', "O sistema \"{$sistema->nome}\" não pode ser excluído porque possui {$vinculos} pessoa(s) vinculada(s).");
        }

        $sistema->delete();

        return redirect()
            ->route('organograma.sistemas.index')
            ->with('success', 'Sistema excluído com sucesso!');
    }

    private function validar(Request $request, ?OrganogramaSistema $sistema = null): array
    {
        return $request->validate([
            'area_id' => ['required', 'integer', Rule::exists('organograma_areas', 'id')],
            'nome' => ['required', 'string', 'max:150'],
            'sigla' => ['nullable', 'string', 'max:30'],
            'descricao' => ['nullable', 'string'],
            'coordenador_id' => ['nullable', 'integer', Rule::exists('organograma_pessoas', 'id')],
            'ordem' => ['nullable', 'integer', 'min:0'],
            'ativo' => ['boolean'],
        ]);
    }
}