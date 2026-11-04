<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'cadastros';

    protected $fillable = [
        'nome',
        'tipo',
        'gestor_id',
        'sistema',
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

    public const SISTEMAS = [
        'Sistemas 1' => 'Sistemas 1',
        'Sistemas 2' => 'Sistemas 2',
        'Sistemas 3+4' => 'Sistemas 3+4',
        'Sistemas 5' => 'Sistemas 5',
        'Sistemas 6' => 'Sistemas 6',
        'Sistemas 7' => 'Sistemas 7',
        'Sistemas 8' => 'Sistemas 8',
        'Sistemas 9' => 'Sistemas 9',
    ];

    public function gestor(): BelongsTo
    {
        return $this->belongsTo(Colaborador::class, 'gestor_id');
    }

    public const TIPOS = [
        'ETA' => 'ETA',
        'EPAR' => 'EPAR',
    ];

    public function scopeDoTipo($query, ?string $tipo)
    {
        return $tipo ? $query->where('tipo', $tipo) : $query;
    }
}
