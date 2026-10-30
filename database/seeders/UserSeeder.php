<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        $grupoTec = Grupo::where('numero', '001')->first(); // TI
        $grupoRh = Grupo::where('numero', '002')->first();  // RH

        // Admin do sistema
        User::create([
            'name' => 'Admin GW',
            'email' => 'admin@gw.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'status' => 'ativo',
            'cargo' => 'Coordenador de TI',
            'telefone' => '(11) 99999-0001',
            'ramal' => '1001',
            'unidade' => 'Matriz',
            'foto_path' => null,
            'grupo_id' => $grupoTec?->id,
            'gestor_id' => null,
        ]);

        // Usuários de exemplo
        $usuarios = [
            [
                'name' => 'Carlos Silva',
                'email' => 'carlos.silva@gw.com',
                'password' => Hash::make('123456'),
                'role' => 'gestao',
                'status' => 'ativo',
                'cargo' => 'Gerente de Operações',
                'telefone' => '(11) 98888-0002',
                'ramal' => '1002',
                'unidade' => 'Matriz',
                'grupo_id' => $grupoTec?->id,
                'gestor_id' => null,
            ],
            [
                'name' => 'Mariana Souza',
                'email' => 'mariana.souza@gw.com',
                'password' => Hash::make('123456'),
                'role' => 'operador',
                'status' => 'ativo',
                'cargo' => 'Analista de RH',
                'telefone' => '(11) 97777-0003',
                'ramal' => '1003',
                'unidade' => 'Filial Norte',
                'grupo_id' => $grupoRh?->id,
                'gestor_id' => null,
            ],
            [
                'name' => 'Roberto Almeida',
                'email' => 'roberto.almeida@gw.com',
                'password' => Hash::make('123456'),
                'role' => 'visualizador',
                'status' => 'inativo',
                'cargo' => 'Estagiário',
                'telefone' => '(11) 96666-0004',
                'ramal' => '1004',
                'unidade' => 'Filial Sul',
                'grupo_id' => $grupoTec?->id,
                'gestor_id' => null,
            ],
        ];

        foreach ($usuarios as $dados) {
            User::create($dados);
        }

        $this->command->info('Usuários criados: ' . User::count());
    }
}
