<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganogramaArea extends Model
{
    protected $table = 'organograma_areas';

    protected $fillable = [
        'superintendencia_id',
        'nome',
        'sigla',
        'tipo',
        'gerente_id',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    public function superintendencia(): BelongsTo
    {
        return $this->belongsTo(OrganogramaSuperintendencia::class, 'superintendencia_id');
    }

    public function sistemas(): HasMany
    {
        return $this->hasMany(OrganogramaSistema::class, 'area_id');
    }

    public function sistemasAtivos(): HasMany
    {
        return $this->sistemas()->where('ativo', true);
    }

    public function gerente(): BelongsTo
    {
        return $this->belongsTo(OrganogramaPessoa::class, 'gerente_id');
    }

    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    public function scopeProducao($query)
    {
        return $query->where('tipo', 'producao');
    }

    public function scopeApoio($query)
    {
        return $query->where('tipo', 'apoio');
    }
}