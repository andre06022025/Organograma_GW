<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'cadastros';

    protected $fillable = [
        'nome',
        'tipo',
    ];

    public const TIPOS = [
        'ETA' => 'ETA',
        'EPAR' => 'EPAR',
    ];

    public function scopeDoTipo($query, ?string $tipo)
    {
        return $tipo ? $query->where('tipo', $tipo) : $query;
    }
}
