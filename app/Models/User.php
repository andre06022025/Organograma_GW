<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'foto_path', 'ramal', 'unidade', 'cargo', 'telefone', 'grupo_id', 'gestor_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLES = [
        'admin' => 'Administrador',
        'gestao' => 'Gestão',
        'operador' => 'Operador',
        'visualizador' => 'Visualizador',
    ];

    public const STATUS = [
        'ativo' => 'Ativo',
        'inativo' => 'Inativo',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacionamentos
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function gestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(User::class, 'gestor_id');
    }

    public function sistemas(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\OrganogramaSistema::class, 'user_sistema', 'user_id', 'sistema_id')
            ->withTimestamps();
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            return Storage::url($this->foto_path);
        }
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=6f42c1&color=fff&size=128&rounded=true";
    }

    public function getRoleLabelAttribute(): string
    {
        if ($this->role === null) {
            return 'Sem perfil';
        }
        return self::ROLES[$this->role] ?? $this->role ?? 'Sem perfil';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGestao(): bool
    {
        return in_array($this->role, ['admin', 'gestao']);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}