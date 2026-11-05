<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Colaborador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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

        $cadastros = Cadastro::where('gestor_id', $colaborador->id)
            ->orderBy('nome')
            ->get()
            ->map(fn ($c) => [
                'nome' => $c->nome,
                'tipo' => $c->tipo,
                'sistema' => $c->sistema,
                'operacao' => $c->operacao,
                'operadores' => $c->operadores ?? [],
                'numero_pocos' => $c->numero_pocos,
                'quantidade_operadores' => $c->quantidade_operadores,
            ]);

        return response()->json([
            'id' => $colaborador->id,
            'nome' => $colaborador->nome_completo,
            'cargo' => $colaborador->cargo,
            'nivel' => $colaborador->nivel,
            'label_nivel' => $colaborador->cargo,
            'cor' => $colaborador->cor,
            'cor_nivel' => $colaborador->cor_nivel,
            'area' => $colaborador->area,
            'setor' => $colaborador->setor,
            'data_contratacao' => $colaborador->data_contratacao?->format('d/m/Y'),
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
            'cadastros' => $cadastros,
        ]);
    }

    public function atualizarCard(Request $request, Colaborador $colaborador): JsonResponse
    {
        $dados = $request->validate([
            'nome_completo' => ['sometimes', 'required', 'string', 'max:150'],
            'card_coluna' => ['sometimes', 'integer', 'min:1', 'max:9'],
            'card_linha' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'card_colspan' => ['sometimes', 'integer', 'min:1', 'max:9'],
            'card_rowspan' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'card_texto' => ['sometimes', 'nullable', 'string', 'max:255'],
            'card_align' => ['sometimes', 'in:left,center,right'],
            'card_valign' => ['sometimes', 'in:top,center,bottom'],
        ]);

        $colaborador->update($dados);

        return response()->json(['ok' => true]);
    }

    public function salvarPosicoes(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'posicoes' => ['required', 'array'],
            'posicoes.*.id' => ['required', 'integer', 'exists:colaboradores,id'],
            'posicoes.*.coluna' => ['required', 'integer', 'min:1'],
            'posicoes.*.linha' => ['required', 'integer', 'min:1'],
            'posicoes.*.colspan' => ['required', 'integer', 'min:1', 'max:9'],
            'posicoes.*.rowspan' => ['sometimes', 'integer', 'min:1', 'max:10'],
        ]);

        foreach ($dados['posicoes'] as $posicao) {
            $atualizacao = [
                'card_coluna' => $posicao['coluna'],
                'card_linha' => $posicao['linha'],
                'card_colspan' => $posicao['colspan'],
            ];

            if (array_key_exists('rowspan', $posicao)) {
                $atualizacao['card_rowspan'] = $posicao['rowspan'];
            }

            Colaborador::whereKey($posicao['id'])->update($atualizacao);
        }

        return response()->json(['ok' => true]);
    }

    public function atualizarFoto(Request $request, Colaborador $colaborador): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'foto.required' => 'Selecione uma imagem.',
            'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.mimes' => 'Use um arquivo JPG, PNG ou WebP.',
            'foto.max' => 'A imagem deve ter no máximo 2MB.',
        ]);

        if ($colaborador->foto_path && Storage::disk('public')->exists($colaborador->foto_path)) {
            Storage::disk('public')->delete($colaborador->foto_path);
        }

        $colaborador->foto_path = $request->file('foto')->store('colaboradores', 'public');
        $colaborador->save();

        return back()->with('success', 'Foto de ' . $colaborador->nome_completo . ' atualizada com sucesso!');
    }
}
