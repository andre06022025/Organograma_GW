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
        'operacao',
        'operadores',
        'numero_pocos',
        'quantidade_operadores',
    ];

    protected $casts = [
        'operadores' => 'array',
        'numero_pocos' => 'integer',
        'quantidade_operadores' => 'integer',
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
