<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nome',
        'numero',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function colaboradores(): HasMany
    {
        return $this->hasMany(Colaborador::class, 'grupo_id');
    }

    public function scopeAtivos($query)
    {
        return $query->orderBy('numero');
    }
}