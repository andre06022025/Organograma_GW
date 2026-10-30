<?php

namespace Database\Seeders;

use App\Models\Colaborador;
use Illuminate\Database\Seeder;

class ColaboradorSeeder extends Seeder
{
    public function run(): void
    {
        Colaborador::truncate();

        // NÍVEL 1: DIREÇÃO
        $direcao = Colaborador::create([
            'nome_completo' => 'Thiago',
            'cargo' => 'Direção Geral',
            'setor' => 'Direção',
            'email' => 'thiago@empresa.com.br',
            'gestor_id' => null,
        ]);

        // NÍVEL 2: SUPERINTENDÊNCIAS
        $supRenato = Colaborador::create([
            'nome_completo' => 'Renato Capuano',
            'cargo' => 'Superintendência de Produção',
            'setor' => 'Produção',
            'email' => 'renato.capuano@empresa.com.br',
            'gestor_id' => $direcao->id,
        ]);

        $supArthur = Colaborador::create([
            'nome_completo' => 'Arthur',
            'cargo' => 'Superintendência de Produção',
            'setor' => 'Produção',
            'email' => 'arthur@empresa.com.br',
            'gestor_id' => $direcao->id,
        ]);

        $supCapuano = Colaborador::create([
            'nome_completo' => 'Capuano',
            'cargo' => 'Superintendência de Apoio',
            'setor' => 'Apoio',
            'email' => 'capuano@empresa.com.br',
            'gestor_id' => $direcao->id,
        ]);

        // GERÊNCIA CORPORATIVA
        $gerNeves = Colaborador::create([
            'nome_completo' => 'Neves',
            'cargo' => 'Gerência Corporativa',
            'setor' => 'Produção',
            'email' => 'neves@empresa.com.br',
            'gestor_id' => $supRenato->id,
        ]);

        // SISTEMAS 1
        $cooFreddy = Colaborador::create([
            'nome_completo' => 'Freddy',
            'cargo' => 'Coordenação Sistemas 1',
            'setor' => 'Sistemas 1',
            'email' => 'freddy@empresa.com.br',
            'gestor_id' => $supRenato->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Denis',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 1',
            'email' => 'denis@empresa.com.br',
            'gestor_id' => $cooFreddy->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Paulo',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 1',
            'email' => 'paulo@empresa.com.br',
            'gestor_id' => $cooFreddy->id,
        ]);

        // SISTEMAS 2
        $cooLeonardo = Colaborador::create([
            'nome_completo' => 'Leonardo M.',
            'cargo' => 'Coordenação Sistemas 2',
            'setor' => 'Sistemas 2',
            'email' => 'leonardo.m@empresa.com.br',
            'gestor_id' => $supRenato->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Vagner',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 2',
            'email' => 'vagner@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Eric',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 2',
            'email' => 'eric@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'João',
            'cargo' => 'Supervisão 3',
            'setor' => 'Sistemas 2',
            'email' => 'joao@empresa.com.br',
            'gestor_id' => $cooLeonardo->id,
        ]);

        // SISTEMAS 3+4
        $cooVilela = Colaborador::create([
            'nome_completo' => 'Vilela',
            'cargo' => 'Coordenação Sistemas 3+4',
            'setor' => 'Sistemas 3+4',
            'email' => 'vilela@empresa.com.br',
            'gestor_id' => $supRenato->id,
        ]);

        $cooWellington = Colaborador::create([
            'nome_completo' => 'Wellington',
            'cargo' => 'Coordenação Sistemas 3+4',
            'setor' => 'Sistemas 3+4',
            'email' => 'wellington@empresa.com.br',
            'gestor_id' => $supRenato->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Julio',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 3+4',
            'email' => 'julio@empresa.com.br',
            'gestor_id' => $cooVilela->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Lucas',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 3+4',
            'email' => 'lucas@empresa.com.br',
            'gestor_id' => $cooWellington->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Alan',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 3+4',
            'email' => 'alan@empresa.com.br',
            'gestor_id' => $cooWellington->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'João',
            'cargo' => 'Supervisão 3',
            'setor' => 'Sistemas 3+4',
            'email' => 'joao@empresa.com.br',
            'gestor_id' => $cooVilela->id,
        ]);

        // SISTEMAS 5
        $cooAndre = Colaborador::create([
            'nome_completo' => 'André',
            'cargo' => 'Coordenação Sistemas 5',
            'setor' => 'Sistemas 5',
            'email' => 'andre.s5@empresa.com.br',
            'gestor_id' => $supArthur->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Anfrísio',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 5',
            'email' => 'anfrisio@empresa.com.br',
            'gestor_id' => $cooAndre->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Everton',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 5',
            'email' => 'everton@empresa.com.br',
            'gestor_id' => $cooAndre->id,
        ]);

        // SISTEMAS 6
        $cooRodrigo = Colaborador::create([
            'nome_completo' => 'Rodrigo',
            'cargo' => 'Coordenação Sistemas 6',
            'setor' => 'Sistemas 6',
            'email' => 'rodrigo@empresa.com.br',
            'gestor_id' => $supArthur->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Vanderso',
            'cargo' => 'Supervisão 1',
            'setor' => 'Sistemas 6',
            'email' => 'vanderso@empresa.com.br',
            'gestor_id' => $cooRodrigo->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Cesar',
            'cargo' => 'Supervisão 2',
            'setor' => 'Sistemas 6',
            'email' => 'cesar@empresa.com.br',
            'gestor_id' => $cooRodrigo->id,
        ]);

        // SISTEMAS 7
        $gerSergio = Colaborador::create([
            'nome_completo' => 'Sergio Luiz',
            'cargo' => 'Gerência Sistemas 7',
            'setor' => 'Sistemas 7',
            'email' => 'sergio.luiz@empresa.com.br',
            'gestor_id' => $supArthur->id,
        ]);

        $cooPedro = Colaborador::create([
            'nome_completo' => 'Pedro',
            'cargo' => 'Coordenação Sistemas 8',
            'setor' => 'Sistemas 8',
            'email' => 'pedro@empresa.com.br',
            'gestor_id' => $supArthur->id,
        ]);

        $gerDiogo = Colaborador::create([
            'nome_completo' => 'Diogo',
            'cargo' => 'Gerência Sistemas 9',
            'setor' => 'Sistemas 9',
            'email' => 'diogo@empresa.com.br',
            'gestor_id' => $supArthur->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Ana Luiza',
            'cargo' => 'Gestão Operacional',
            'setor' => 'Gestão Op.',
            'email' => 'ana.luiza@empresa.com.br',
            'gestor_id' => $gerSergio->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Deivison',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 7',
            'email' => 'deivison@empresa.com.br',
            'gestor_id' => $gerSergio->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Lagus',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 8',
            'email' => 'lagus@empresa.com.br',
            'gestor_id' => $cooPedro->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Rafael',
            'cargo' => 'Operador Líder',
            'setor' => 'Sistemas 9',
            'email' => 'rafael@empresa.com.br',
            'gestor_id' => $gerDiogo->id,
        ]);

        // APOIO
        $refApoio = Colaborador::create([
            'nome_completo' => 'Thiago (Ref. Apoio)',
            'cargo' => 'Direção (Referência Apoio)',
            'setor' => 'Apoio',
            'email' => 'thiago@empresa.com.br',
            'gestor_id' => null,
        ]);

        $gerRicardo = Colaborador::create([
            'nome_completo' => 'Ricardo',
            'cargo' => 'Gerência LABOR',
            'setor' => 'LABOR',
            'email' => 'ricardo@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        $gerMarilia = Colaborador::create([
            'nome_completo' => 'Marília',
            'cargo' => 'Gerência LICENC',
            'setor' => 'LICENC',
            'email' => 'marilia@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Gabriel',
            'cargo' => 'Coordenação LICENC',
            'setor' => 'LICENC',
            'email' => 'gabriel@empresa.com.br',
            'gestor_id' => $gerMarilia->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Sergio / Diogo / Neves',
            'cargo' => 'Gerência RIC',
            'setor' => 'RIC',
            'email' => 'ric@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        $gerPedroAlc = Colaborador::create([
            'nome_completo' => 'Pedro Alcântara',
            'cargo' => 'Gerência Manutenção de Poços',
            'setor' => 'Manutenção de Poços',
            'email' => 'pedro.alcantara@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        $gerCarlos = Colaborador::create([
            'nome_completo' => 'Carlos',
            'cargo' => 'Gerência Manutenção + Lodo',
            'setor' => 'Manutenção + Lodo',
            'email' => 'carlos@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Diego',
            'cargo' => 'Supervisão Manutenção',
            'setor' => 'Manutenção + Lodo',
            'email' => 'diego.manut@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Leonardo',
            'cargo' => 'Supervisão Nordeste',
            'setor' => 'Manutenção + Lodo',
            'email' => 'leonardo.ne@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Nelson',
            'cargo' => 'Supervisão PCM',
            'setor' => 'Manutenção + Lodo',
            'email' => 'nelson@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Osias',
            'cargo' => 'Supervisão Lodo',
            'setor' => 'Manutenção + Lodo',
            'email' => 'osias@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'André',
            'cargo' => 'Coordenação CCO',
            'setor' => 'CCO',
            'email' => 'andre.cco@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Beatriz',
            'cargo' => 'Engenharia de Processos',
            'setor' => 'Engenharia de Processos',
            'email' => 'beatriz@empresa.com.br',
            'gestor_id' => $supCapuano->id,
        ]);

        Colaborador::create([
            'nome_completo' => 'Trainee',
            'cargo' => 'Engenharia Trainee',
            'setor' => 'Engenharia de Processos',
            'email' => 'trainee.eng@empresa.com.br',
            'gestor_id' => $gerCarlos->id,
        ]);

        $this->command->info('Colaboradores criados: ' . Colaborador::count());
    }
}