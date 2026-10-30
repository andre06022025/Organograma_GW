<?php

namespace App\Http\Controllers;

use App\Models\OrganogramaArea;
use App\Models\OrganogramaPessoa;
use App\Models\OrganogramaSistema;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class OrganogramaPessoaController extends Controller
{
    public function index()
    {
        $pessoas = OrganogramaPessoa::with(['sistema.area.superintendencia', 'gestor'])
            ->where('ativo', true)
            ->ordenados()
            ->paginate(50)
            ->withQueryString();

        $sistemas = OrganogramaSistema::ativos()->ordenados()->get(['id', 'nome']);
        $niveis = OrganogramaPessoa::getOpcoesNivel();

        return view('organograma.pessoas.index', compact('pessoas', 'sistemas', 'niveis'));
    }

    public function create()
    {
        $sistemas = OrganogramaSistema::ativos()->ordenados()->get(['id', 'nome']);
        $gestores = OrganogramaPessoa::ativos()
            ->whereIn('nivel', ['direcao', 'superintendencia', 'gerencia', 'coordenacao', 'supervisao'])
            ->ordenados()
            ->get(['id', 'nome', 'cargo', 'nivel', 'sistema_id']);
        $niveis = OrganogramaPessoa::getOpcoesNivel();

        return view('organograma.pessoas.create', compact('sistemas', 'gestores', 'niveis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);
        
        OrganogramaPessoa::create($dados);

        return redirect()
            ->route('organograma.pessoas.index')
            ->with('success', 'Pessoa cadastrada com sucesso!');
    }

    public function edit(OrganogramaPessoa $pessoa)
    {
        $sistemas = OrganogramaSistema::ativos()->ordenados()->get(['id', 'nome']);
        $gestores = OrganogramaPessoa::ativos()
            ->where('id', '!=', $pessoa->id)
            ->whereIn('nivel', ['direcao', 'superintendencia', 'gerencia', 'coordenacao', 'supervisao'])
            ->ordenados()
            ->get(['id', 'nome', 'cargo', 'nivel', 'sistema_id']);
        $niveis = OrganogramaPessoa::getOpcoesNivel();

        return view('organograma.pessoas.edit', compact('pessoa', 'sistemas', 'gestores', 'niveis'));
    }

    public function update(Request $request, OrganogramaPessoa $pessoa): RedirectResponse
    {
        $dados = $this->validar($request, $pessoa);
        
        $pessoa->update($dados);

        return redirect()
            ->route('organograma.pessoas.index')
            ->with('success', 'Pessoa atualizada com sucesso!');
    }

    public function destroy(OrganogramaPessoa $pessoa): RedirectResponse
    {
        $subordinados = $pessoa->subordinadosAtivos()->count();
        
        if ($subordinados > 0) {
            return redirect()
                ->route('organograma.pessoas.index')
                ->with('error', "Não é possível excluir: {$subordinados} subordinado(s) vinculado(s).");
        }

        $pessoa->delete();

        return redirect()
            ->route('organograma.pessoas.index')
            ->with('success', 'Pessoa excluída com sucesso!');
    }

    private function validar(Request $request, ?OrganogramaPessoa $pessoa = null): array
    {
        $dados = $request->validate([
            'sistema_id' => ['nullable', 'integer', Rule::exists('organograma_sistemas', 'id')],
            'gestor_id' => ['nullable', 'integer', Rule::exists('organograma_pessoas', 'id')],
            'nome' => ['required', 'string', 'max:150'],
            'cargo' => ['required', 'string', 'max:100'],
            'nivel' => ['required', Rule::in(array_keys(OrganogramaPessoa::getOpcoesNivel()))],
            'email' => ['nullable', 'email', 'max:150'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'veiculo' => ['nullable', 'string', 'max:50'],
            'turno' => ['nullable', 'string', 'max:30'],
            'regiao' => ['nullable', 'string', 'max:100'],
            'observacoes' => ['nullable', 'string'],
            'data_admissao' => ['nullable', 'date'],
            'ativo' => ['boolean'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);

        $dados['ativo'] = $request->boolean('ativo', true);
        $dados['ordem'] = $request->integer('ordem', 0);

        return $dados;
    }
}