<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Grupo::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

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