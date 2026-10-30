<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganogramaSistema extends Model
{
    protected $table = 'organograma_sistemas';

    protected $fillable = [
        'area_id',
        'nome',
        'sigla',
        'descricao',
        'coordenador_id',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(OrganogramaArea::class, 'area_id');
    }

    public function superintendencia(): BelongsTo
    {
        return $this->belongsTo(OrganogramaSuperintendencia::class, 'superintendencia_id');
    }

    public function pessoas(): HasMany
    {
        return $this->hasMany(OrganogramaPessoa::class, 'sistema_id');
    }

    public function pessoasAtivas(): HasMany
    {
        return $this->pessoas()->where('ativo', true);
    }

    public function coordenador(): BelongsTo
    {
        return $this->belongsTo(OrganogramaPessoa::class, 'coordenador_id');
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    public function getHierarquiaAttribute(): array
    {
        return [
            'superintendencia' => $this->area?->superintendencia?->nome,
            'area' => $this->area?->nome,
            'sistema' => $this->nome,
        ];
    }
}