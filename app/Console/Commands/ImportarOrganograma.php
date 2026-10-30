<?php

namespace App\Console\Commands;

use App\Models\OrganogramaArea;
use App\Models\OrganogramaPessoa;
use App\Models\OrganogramaSistema;
use App\Models\OrganogramaSuperintendencia;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportarOrganograma extends Command
{
    protected $signature = 'organograma:importar 
                            {caminho? : Caminho do arquivo Excel}
                            {--dry-run : Apenas simula a importação sem gravar}
                            {--limpar : Limpa as tabelas antes de importar}';

    protected $description = 'Importa o organograma da planilha Organograma 2027.xlsx';

    private Spreadsheet $spreadsheet;
    private Worksheet $sheet;

    private array $superintendencias = [];
    private array $areas = [];
    private array $sistemas = [];
    private array $pessoas = [];

    public function handle(): int
    {
        $caminho = $this->argument('caminho') ?? 'C:/Users/andre/OneDrive/Desktop/Organograma 2027.xlsx';

        if (!file_exists($caminho)) {
            $this->error("Arquivo não encontrado: {$caminho}");
            return self::FAILURE;
        }

        if ($this->option('limpar')) {
            $this->warn('Limpando tabelas...');
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            OrganogramaPessoa::truncate();
            OrganogramaSistema::truncate();
            OrganogramaArea::truncate();
            OrganogramaSuperintendencia::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            $this->info('Tabelas limpas.');
        }

        $this->info("Carregando planilha: {$caminho}");
        $this->spreadsheet = IOFactory::load($caminho);
        $this->sheet = $this->spreadsheet->getSheetByName('Organ. 1º Semestre');

        if (!$this->sheet) {
            $this->error('Aba "Organ. 1º Semestre" não encontrada.');
            $this->info('Abas disponíveis: ' . implode(', ', $this->spreadsheet->getSheetNames()));
            return self::FAILURE;
        }

        $this->info('Planilha carregada. Iniciando importação...');

        $this->extrairEstrutura();

        if ($this->option('dry-run')) {
            $this->exibirResumo();
            $this->info('DRY-RUN: Nenhum dado foi gravado.');
            return self::SUCCESS;
        }

        $this->gravarNoBanco();

        $this->info('Importação concluída com sucesso!');
        $this->exibirResumo();

        return self::SUCCESS;
    }

    private function extrairEstrutura(): void
    {
        $this->info('Extraindo superintendências...');
        $this->extrairSuperintendencias();

        $this->info('Extraindo áreas e sistemas...');
        $this->extrairAreasESistemas();

        $this->info('Extraindo pessoas...');
        $this->extrairPessoas();

        $this->info('Extraindo dados das outras abas...');
        $this->extrairOutrasAbas();
    }

    private function extrairSuperintendencias(): void
    {
        // Linha 4: B4:L4 = SUPERINTENDÊNCIA (RENATO CAPUANO)
        //          N4:R4 = SUPERINTENDÊNCIA (ARTHUR)
        //          U4:Y4 = DIREÇÃO (THIAGO)
        //          AA4:AE4 = SUPERINTENDENCIA (ARTHUR)
        //          AG4 = SUPERINT. (CAPUANO)

        $this->superintendencias = [
            [
                'nome' => 'SUPERINTENDÊNCIA (RENATO CAPUANO)',
                'sigla' => 'SUP-CAPUANO',
                'ordem' => 1,
            ],
            [
                'nome' => 'SUPERINTENDÊNCIA (ARTHUR)',
                'sigla' => 'SUP-ARTHUR',
                'ordem' => 2,
            ],
            [
                'nome' => 'DIREÇÃO (THIAGO)',
                'sigla' => 'DIR-THIAGO',
                'ordem' => 0,
            ],
            [
                'nome' => 'SUPERINTENDÊNCIA (ARTHUR) - APOIO',
                'sigla' => 'SUP-ARTHUR-APOIO',
                'ordem' => 3,
            ],
            [
                'nome' => 'SUPERINT. (CAPUANO)',
                'sigla' => 'SUP-CAPUANO-2',
                'ordem' => 4,
            ],
        ];
    }

    private function extrairAreasESistemas(): void
    {
        // Linha 6: B6:R6 = ÁREAS DE PRODUÇÃO | U6:AG6 = ÁREAS DE APOIO
        // Linha 8: B8:D8 = GER. CORPORATIVA (NEVES)
        // Linha 10: Cabeçalhos dos sistemas
        // Colunas: B=SIST1, D=SIST2, F-H=SIST3+4, J=SIST5, L=SIST6, N=SIST7, P=SIST8, R=SIST9
        //          U=LABOR, W=LICENC, Y=RIC, AA=MANUT.POÇOS, AC=MANUT.+LODO, AE=CCO, AG=ENG PROC

        $areasProducao = [
            'SISTEMAS 1',
            'SISTEMAS 2',
            'SISTEMAS 3 + 4',
            'SISTEMAS 5',
            'SISTEMAS 6',
            'SISTEMAS 7',
            'SISTEMAS 8',
            'SISTEMAS 9',
        ];

        $areasApoio = [
            'LABOR',
            'LICENC',
            'RIC',
            'MANUT. POÇOS',
            'MANUTENÇÃO +LODO',
            'CCO',
            'ENG PROC',
        ];

        // Criar superintendências para mapear
        $supProducao = null;
        $supApoio = null;
        foreach ($this->superintendencias as $i => $sup) {
            if (str_contains($sup['nome'], 'CAPUANO') && $i === 0) {
                $supProducao = $sup;
            }
            if (str_contains($sup['nome'], 'APOIO')) {
                $supApoio = $sup;
            }
        }

        // Áreas de Produção (cada sistema é uma área)
        $ordem = 1;
        foreach ($areasProducao as $nome) {
            $sigla = str_replace([' ', '+', '.'], ['', '', ''], $nome);
            $this->areas[] = [
                'superintendencia_key' => 'producao',
                'nome' => $nome,
                'sigla' => $sigla,
                'tipo' => 'producao',
                'ordem' => $ordem++,
            ];
            // Cada área tem 1 sistema (mesmo nome)
            $this->sistemas[] = [
                'area_key' => $nome,
                'nome' => $nome,
                'sigla' => $sigla,
                'ordem' => 1,
            ];
        }

        // Áreas de Apoio
        $ordem = 1;
        foreach ($areasApoio as $nome) {
            $sigla = str_replace([' ', '+', '.', 'Ç'], ['', '', '', 'C'], $nome);
            $this->areas[] = [
                'superintendencia_key' => 'apoio',
                'nome' => $nome,
                'sigla' => $sigla,
                'tipo' => 'apoio',
                'ordem' => $ordem++,
            ];
            $this->sistemas[] = [
                'area_key' => $nome,
                'nome' => $nome,
                'sigla' => $sigla,
                'ordem' => 1,
            ];
        }

        // GER. CORPORATIVA (NEVES) - área transversal
        $this->areas[] = [
            'superintendencia_key' => 'producao',
            'nome' => 'GER. CORPORATIVA (NEVES)',
            'sigla' => 'GERCORP',
            'tipo' => 'producao',
            'ordem' => 0,
        ];
        $this->sistemas[] = [
            'area_key' => 'GER. CORPORATIVA (NEVES)',
            'nome' => 'GER. CORPORATIVA (NEVES)',
            'sigla' => 'GERCORP',
            'ordem' => 1,
        ];
    }

    private function extrairPessoas(): void
    {
        // Nível 1: Coordenadores/Gerentes (linha 12-13)
        $coordenadores = [
            // Coluna B: SISTEMAS 1
            ['col' => 'B', 'sistema' => 'SISTEMAS 1', 'cargo' => 'Coordenação', 'nome' => 'FREDDY', 'nivel' => 'coordenacao', 'regiao' => 'Rotas + Integrados RMSP'],
            // Coluna D: SISTEMAS 2
            ['col' => 'D', 'sistema' => 'SISTEMAS 2', 'cargo' => 'Coordenação', 'nome' => 'LEONARDO M.', 'nivel' => 'coordenacao', 'regiao' => 'Rotas + Integrados RMSP (ABC)'],
            // Coluna F: SISTEMAS 3+4 (Vilela)
            ['col' => 'F', 'sistema' => 'SISTEMAS 3 + 4', 'cargo' => 'Coordenação', 'nome' => 'VILELA', 'nivel' => 'coordenacao', 'regiao' => 'Interior SP Cps + PF + Rib Preto + SJRP + CFO + Rota'],
            // Coluna H: SISTEMAS 3+4 (Wellington)
            ['col' => 'H', 'sistema' => 'SISTEMAS 3 + 4', 'cargo' => 'Coordenação', 'nome' => 'WELLINGTON', 'nivel' => 'coordenacao', 'regiao' => 'Interior SP CQB + Brag + Jnd + Jaguariuna + America'],
            // Coluna J: SISTEMAS 5
            ['col' => 'J', 'sistema' => 'SISTEMAS 5', 'cargo' => 'Coordenação', 'nome' => 'ANDRE', 'nivel' => 'coordenacao', 'regiao' => 'Integrados RMSP+Rota'],
            // Coluna L: SISTEMAS 6
            ['col' => 'L', 'sistema' => 'SISTEMAS 6', 'cargo' => 'Coordenação', 'nome' => 'RODRIGO', 'nivel' => 'coordenacao', 'regiao' => 'Integrados RMSP'],
            // Coluna N: SISTEMAS 7 (Gerência)
            ['col' => 'N', 'sistema' => 'SISTEMAS 7', 'cargo' => 'Gerência', 'nome' => 'SERGIO LUIZ', 'nivel' => 'gerencia', 'regiao' => 'Bahia'],
            // Coluna P: SISTEMAS 8
            ['col' => 'P', 'sistema' => 'SISTEMAS 8', 'cargo' => 'Coordenação', 'nome' => 'PEDRO', 'nivel' => 'coordenacao', 'regiao' => 'Integrados RMSP+RJ'],
            // Coluna R: SISTEMAS 9 (Gerência)
            ['col' => 'R', 'sistema' => 'SISTEMAS 9', 'cargo' => 'Gerência', 'nome' => 'DIOGO', 'nivel' => 'gerencia', 'regiao' => 'DF'],
            // Coluna U: LABOR (Gerência)
            ['col' => 'U', 'sistema' => 'LABOR', 'cargo' => 'Gerência', 'nome' => 'RICARDO', 'nivel' => 'gerencia'],
            // Coluna W: LICENC (Gerência)
            ['col' => 'W', 'sistema' => 'LICENC', 'cargo' => 'Gerência', 'nome' => 'MARILIA', 'nivel' => 'gerencia'],
            // Coluna Y: RIC (Gerência) - mesclado Y13:Y14
            ['col' => 'Y', 'sistema' => 'RIC', 'cargo' => 'Gerência', 'nome' => 'SERGIO LUIZ DIOGO NEVES', 'nivel' => 'gerencia'],
            // Coluna AA: MANUT. POÇOS (Gerência)
            ['col' => 'AA', 'sistema' => 'MANUT. POÇOS', 'cargo' => 'Gerência', 'nome' => 'PEDRO ALC.', 'nivel' => 'gerencia'],
            // Coluna AC: MANUTENÇÃO +LODO (Gerência)
            ['col' => 'AC', 'sistema' => 'MANUTENÇÃO +LODO', 'cargo' => 'Gerência', 'nome' => 'CARLOS', 'nivel' => 'gerencia'],
            // Coluna AE: CCO (Coordenação)
            ['col' => 'AE', 'sistema' => 'CCO', 'cargo' => 'Coordenação', 'nome' => 'ANDRÉ', 'nivel' => 'coordenacao'],
            // Coluna AG: ENG PROC (Engenharia)
            ['col' => 'AG', 'sistema' => 'ENG PROC', 'cargo' => 'Engenharia', 'nome' => 'BEATRIZ', 'nivel' => 'coordenacao'],
        ];

        foreach ($coordenadores as $c) {
            $this->pessoas[] = array_merge($c, ['gestor_nome' => null, 'ordem' => 1]);
        }

        // Nível 2: Supervisões (linhas 17-33)
        $supervisoes = [
            // SISTEMAS 1 - Supervisão 1 (Denis), Supervisão 2 (Paulo)
            ['sistema' => 'SISTEMAS 1', 'cargo' => 'Supervisão 1', 'nome' => 'DENIS', 'nivel' => 'supervisao', 'regiao' => 'Integrados + Rota 3', 'gestor' => 'FREDDY'],
            ['sistema' => 'SISTEMAS 1', 'cargo' => 'Supervisão 2', 'nome' => 'PAULO', 'nivel' => 'supervisao', 'regiao' => 'Integrados + Rota 2', 'gestor' => 'FREDDY'],
            // SISTEMAS 2 - Supervisão 1 (Vagner), Supervisão 2 (Eric), Supervisão 3 (João)
            ['sistema' => 'SISTEMAS 2', 'cargo' => 'Supervisão 1', 'nome' => 'VAGNER', 'nivel' => 'supervisao', 'regiao' => 'Integrados RMSP (ABC)', 'gestor' => 'LEONARDO M.'],
            ['sistema' => 'SISTEMAS 2', 'cargo' => 'Supervisão 2', 'nome' => 'ERIC', 'nivel' => 'supervisao', 'regiao' => 'Integrados + Rota Paulista', 'gestor' => 'LEONARDO M.'],
            ['sistema' => 'SISTEMAS 2', 'cargo' => 'Supervisão 3', 'nome' => 'JOÃO', 'nivel' => 'supervisao', 'regiao' => 'Interior SP Rota+PF', 'gestor' => 'LEONARDO M.'],
            // SISTEMAS 3+4 (Vilela) - Supervisão 1 (Julio)
            ['sistema' => 'SISTEMAS 3 + 4', 'cargo' => 'Supervisão 1', 'nome' => 'JULIO', 'nivel' => 'supervisao', 'regiao' => 'Campinas + Rib Preto + SJRP', 'gestor' => 'VILELA'],
            // SISTEMAS 3+4 (Wellington) - Operador Líder (Lucas)
            ['sistema' => 'SISTEMAS 3 + 4', 'cargo' => 'Operador Líder', 'nome' => 'LUCAS', 'nivel' => 'operador_lider', 'regiao' => 'Interior SP Bragança + Jundiaí + Jaguariúna + Americana', 'gestor' => 'WELLINGTON'],
            // SISTEMAS 5 - Supervisão 1 (Anfrísio), Supervisão 2 (Everton)
            ['sistema' => 'SISTEMAS 5', 'cargo' => 'Supervisão 1', 'nome' => 'ANFRISIO', 'nivel' => 'supervisao', 'regiao' => 'Integrados ZL + Sh D', 'gestor' => 'ANDRE'],
            ['sistema' => 'SISTEMAS 5', 'cargo' => 'Supervisão 2', 'nome' => 'EVERTON', 'nivel' => 'supervisao', 'regiao' => 'Rota 1 + CN + Expo CN', 'gestor' => 'ANDRE'],
            // SISTEMAS 6 - Supervisão 1 (Vanderson), Supervisão 2 (Cesar)
            ['sistema' => 'SISTEMAS 6', 'cargo' => 'Supervisão 1', 'nome' => 'VANDERSON', 'nivel' => 'supervisao', 'regiao' => 'Eixo Castelo + Granja', 'gestor' => 'RODRIGO'],
            ['sistema' => 'SISTEMAS 6', 'cargo' => 'Supervisão 2', 'nome' => 'CESAR', 'nivel' => 'supervisao', 'regiao' => 'Continental + Zona norte', 'gestor' => 'RODRIGO'],
            // SISTEMAS 7 - Gestão Op. (Ana Luiza), Operador Líder (Deivison), Operador Líder (Lagus), Operador Líder (Rafael)
            ['sistema' => 'SISTEMAS 7', 'cargo' => 'Gestão Op.', 'nome' => 'ANA LUIZA', 'nivel' => 'gerencia', 'regiao' => 'Integrados RMSP (Eixo Pinheiros) / DF / Bahia', 'gestor' => 'SERGIO LUIZ'],
            ['sistema' => 'SISTEMAS 7', 'cargo' => 'Operador Líder', 'nome' => 'DEIVISON', 'nivel' => 'operador_lider', 'regiao' => 'Bahia', 'gestor' => 'SERGIO LUIZ'],
            ['sistema' => 'SISTEMAS 7', 'cargo' => 'Operador Líder', 'nome' => 'LAGUS', 'nivel' => 'operador_lider', 'regiao' => 'RJ', 'gestor' => 'SERGIO LUIZ'],
            ['sistema' => 'SISTEMAS 7', 'cargo' => 'Operador Líder', 'nome' => 'RAFAEL', 'nivel' => 'operador_lider', 'regiao' => 'DF', 'gestor' => 'SERGIO LUIZ'],
            // SISTEMAS 8 - Supervisão 1 (Diego), Supervisão 2 (Leonardo - Manut)
            ['sistema' => 'SISTEMAS 8', 'cargo' => 'Supervisão 1', 'nome' => 'DIEGO', 'nivel' => 'supervisao', 'regiao' => 'NORDESTE', 'gestor' => 'PEDRO'],
            // MANUTENÇÃO +LODO - Superv. de PCM (Nelson), Superv. de Lodo (Osias)
            ['sistema' => 'MANUTENÇÃO +LODO', 'cargo' => 'Superv. de PCM', 'nome' => 'NELSON', 'nivel' => 'supervisao', 'gestor' => 'CARLOS'],
            ['sistema' => 'MANUTENÇÃO +LODO', 'cargo' => 'Superv. de Lodo', 'nome' => 'OSIAS', 'nivel' => 'supervisao', 'gestor' => 'CARLOS'],
        ];

        foreach ($supervisoes as $s) {
            $this->pessoas[] = array_merge($s, ['ordem' => 2]);
        }

        // Trainees
        $trainees = [
            ['sistema' => 'SISTEMAS 7', 'cargo' => 'Trainee Coordenação', 'nome' => 'GABRIEL', 'nivel' => 'trainee', 'gestor' => 'SERGIO LUIZ'],
            ['sistema' => 'ENG PROC', 'cargo' => 'ENGº TRAINEE', 'nome' => '', 'nivel' => 'trainee', 'gestor' => 'BEATRIZ'],
        ];
        foreach ($trainees as $t) {
            $this->pessoas[] = array_merge($t, ['ordem' => 3]);
        }
    }

    private function extrairOutrasAbas(): void
    {
        // Aba: SISTEMAS E EQUIPES - detalhes de empreendimentos, operadores, poços
        // Aba: VEICULOS - veículos por função/motorista
        // Aba: FERISTAS E APOIO - feristas e apoio por sistema
        // Aba: COBERTURA ISAQUE - rotas de cobertura
        
        // Por enquanto, apenas log das abas disponíveis
        foreach ($this->spreadsheet->getSheetNames() as $nome) {
            if ($nome !== 'Organ. 1º Semestre') {
                $ws = $this->spreadsheet->getSheetByName($nome);
                $this->line("  - {$nome}: {$ws->getHighestRow()} linhas x {$ws->getHighestColumn()} colunas");
            }
        }
    }

    private function gravarNoBanco(): void
    {
        DB::transaction(function () {
            // 1. Superintendências
            $this->info('Gravando superintendências...');
            $supMap = [];
            foreach ($this->superintendencias as $sup) {
                $model = OrganogramaSuperintendencia::create($sup);
                $supMap[$sup['nome']] = $model->id;
                $supMap[$sup['sigla']] = $model->id;
            }

            // 2. Áreas
            $this->info('Gravando áreas...');
            $areaMap = [];
            foreach ($this->areas as $area) {
                $supKey = $area['superintendencia_key'];
                $supId = null;
                
                if ($supKey === 'producao') {
                    $supId = $supMap['SUP-CAPUANO'] ?? $supMap['SUPERINTENDÊNCIA (RENATO CAPUANO)'] ?? 1;
                } elseif ($supKey === 'apoio') {
                    $supId = $supMap['SUP-ARTHUR-APOIO'] ?? $supMap['SUPERINTENDÊNCIA (ARTHUR) - APOIO'] ?? 2;
                }

                $model = OrganogramaArea::create([
                    'superintendencia_id' => $supId,
                    'nome' => $area['nome'],
                    'sigla' => $area['sigla'],
                    'tipo' => $area['tipo'],
                    'ordem' => $area['ordem'],
                    'ativo' => true,
                ]);
                $areaMap[$area['nome']] = $model->id;
            }

            // 3. Sistemas
            $this->info('Gravando sistemas...');
            $sistemaMap = [];
            foreach ($this->sistemas as $sis) {
                $areaId = $areaMap[$sis['area_key']] ?? 1;
                
                $model = OrganogramaSistema::create([
                    'area_id' => $areaId,
                    'nome' => $sis['nome'],
                    'sigla' => $sis['sigla'],
                    'ordem' => $sis['ordem'],
                    'ativo' => true,
                ]);
                $sistemaMap[$sis['nome']] = $model->id;
            }

            // 4. Pessoas - primeira passada (criar sem gestor_id)
            $this->info('Gravando pessoas...');
            $pessoaMap = [];
            foreach ($this->pessoas as $i => $p) {
                $sistemaId = $sistemaMap[$p['sistema']] ?? null;
                
                $model = OrganogramaPessoa::create([
                    'sistema_id' => $sistemaId,
                    'gestor_id' => null, // será preenchido na segunda passada
                    'nome' => $p['nome'],
                    'cargo' => $p['cargo'],
                    'nivel' => $p['nivel'],
                    'regiao' => $p['regiao'] ?? null,
                    'ordem' => $p['ordem'],
                    'ativo' => true,
                ]);
                $pessoaMap[$p['nome']] = $model->id;
                $this->pessoas[$i]['id'] = $model->id;
            }

            // 5. Segunda passada - vincular gestores
            $this->info('Vinculando gestores...');
            foreach ($this->pessoas as $p) {
                if (!empty($p['gestor']) && isset($pessoaMap[$p['gestor']])) {
                    OrganogramaPessoa::where('id', $p['id'])
                        ->update(['gestor_id' => $pessoaMap[$p['gestor']]]);
                }
            }

            // 6. Atualizar coordenadores nos sistemas
            $this->info('Atualizando coordenadores dos sistemas...');
            foreach ($this->pessoas as $p) {
                if (in_array($p['nivel'], ['coordenacao', 'gerencia']) && isset($pessoaMap[$p['nome']])) {
                    $sistemaId = $sistemaMap[$p['sistema']] ?? null;
                    if ($sistemaId) {
                        OrganogramaSistema::where('id', $sistemaId)
                            ->update(['coordenador_id' => $pessoaMap[$p['nome']]]);
                    }
                }
            }

            // 7. Atualizar gerentes nas áreas
            $this->info('Atualizando gerentes das áreas...');
            foreach ($this->pessoas as $p) {
                if ($p['nivel'] === 'gerencia' && isset($pessoaMap[$p['nome']])) {
                    $areaId = $areaMap[$p['sistema']] ?? null;
                    if ($areaId) {
                        OrganogramaArea::where('id', $areaId)
                            ->update(['gerente_id' => $pessoaMap[$p['nome']]]);
                    }
                }
            }
        });
    }

    private function exibirResumo(): void
    {
        $this->table(
            ['Item', 'Quantidade'],
            [
                ['Superintendências', count($this->superintendencias)],
                ['Áreas', count($this->areas)],
                ['Sistemas', count($this->sistemas)],
                ['Pessoas', count($this->pessoas)],
            ]
        );

        if (!$this->option('dry-run')) {
            $this->newLine();
            $this->table(
                ['Tabela', 'Registros'],
                [
                    ['organograma_superintendencias', OrganogramaSuperintendencia::count()],
                    ['organograma_areas', OrganogramaArea::count()],
                    ['organograma_sistemas', OrganogramaSistema::count()],
                    ['organograma_pessoas', OrganogramaPessoa::count()],
                ]
            );
        }
    }
}