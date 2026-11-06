<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\Colaborador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrganogramaController extends Controller
{
    /**
     * Áreas do organograma. Cada área tem sua própria grade e, portanto,
     * as posições dos cards são gravadas separadamente por área.
     */
    public const AREAS = ['producao', 'apoio', 'corporativo'];

    /**
     * Limite de colunas por área (as grades têm larguras diferentes).
     */
    private const COLUNAS_POR_AREA = [
        'producao' => 9,
        'apoio' => 7,
        'corporativo' => 9,
    ];

    public function index()
    {
        $colaboradores = Colaborador::ativos()
            ->with(['grupo', 'gestor'])
            ->porNivel()
            ->get();

        // Mapa por e-mail: o layout em grade referencia cada pessoa pela chave.
        $m = $colaboradores->keyBy('email');

        return view('organograma.index', compact('m'));
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
            'nivel_label' => $colaborador->nivel_label,
            'label_nivel' => $colaborador->nivel_label,
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

    /**
     * Salva as alterações de um card dentro de uma área específica.
     *
     * O nome do colaborador é global (afeta a pessoa em toda a aplicação),
     * enquanto texto de barra, posição, tamanho e alinhamento pertencem
     * apenas à área editada. Campos com valor null removem a customization.
     */
    public function atualizarCard(Request $request, Colaborador $colaborador): JsonResponse
    {
        $dados = $request->validate([
            'area' => ['required', Rule::in(self::AREAS)],
            'nome_completo' => ['sometimes', 'nullable', 'string', 'max:150'],
            'texto' => ['sometimes', 'nullable', 'string', 'max:255'],
            'posicao' => ['sometimes', 'nullable', 'array'],
            'posicao.coluna' => ['sometimes', 'integer', 'min:1', 'max:9'],
            'posicao.linha' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'posicao.colspan' => ['sometimes', 'integer', 'min:1', 'max:9'],
            'posicao.rowspan' => ['sometimes', 'integer', 'min:1', 'max:6'],
            'align' => ['sometimes', 'nullable', Rule::in(['left', 'center', 'right'])],
            'valign' => ['sometimes', 'nullable', Rule::in(['top', 'center', 'bottom'])],
        ], [
            'area.required' => 'Informe a área do card.',
            'area.in' => 'Área inválida.',
            'nome_completo.max' => 'O nome do card deve ter no máximo 150 caracteres.',
            'texto.max' => 'O texto da barra deve ter no máximo 255 caracteres.',
            'posicao.coluna.min' => 'A coluna deve ser no mínimo 1.',
            'posicao.coluna.max' => 'A coluna deve ser no máximo 9.',
            'posicao.linha.min' => 'A linha deve ser no mínimo 1.',
            'posicao.linha.max' => 'A linha deve ser no máximo 20.',
            'posicao.colspan.min' => 'A largura deve ser no mínimo 1 coluna.',
            'posicao.colspan.max' => 'A largura deve ser no máximo 9 colunas.',
            'posicao.rowspan.min' => 'A altura deve ser no mínimo 1 linha.',
            'posicao.rowspan.max' => 'A altura deve ser no máximo 6 linhas.',
            'align.in' => 'Alinhamento horizontal inválido.',
            'valign.in' => 'Alinhamento vertical inválido.',
        ]);

        $area = $dados['area'];
        $maxColunas = self::COLUNAS_POR_AREA[$area];

        // A posição precisa caber na grade da área.
        if (isset($dados['posicao']) && is_array($dados['posicao'])) {
            $posicao = $dados['posicao'];

            foreach (['coluna', 'linha', 'colspan', 'rowspan'] as $campo) {
                if (! isset($posicao[$campo])) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'Posição incompleta.',
                    ], 422);
                }
            }

            $coluna = (int) $posicao['coluna'];
            $colspan = (int) $posicao['colspan'];

            if ($coluna + $colspan - 1 > $maxColunas) {
                return response()->json([
                    'ok' => false,
                    'message' => "O card não cabe na grade da área (máximo de {$maxColunas} colunas).",
                ], 422);
            }
        }

        // Nome do colaborador: global.
        if (array_key_exists('nome_completo', $dados)) {
            $nome = trim((string) $dados['nome_completo']);

            if ($nome === '') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Informe o nome ou texto do card.',
                ], 422);
            }

            $colaborador->nome_completo = $nome;
        }

        // Configuração visual: por área.
        $slot = [];

        if (array_key_exists('texto', $dados)) {
            $slot['texto'] = $dados['texto'];
        }

        if (array_key_exists('posicao', $dados)) {
            if (! is_array($dados['posicao'])) {
                $slot['posicao'] = null;
            } else {
                $slot['posicao'] = [
                    'coluna' => (int) $dados['posicao']['coluna'],
                    'linha' => (int) $dados['posicao']['linha'],
                    'colspan' => (int) $dados['posicao']['colspan'],
                    'rowspan' => (int) $dados['posicao']['rowspan'],
                ];
            }
        }

        if (array_key_exists('align', $dados)) {
            $slot['align'] = $dados['align'];
        }

        if (array_key_exists('valign', $dados)) {
            $slot['valign'] = $dados['valign'];
        }

        if ($slot !== []) {
            $colaborador->setPosicaoArea($area, $slot);
        }

        $colaborador->save();

        return response()->json([
            'ok' => true,
            'area' => $area,
            'posicao' => $colaborador->posicaoArea($area),
        ]);
    }

    /**
     * Salva as posições dos cards arrastados dentro de uma área.
     */
    public function salvarPosicoes(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'area' => ['required', Rule::in(self::AREAS)],
            'posicoes' => ['required', 'array'],
            'posicoes.*.id' => ['required', 'integer', 'exists:colaboradores,id'],
            'posicoes.*.coluna' => ['required', 'integer', 'min:1', 'max:9'],
            'posicoes.*.linha' => ['required', 'integer', 'min:1', 'max:20'],
            'posicoes.*.colspan' => ['required', 'integer', 'min:1', 'max:9'],
            'posicoes.*.rowspan' => ['sometimes', 'integer', 'min:1', 'max:6'],
        ]);

        $area = $dados['area'];
        $maxColunas = self::COLUNAS_POR_AREA[$area];

        foreach ($dados['posicoes'] as $posicao) {
            $coluna = (int) $posicao['coluna'];
            $colspan = (int) $posicao['colspan'];

            if ($coluna + $colspan - 1 > $maxColunas) {
                return response()->json([
                    'ok' => false,
                    'message' => "O card não cabe na grade da área (máximo de {$maxColunas} colunas).",
                ], 422);
            }

            $colaborador = Colaborador::find($posicao['id']);

            if (! $colaborador) {
                continue;
            }

            $colaborador->setPosicaoArea($area, [
                'posicao' => [
                    'coluna' => $coluna,
                    'linha' => (int) $posicao['linha'],
                    'colspan' => $colspan,
                    'rowspan' => (int) ($posicao['rowspan'] ?? 1),
                ],
            ]);

            $colaborador->save();
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
