<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Colaborador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colaboradores';

    protected $fillable = [
        'nome_completo',
        'cargo',
        'foto_path',
        'gestor_id',
        'email',
        'setor',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // Relacionamentos
    public function gestor(): BelongsTo
    {
        return $this->belongsTo(Colaborador::class, 'gestor_id');
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(Colaborador::class, 'gestor_id')
            ->orderBy('nome_completo');
    }

    public function subordinadosRecursivos(): HasMany
    {
        return $this->hasMany(Colaborador::class, 'gestor_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeRaiz($query)
    {
        return $query->whereNull('gestor_id');
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('setor')->orderBy('cargo')->orderBy('nome_completo');
    }

    // Accessors
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            return Storage::url($this->foto_path);
        }
        // Fallback: UI Avatars com as iniciais
        return "https://ui-avatars.com/api/?name=" . urlencode($this->nome_completo) . "&background=6f42c1&color=fff&size=128&rounded=true";
    }

    // Montar árvore hierárquica completa
    public static function getArvoreOrganograma(): array
    {
        return self::ativos()
            ->raiz()
            ->with('subordinadosRecursivos.subordinadosRecursivos.subordinadosRecursivos')
            ->get()
            ->map(fn($c) => $c->toTreeNode())
            ->toArray();
    }

    public function toTreeNode(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome_completo,
            'cargo' => $this->cargo,
            'setor' => $this->setor,
            'email' => $this->email,
            'foto_url' => $this->foto_url,
            'children' => $this->subordinados
                ->sortBy('nome_completo')
                ->map(fn($s) => $s->toTreeNode())
                ->values()
                ->toArray(),
        ];
    }
}