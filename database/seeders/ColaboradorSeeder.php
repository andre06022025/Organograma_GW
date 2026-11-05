<?php

namespace Database\Seeders;

use App\Models\Cadastro;
use App\Models\Colaborador;
use App\Models\Grupo;
use Illuminate\Database\Seeder;

class ColaboradorSeeder extends Seeder
{
    public function run(): void
    {
        // Zera o vínculo dos cadastros para permitir recriar os colaboradores.
        Cadastro::query()->update(['gestor_id' => null]);

        // delete() respeita as chaves estrangeiras; truncate não.
        Colaborador::query()->delete();

        // Buscar grupos por nome para obter IDs
        $grupoTI = Grupo::where('nome', 'TI')->first();
        $grupoOperacoes = Grupo::where('nome', 'Operações')->first();
        $grupoManutencao = Grupo::where('nome', 'Manutenção')->first();
        $grupoAdministrativo = Grupo::where('nome', 'Administrativo')->first();

        // =========================================================
        // NÍVEL 1: DIREÇÃO
        // =========================================================
        $direcao = Colaborador::create([
            'nome_completo' => 'Thiago',
            'cargo' => 'Direção Geral',
            'setor' => 'Direção',
            'nivel' => 'direcao',
            'area' => 'corporativo',
            'ordem' => 0,
            'email' => 'thiago@empresa.com.br',
            'gestor_id' => null,
            'grupo_id' => $grupoAdministrativo?->id,
        ]);

        // =========================================================
        // NÍVEL 2: SUPERINTENDÊNCIAS
        // =========================================================
        $supRenato = Colaborador::create([
            'nome_completo' => 'Renato Capuano',
            'cargo' => 'Superintendência de Produção',
            'setor' => 'Produção',
            'nivel' => 'superintendencia',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'renato.capuano@empresa.com.br',
            'gestor_id' => $direcao->id,
            'grupo_id' => $grupoOperacoes?->id,
        ]);

        $supArthur = Colaborador::create([
            'nome_completo' => 'Arthur',
            'cargo' => 'Superintendência de Produção',
            'setor' => 'Produção',
            'nivel' => 'superintendencia',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'arthur@empresa.com.br',
            'gestor_id' => $direcao->id,
            'grupo_id' => $grupoOperacoes?->id,
        ]);

        $supCapuano = Colaborador::create([
            'nome_completo' => 'Capuano',
            'cargo' => 'Superintendência de Apoio',
            'setor' => 'Apoio',
            'nivel' => 'superintendencia',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'capuano@empresa.com.br',
            'gestor_id' => $direcao->id,
            'grupo_id' => $grupoOperacoes?->id,
        ]);

        // =========================================================
        // GERÊNCIA CORPORATIVA (transversal)
        // =========================================================
        $gerNeves = Colaborador::create([
            'nome_completo' => 'Neves',
            'cargo' => 'Gerência Corporativa',
            'setor' => 'Gerência Corporativa',
            'nivel' => 'gerencia',
            'area' => 'producao',
            'ordem' => 0,
            'ric' => true,
            'email' => 'neves@empresa.com.br',
            'gestor_id' => $supRenato->id,
            'grupo_id' => $grupoOperacoes?->id,
        ]);

        // =========================================================
        // SISTEMAS 1
        // =========================================================
        $cooFreddy = Colaborador::create([
            'nome_completo' => 'Freddy',
            'cargo' => 'Coordenação Sistemas 1',
            'setor' => 'Sistemas 1',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'freddy@empresa.com.br',
            'gestor_id' => $supRenato->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Denis',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 1',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'denis@empresa.com.br',
            'gestor_id' => $cooFreddy->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Paulo',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 1',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'paulo@empresa.com.br',
            'gestor_id' => $cooFreddy->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 2
        // =========================================================
        $cooLeonardo = Colaborador::create([
            'nome_completo' => 'Leonardo M.',
            'cargo' => 'Coordenação Sistemas 2',
            'setor' => 'Sistemas 2',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'leonardo.m@empresa.com.br',
            'gestor_id' => $supRenato->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Vagner',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 2',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'vagner@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Eric',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 2',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'eric@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'João',
            'cargo' => 'Supervisão 3',
            'setor' => 'Sistemas 2',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 4,
            'email' => 'joao@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 3
        // =========================================================
        $cooVilela = Colaborador::create([
            'nome_completo' => 'Vilela',
            'cargo' => 'Coordenação Sistemas 3',
            'setor' => 'Sistemas 3',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'vilela@empresa.com.br',
            'gestor_id' => $supRenato->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 4
        // =========================================================
        $cooWellington = Colaborador::create([
            'nome_completo' => 'Wellington',
            'cargo' => 'Coordenação Sistemas 4',
            'setor' => 'Sistemas 4',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'wellington@empresa.com.br',
            'gestor_id' => $supRenato->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Julio',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 3',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'julio@empresa.com.br',
            'gestor_id' => $cooVilela->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Alan',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 4',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'alan@empresa.com.br',
            'gestor_id' => $cooWellington->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'João',
            'cargo' => 'Supervisão 3',
            'setor' => 'Sistemas 3',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 4,
            'email' => 'joao.s34@empresa.com.br',
            'gestor_id' => $cooVilela->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Lucas',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 4',
            'nivel' => 'operador_lider',
            'area' => 'producao',
            'ordem' => 5,
            'email' => 'lucas@empresa.com.br',
            'gestor_id' => $cooWellington->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 5
        // =========================================================
        $cooAndre = Colaborador::create([
            'nome_completo' => 'André',
            'cargo' => 'Coordenação Sistemas 5',
            'setor' => 'Sistemas 5',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'andre.s5@empresa.com.br',
            'gestor_id' => $supArthur->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Anfrísio',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 5',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'anfrisio@empresa.com.br',
            'gestor_id' => $cooAndre->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Everton',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 5',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'everton@empresa.com.br',
            'gestor_id' => $cooAndre->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 6
        // =========================================================
        $cooRodrigo = Colaborador::create([
            'nome_completo' => 'Rodrigo',
            'cargo' => 'Coordenação Sistemas 6',
            'setor' => 'Sistemas 6',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'rodrigo@empresa.com.br',
            'gestor_id' => $supArthur->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Vanderso',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 6',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'vanderso@empresa.com.br',
            'gestor_id' => $cooRodrigo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Cesar',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 6',
            'nivel' => 'supervisao',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'cesar@empresa.com.br',
            'gestor_id' => $cooRodrigo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 7
        // =========================================================
        $gerSergio = Colaborador::create([
            'nome_completo' => 'Sergio Luiz',
            'cargo' => 'Gerência Sistemas 7',
            'setor' => 'Sistemas 7',
            'nivel' => 'gerencia',
            'area' => 'producao',
            'ordem' => 1,
            'ric' => true,
            'email' => 'sergio.luiz@empresa.com.br',
            'gestor_id' => $supArthur->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Ana Luiza',
            'cargo' => 'Gestão Operacional',
            'setor' => 'Sistemas 7',
            'nivel' => 'gerencia',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'ana.luiza@empresa.com.br',
            'gestor_id' => $gerSergio->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Deivison',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 7',
            'nivel' => 'operador_lider',
            'area' => 'producao',
            'ordem' => 3,
            'email' => 'deivison@empresa.com.br',
            'gestor_id' => $gerSergio->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 8
        // =========================================================
        $cooPedro = Colaborador::create([
            'nome_completo' => 'Pedro',
            'cargo' => 'Coordenação Sistemas 8',
            'setor' => 'Sistemas 8',
            'nivel' => 'coordenacao',
            'area' => 'producao',
            'ordem' => 1,
            'email' => 'pedro@empresa.com.br',
            'gestor_id' => $supArthur->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Lagus',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 8',
            'nivel' => 'operador_lider',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'lagus@empresa.com.br',
            'gestor_id' => $cooPedro->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // SISTEMAS 9
        // =========================================================
        $gerDiogo = Colaborador::create([
            'nome_completo' => 'Diogo',
            'cargo' => 'Gerência Sistemas 9',
            'setor' => 'Sistemas 9',
            'nivel' => 'gerencia',
            'area' => 'producao',
            'ordem' => 1,
            'ric' => true,
            'email' => 'diogo@empresa.com.br',
            'gestor_id' => $supArthur->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Rafael',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 9',
            'nivel' => 'operador_lider',
            'area' => 'producao',
            'ordem' => 2,
            'email' => 'rafael@empresa.com.br',
            'gestor_id' => $gerDiogo->id,
            'grupo_id' => $grupoTI?->id,
        ]);

        // =========================================================
        // APOIO — LABOR
        // =========================================================
        Colaborador::create([
            'nome_completo' => 'Ricardo',
            'cargo' => 'Gerência LABOR',
            'setor' => 'LABOR',
            'nivel' => 'gerencia',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'ricardo@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        // =========================================================
        // APOIO — LICENC
        // =========================================================
        $gerMarilia = Colaborador::create([
            'nome_completo' => 'Marília',
            'cargo' => 'Gerência LICENC',
            'setor' => 'LICENC',
            'nivel' => 'gerencia',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'marilia@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Gabriel',
            'cargo' => 'Coordenação LICENC',
            'setor' => 'LICENC',
            'nivel' => 'coordenacao',
            'area' => 'apoio',
            'ordem' => 2,
            'email' => 'gabriel@empresa.com.br',
            'gestor_id' => $gerMarilia->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        // =========================================================
        // APOIO — MANUTENÇÃO DE POÇOS
        // =========================================================
        Colaborador::create([
            'nome_completo' => 'Pedro Alcântara',
            'cargo' => 'Gerência Manutenção de Poços',
            'setor' => 'Manutenção de Poços',
            'nivel' => 'gerencia',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'pedro.alcantara@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        // =========================================================
        // APOIO — MANUTENÇÃO + LODO
        // =========================================================
        $gerCarlos = Colaborador::create([
            'nome_completo' => 'Carlos',
            'cargo' => 'Gerência Manutenção + Lodo',
            'setor' => 'Manutenção + Lodo',
            'nivel' => 'gerencia',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'carlos@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Diego',
            'cargo' => 'Supervisão Manutenção',
            'setor' => 'Manutenção + Lodo',
            'nivel' => 'supervisao',
            'area' => 'apoio',
            'ordem' => 2,
            'email' => 'diego.manut@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Leonardo',
            'cargo' => 'Supervisão Nordeste',
            'setor' => 'Manutenção + Lodo',
            'nivel' => 'supervisao',
            'area' => 'apoio',
            'ordem' => 3,
            'email' => 'leonardo.ne@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Nelson',
            'cargo' => 'Supervisão PCM',
            'setor' => 'Manutenção + Lodo',
            'nivel' => 'supervisao',
            'area' => 'apoio',
            'ordem' => 4,
            'email' => 'nelson@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Osias',
            'cargo' => 'Supervisão Lodo',
            'setor' => 'Manutenção + Lodo',
            'nivel' => 'supervisao',
            'area' => 'apoio',
            'ordem' => 5,
            'email' => 'osias@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        // =========================================================
        // APOIO — CCO
        // =========================================================
        Colaborador::create([
            'nome_completo' => 'André',
            'cargo' => 'Coordenação CCO',
            'setor' => 'CCO',
            'nivel' => 'coordenacao',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'andre.cco@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoOperacoes?->id,
        ]);

        // =========================================================
        // APOIO — ENGENHARIA DE PROCESSOS
        // =========================================================
        Colaborador::create([
            'nome_completo' => 'Beatriz',
            'cargo' => 'Engenharia de Processos',
            'setor' => 'Engenharia de Processos',
            'nivel' => 'coordenacao',
            'area' => 'apoio',
            'ordem' => 1,
            'email' => 'beatriz@empresa.com.br',
            'gestor_id' => $supCapuano->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Trainee',
            'cargo' => 'Engenharia Trainee',
            'setor' => 'Engenharia de Processos',
            'nivel' => 'trainee',
            'area' => 'apoio',
            'ordem' => 2,
            'email' => 'trainee.eng@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
            'grupo_id' => $grupoManutencao?->id,
        ]);

        // =========================================================
        // DADOS DOS CARDS DO ORGANOGRAMA
        // (cor, rótulo curto, texto de nível e região)
        // =========================================================
        $cards = [
            'thiago@empresa.com.br' => ['cor' => 'laranja', 'regiao' => 'Supervisão Geral do Grupo'],
            'renato.capuano@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Sistemas 1 a 6'],
            'arthur@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Sistemas 7 a 9'],
            'capuano@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Áreas de Apoio'],
            'neves@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Transversal a todas as áreas'],
            'freddy@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Rotas + Integrados RMSP'],
            'denis@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados + Rota 3'],
            'paulo@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados + Rota 2'],
            'leonardo.m@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Rotas + Integrados RMSP (ABC)'],
            'vagner@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados RMSP (ABC)'],
            'eric@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Rotas + Rota Paulista'],
            'joao@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Interior SP'],
            'vilela@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Cps + PR + Rib / Preto + SJRP / CFO + Rota'],
            'wellington@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'COB + Brag + Jund + Jaguariúna + Americana'],
            'julio@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Campinas + SJRP'],
            'lucas@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Bragança + Jundiaí + Jaguariúna + Americana'],
            'alan@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'CFO + Campinas'],
            'joao.s34@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Interior SP / Rota PF'],
            'andre.s5@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados RMSP + Rota'],
            'anfrisio@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados ZL + Sh D'],
            'everton@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Rota 1 + CN + Expo CN'],
            'rodrigo@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Integrados RMSP'],
            'vanderso@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Eixo Castelo + Granja'],
            'cesar@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Continental + Zona Norte'],
            'sergio.luiz@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Bahia'],
            'ana.luiza@empresa.com.br' => ['cor' => 'azul', 'nivel_card' => 'Gestão Op.', 'regiao' => 'Integrados RMSP (Pinheiros) / DF / Bahia'],
            'deivison@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Bahia'],
            'pedro@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Integrados RMSP + RJ'],
            'lagus@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'RJ'],
            'diogo@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'DF'],
            'rafael@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'DF'],
            'ricardo@empresa.com.br' => ['cor' => 'laranja', 'regiao' => 'Laboratório'],
            'marilia@empresa.com.br' => ['cor' => 'laranja', 'regiao' => 'Licenciamento'],
            'gabriel@empresa.com.br' => ['cor' => 'laranja', 'regiao' => 'Coordenação LICENC'],
            'pedro.alcantara@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Manutenção de Poços'],
            'carlos@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Manutenção + Lodo'],
            'diego.manut@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Manutenção Industrial'],
            'leonardo.ne@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Nordeste'],
            'nelson@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'PCM'],
            'osias@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Lodo'],
            'andre.cco@empresa.com.br' => ['cor' => 'azul', 'regiao' => 'Central de Operações'],
            'beatriz@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Engenharia de Processos'],
            'trainee.eng@empresa.com.br' => ['cor' => 'roxo', 'regiao' => 'Engenharia'],
        ];

        foreach ($cards as $email => $dados) {
            Colaborador::where('email', $email)->update($dados);
        }

        // =========================================================
        // ORDEM DE EXIBIÇÃO NA ÁRVORE (Organograma 2)
        // =========================================================
        $ordens = [
            'renato.capuano@empresa.com.br' => 1,
            'arthur@empresa.com.br' => 2,
            'capuano@empresa.com.br' => 3,
            'neves@empresa.com.br' => 1,
            'freddy@empresa.com.br' => 2,
            'leonardo.m@empresa.com.br' => 3,
            'vilela@empresa.com.br' => 4,
            'wellington@empresa.com.br' => 5,
            'andre.s5@empresa.com.br' => 1,
            'rodrigo@empresa.com.br' => 2,
            'sergio.luiz@empresa.com.br' => 3,
            'pedro@empresa.com.br' => 4,
            'diogo@empresa.com.br' => 5,
            'ricardo@empresa.com.br' => 1,
            'marilia@empresa.com.br' => 2,
            'pedro.alcantara@empresa.com.br' => 3,
            'carlos@empresa.com.br' => 4,
            'andre.cco@empresa.com.br' => 5,
            'beatriz@empresa.com.br' => 6,
            'denis@empresa.com.br' => 1,
            'paulo@empresa.com.br' => 2,
            'vagner@empresa.com.br' => 1,
            'eric@empresa.com.br' => 2,
            'joao@empresa.com.br' => 3,
            'julio@empresa.com.br' => 1,
            'joao.s34@empresa.com.br' => 2,
            'lucas@empresa.com.br' => 1,
            'alan@empresa.com.br' => 2,
            'ana.luiza@empresa.com.br' => 1,
            'deivison@empresa.com.br' => 2,
            'lagus@empresa.com.br' => 1,
            'rafael@empresa.com.br' => 1,
            'gabriel@empresa.com.br' => 1,
            'diego.manut@empresa.com.br' => 1,
            'leonardo.ne@empresa.com.br' => 2,
            'nelson@empresa.com.br' => 3,
            'osias@empresa.com.br' => 4,
            'trainee.eng@empresa.com.br' => 5,
        ];

        foreach ($ordens as $email => $ordem) {
            Colaborador::where('email', $email)->update(['ordem' => $ordem]);
        }

        $this->command->info('Colaboradores criados: ' . Colaborador::count());
        $this->command->info('Participantes do RIC: ' . Colaborador::where('ric', true)->count());
    }
}
