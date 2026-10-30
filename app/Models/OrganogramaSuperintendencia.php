<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganogramaSuperintendencia extends Model
{
    protected $table = 'organograma_superintendencias';

    protected $fillable = [
        'nome',
        'sigla',
        'diretor_id',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(OrganogramaArea::class, 'superintendencia_id');
    }

    public function areasAtivas(): HasMany
    {
        return $this->areas()->where('ativo', true);
    }

    public function diretor(): BelongsTo
    {
        return $this->belongsTo(OrganogramaPessoa::class, 'diretor_id');
    }

    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }
}