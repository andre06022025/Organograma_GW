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

    /**
     * Estrutura hierárquica suportada.
     * A ordem do array define a precedência dentro de um mesmo setor.
     */
    public const NIVEIS = [
        'direcao' => ['label' => 'Direção', 'peso' => 0],
        'superintendencia' => ['label' => 'Superintendência', 'peso' => 1],
        'gerencia' => ['label' => 'Gerência', 'peso' => 2],
        'coordenacao' => ['label' => 'Coordenação', 'peso' => 3],
        'supervisao' => ['label' => 'Supervisão', 'peso' => 4],
        'operador_lider' => ['label' => 'Operador Líder', 'peso' => 5],
        'trainee' => ['label' => 'Trainee', 'peso' => 6],
    ];

    public const AREAS = [
        'producao' => 'Áreas de Produção',
        'apoio' => 'Áreas de Apoio',
        'corporativo' => 'Corporativo',
    ];

    protected $fillable = [
        'nome_completo',
        'cargo',
        'foto_path',
        'gestor_id',
        'email',
        'setor',
        'nivel',
        'area',
        'ordem',
        'ric',
        'grupo_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'ric' => 'boolean',
        'ordem' => 'integer',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // Relacionamentos
    public function gestor(): BelongsTo
    {
        return $this->belongsTo(Colaborador::class, 'gestor_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(Colaborador::class, 'gestor_id')
            ->orderBy('nome_completo');
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

    public function scopeDaArea($query, ?string $area)
    {
        return $area ? $query->where('area', $area) : $query;
    }

    public function scopePorNivel($query)
    {
        return $query->orderBy('ordem')->orderBy('nome_completo');
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

    public function getNivelLabelAttribute(): string
    {
        return self::NIVEIS[$this->nivel]['label'] ?? 'Colaborador';
    }

    public function getPesoNivelAttribute(): int
    {
        return self::NIVEIS[$this->nivel]['peso'] ?? 99;
    }

    /**
     * Classe de cor do card conforme área + nível.
     * As classes precisam existir literalmente para o Tailwind gerar o CSS
     * (resources/css/app.css inclui os arquivos de app no @source).
     */
    public function getCorNivelAttribute(): string
    {
        if ($this->nivel === 'direcao') {
            return 'bg-lte-orange';
        }

        $mapa = [
            'producao' => [
                'direcao' => 'bg-lte-orange',
                'superintendencia' => 'bg-lte-cyan',
                'gerencia' => 'bg-lte-purple',
                'coordenacao' => 'bg-lte-purple',
                'supervisao' => 'bg-lte-purple/90',
                'operador_lider' => 'bg-lte-purple/80',
                'trainee' => 'bg-lte-purple-dark',
            ],
            'apoio' => [
                'direcao' => 'bg-lte-orange',
                'superintendencia' => 'bg-lte-cyan',
                'gerencia' => 'bg-lte-navy',
                'coordenacao' => 'bg-lte-cyan',
                'supervisao' => 'bg-lte-navy/90',
                'operador_lider' => 'bg-lte-cyan/90',
                'trainee' => 'bg-lte-navy/80',
            ],
        ];

        $area = $this->area ?: 'producao';

        return $mapa[$area][$this->nivel]
            ?? ($area === 'apoio' ? 'bg-lte-navy' : 'bg-lte-purple');
    }

    // Montar árvore hierárquica completa (sem limite de profundidade)
    public static function getArvoreOrganograma(): array
    {
        $todos = self::ativos()->with(['grupo', 'gestor'])->get();
        $porId = $todos->keyBy('id');

        // Ordena por peso de nível e nome
        $ordenados = $todos->sortBy(fn ($c) => [$c->peso_nivel, mb_strtolower((string) $c->nome_completo)]);

        // Garante que cada nó tenha sua coleção de subordinados
        foreach ($todos as $colaborador) {
            $colaborador->setRelation('subordinados', collect());
        }

        foreach ($ordenados as $colaborador) {
            if ($colaborador->gestor_id && $porId->has($colaborador->gestor_id)) {
                $porId->get($colaborador->gestor_id)->subordinados->push($colaborador);
            }
        }

        $raizes = $todos->filter(
            fn ($c) => !$c->gestor_id || !$porId->has($c->gestor_id)
        );

        return $raizes->map(fn ($c) => $c->toTreeNode())->values()->toArray();
    }

    public function toTreeNode(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome_completo,
            'cargo' => $this->cargo,
            'setor' => $this->setor,
            'nivel' => $this->nivel,
            'label_nivel' => $this->nivel_label,
            'cor_nivel' => $this->cor_nivel,
            'area' => $this->area,
            'grupo' => $this->grupo ? [
                'id' => $this->grupo->id,
                'nome' => $this->grupo->nome,
                'numero' => $this->grupo->numero,
            ] : null,
            'email' => $this->email,
            'foto_url' => $this->foto_url,
            'children' => $this->subordinados
                ->sortBy(fn ($s) => [$s->peso_nivel, mb_strtolower((string) $s->nome_completo)])
                ->map(fn ($s) => $s->toTreeNode())
                ->values()
                ->toArray(),
        ];
    }
}
