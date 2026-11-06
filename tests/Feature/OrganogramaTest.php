<?php

namespace Tests\Feature;

use App\Models\Colaborador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganogramaTest extends TestCase
{
    use RefreshDatabase;

    private function criarColaborador(array $atributos = []): Colaborador
    {
        return Colaborador::create(array_merge([
            'nome_completo' => 'Teste',
            'cargo' => 'Cargo Teste',
            'email' => 'teste@empresa.com.br',
            'area' => 'producao',
            'nivel' => 'supervisao',
            'cor' => 'roxo',
        ], $atributos));
    }

    public function test_a_pagina_do_organograma_carrega(): void
    {
        $this->criarColaborador();

        $this->get(route('organograma.index'))
            ->assertOk()
            ->assertSee('Áreas de Produção')
            ->assertSee('Áreas de Apoio');
    }

    public function test_os_detalhes_retornam_json_com_o_colaborador(): void
    {
        $colaborador = $this->criarColaborador(['nome_completo' => 'Maria']);

        $this->getJson(route('organograma.detalhes', $colaborador->id))
            ->assertOk()
            ->assertJsonPath('nome', 'Maria')
            ->assertJsonPath('cargo', 'Cargo Teste');
    }

    public function test_a_posicao_e_salva_por_area(): void
    {
        $colaborador = $this->criarColaborador();

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'producao',
            'posicao' => ['coluna' => 4, 'linha' => 2, 'colspan' => 2, 'rowspan' => 1],
        ])->assertOk()->assertJson(['ok' => true]);

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'apoio',
            'posicao' => ['coluna' => 6, 'linha' => 1, 'colspan' => 2, 'rowspan' => 1],
        ])->assertOk()->assertJson(['ok' => true]);

        $colaborador->refresh();

        // Cada área guarda a sua própria posição.
        $this->assertSame(4, $colaborador->posicaoArea('producao')['posicao']['coluna']);
        $this->assertSame(6, $colaborador->posicaoArea('apoio')['posicao']['coluna']);
    }

    public function test_a_posicao_de_uma_area_nao_afeta_a_outra(): void
    {
        $colaborador = $this->criarColaborador();

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'producao',
            'posicao' => ['coluna' => 5, 'linha' => 3, 'colspan' => 1, 'rowspan' => 1],
        ])->assertOk();

        $colaborador->refresh();

        $this->assertArrayNotHasKey('apoio', $colaborador->card_posicoes);
        $this->assertSame(5, $colaborador->posicaoArea('producao')['posicao']['coluna']);
    }

    public function test_a_posicao_que_excede_a_largura_da_area_e_rejeitada(): void
    {
        $colaborador = $this->criarColaborador();

        // A área de Apoio tem 7 colunas: 6 + 3 ultrapassa o limite.
        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'apoio',
            'posicao' => ['coluna' => 6, 'linha' => 1, 'colspan' => 3, 'rowspan' => 1],
        ])->assertStatus(422)->assertJson(['ok' => false]);

        $colaborador->refresh();

        $this->assertNull($colaborador->card_posicoes);
    }

    public function test_area_invalida_e_rejeitada(): void
    {
        $colaborador = $this->criarColaborador();

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'inexistente',
            'posicao' => ['coluna' => 1, 'linha' => 1, 'colspan' => 1, 'rowspan' => 1],
        ])->assertStatus(422)->assertJsonValidationErrors('area');
    }

    public function test_texto_nulo_remove_a_customizacao_da_area(): void
    {
        $colaborador = $this->criarColaborador();

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'producao',
            'texto' => 'Rótulo customizado',
        ])->assertOk();

        $colaborador->refresh();
        $this->assertSame('Rótulo customizado', $colaborador->posicaoArea('producao')['texto']);

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'producao',
            'texto' => null,
        ])->assertOk();

        $colaborador->refresh();
        $this->assertArrayNotHasKey('texto', $colaborador->posicaoArea('producao'));
    }

    public function test_o_nome_do_colaborador_e_global_e_nao_por_area(): void
    {
        $colaborador = $this->criarColaborador(['nome_completo' => 'Original']);

        $this->postJson(route('organograma.card', $colaborador->id), [
            'area' => 'apoio',
            'nome_completo' => 'Renomeado',
        ])->assertOk();

        $colaborador->refresh();

        $this->assertSame('Renomeado', $colaborador->nome_completo);
    }

    public function test_as_posicoes_salvas_em_lote_respeitam_a_area(): void
    {
        $primeiro = $this->criarColaborador(['email' => 'a@empresa.com.br']);
        $segundo = $this->criarColaborador(['email' => 'b@empresa.com.br']);

        $this->postJson(route('organograma.posicoes'), [
            'area' => 'apoio',
            'posicoes' => [
                ['id' => $primeiro->id, 'coluna' => 2, 'linha' => 3, 'colspan' => 1, 'rowspan' => 1],
                ['id' => $segundo->id, 'coluna' => 3, 'linha' => 4, 'colspan' => 2, 'rowspan' => 1],
            ],
        ])->assertOk()->assertJson(['ok' => true]);

        $primeiro->refresh();
        $segundo->refresh();

        $this->assertSame(2, $primeiro->posicaoArea('apoio')['posicao']['coluna']);
        $this->assertSame(3, $segundo->posicaoArea('apoio')['posicao']['coluna']);
        $this->assertArrayNotHasKey('producao', $primeiro->card_posicoes);
    }
}
