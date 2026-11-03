<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ColaboradorController extends Controller
{
    public function index(Request $request)
    {
        $query = Colaborador::with(['gestor', 'grupo'])->whereNull('deleted_at');

        if ($request->filled('busca')) {
            $termo = $request->busca;
            $query->where(function ($q) use ($termo) {
                $q->where('nome_completo', 'like', "%{$termo}%")
                  ->orWhere('cargo', 'like', "%{$termo}%")
                  ->orWhere('setor', 'like', "%{$termo}%");
            });
        }

        if ($request->filled('setor')) {
            $query->where('setor', $request->setor);
        }

        $colaboradores = $query->ordenados()->paginate(20)->withQueryString();

        $setores = Colaborador::whereNull('deleted_at')->distinct()->pluck('setor')->filter()->sort()->values();

        return view('cadastros.colaboradores.index', compact('colaboradores', 'setores'));
    }

    public function create()
    {
        $gestores = Colaborador::whereNull('deleted_at')->ordenados()->get(['id', 'nome_completo', 'cargo']);
        $grupos = \App\Models\Grupo::ordenados()->get(['id', 'nome', 'numero']);

        return view('cadastros.colaboradores.create', compact('gestores', 'grupos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('colaboradores', 'public');
            $dados['foto_path'] = $path;
        }

        Colaborador::create($dados);

        return redirect()
            ->route('cadastros.colaboradores.index')
            ->with('success', 'Colaborador cadastrado com sucesso!');
    }

    public function edit(Colaborador $colaborador)
    {
        $gestores = Colaborador::whereNull('deleted_at')
            ->where('id', '!=', $colaborador->id)
            ->ordenados()
            ->get(['id', 'nome_completo', 'cargo']);
        $grupos = \App\Models\Grupo::ordenados()->get(['id', 'nome', 'numero']);

        return view('cadastros.colaboradores.edit', compact('colaborador', 'gestores', 'grupos'));
    }

    public function update(Request $request, Colaborador $colaborador): RedirectResponse
    {
        $dados = $this->validar($request, $colaborador);

        if ($request->hasFile('foto')) {
            if ($colaborador->foto_path && Storage::disk('public')->exists($colaborador->foto_path)) {
                Storage::disk('public')->delete($colaborador->foto_path);
            }
            $path = $request->file('foto')->store('colaboradores', 'public');
            $dados['foto_path'] = $path;
        }

        $colaborador->update($dados);

        return redirect()
            ->route('cadastros.colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Colaborador $colaborador): RedirectResponse
    {
        $subordinados = $colaborador->subordinados()->count();

        if ($subordinados > 0) {
            return redirect()
                ->route('cadastros.colaboradores.index')
                ->with('error', "Não é possível excluir: {$subordinados} subordinado(s) vinculado(s).");
        }

        if ($colaborador->foto_path && Storage::disk('public')->exists($colaborador->foto_path)) {
            Storage::disk('public')->delete($colaborador->foto_path);
        }

        $colaborador->delete();

        return redirect()
            ->route('cadastros.colaboradores.index')
            ->with('success', 'Colaborador excluído com sucesso!');
    }

    private function validar(Request $request, ?Colaborador $colaborador = null): array
    {
        return $request->validate([
            'nome_completo' => ['required', 'string', 'max:150'],
            'cargo' => ['required', 'string', 'max:100'],
            'setor' => ['nullable', 'string', 'max:100'],
            'grupo_id' => ['nullable', Rule::exists('grupos', 'id')],
            'gestor_id' => ['nullable', Rule::exists('colaboradores', 'id')],
            'email' => ['nullable', 'email', 'max:150'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}