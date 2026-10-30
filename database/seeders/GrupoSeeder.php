<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        Grupo::truncate();

        $grupos = [
            ['nome' => 'TI', 'numero' => '001'],
            ['nome' => 'RH', 'numero' => '002'],
            ['nome' => 'Operações', 'numero' => '003'],
            ['nome' => 'Manutenção', 'numero' => '004'],
            ['nome' => 'Administrativo', 'numero' => '005'],
        ];

        foreach ($grupos as $g) {
            Grupo::create($g);
        }

        $this->command->info('Grupos criados: ' . Grupo::count());
    }
}