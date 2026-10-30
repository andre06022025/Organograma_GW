<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;

class OrganogramaPessoa extends Model
{
    protected $table = 'organograma_pessoas';

    protected $fillable = [
        'sistema_id',
        'gestor_id',
        'nome',
        'cargo',
        'nivel',
        'email',
        'telefone',
        'veiculo',
        'turno',
        'regiao',
        'observacoes',
        'data_admissao',
        'ativo',
        'ordem',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
        'data_admissao' => 'date',
    ];

    public const NIVEIS = [
        'direcao' => 'Direção',
        'superintendencia' => 'Superintendência',
        'gerencia' => 'Gerência',
        'coordenacao' => 'Coordenação',
        'supervisao' => 'Supervisão',
        'operador_lider' => 'Operador Líder',
        'operador' => 'Operador',
        'ferista' => 'Ferista',
        'apoio' => 'Apoio',
        'estagiario' => 'Estagiário',
        'trainee' => 'Trainee',
        'outro' => 'Outro',
    ];

    public const NIVEIS_ORDEM = [
        'direcao' => 1,
        'superintendencia' => 2,
        'gerencia' => 3,
        'coordenacao' => 4,
        'supervisao' => 5,
        'operador_lider' => 6,
        'operador' => 7,
        'ferista' => 8,
        'apoio' => 9,
        'estagiario' => 10,
        'trainee' => 11,
        'outro' => 12,
    ];

    public const NIVEIS_CORES = [
        'direcao' => '#1e3a8a',
        'superintendencia' => '#1e40af',
        'gerencia' => '#2563eb',
        'coordenacao' => '#3b82f6',
        'supervisao' => '#60a5fa',
        'operador_lider' => '#93c5fd',
        'operador' => '#bfdbfe',
        'ferista' => '#fbbf24',
        'apoio' => '#f59e0b',
        'estagiario' => '#a3e635',
        'trainee' => '#4ade80',
        'outro' => '#9ca3af',
    ];

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(OrganogramaSistema::class, 'sistema_id');
    }

    public function gestor(): BelongsTo
    {
        return $this->belongsTo(OrganogramaPessoa::class, 'gestor_id');
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(OrganogramaPessoa::class, 'gestor_id');
    }

    public function subordinadosAtivos(): HasMany
    {
        return $this->subordinados()->where('ativo', true);
    }

    public function areasGerenciadas(): HasMany
    {
        return $this->hasMany(OrganogramaArea::class, 'gerente_id');
    }

    public function sistemasCoordenados(): HasMany
    {
        return $this->hasMany(OrganogramaSistema::class, 'coordenador_id');
    }

    public function superintendenciasDirigidas(): HasMany
    {
        return $this->hasMany(OrganogramaSuperintendencia::class, 'diretor_id');
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorNivel($query, string $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    public function scopePorSistema($query, int $sistemaId)
    {
        return $query->where('sistema_id', $sistemaId);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderByRaw("FIELD(nivel, " . implode(',', array_map(fn($k) => "'$k'", array_keys(self::NIVEIS_ORDEM))) . ")")
                    ->orderBy('ordem')
                    ->orderBy('nome');
    }

    public function getCorNivelAttribute(): string
    {
        return self::NIVEIS_CORES[$this->nivel] ?? '#9ca3af';
    }

    public function getLabelNivelAttribute(): string
    {
        return self::NIVEIS[$this->nivel] ?? $this->nivel;
    }

    public function getOrdemNivelAttribute(): int
    {
        return self::NIVEIS_ORDEM[$this->nivel] ?? 99;
    }

    public function getSubordinadosRecursivos(): Collection
    {
        $resultado = new Collection();
        $this->carregarSubordinadosRecursivo($resultado);
        return $resultado;
    }

    protected function carregarSubordinadosRecursivo(Collection $colecao): void
    {
        foreach ($this->subordinadosAtivos as $sub) {
            $colecao->push($sub);
            $sub->carregarSubordinadosRecursivo($colecao);
        }
    }

    public function getArvoreCompleta(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cargo' => $this->cargo,
            'nivel' => $this->nivel,
            'label_nivel' => $this->label_nivel,
            'cor_nivel' => $this->cor_nivel,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'veiculo' => $this->veiculo,
            'turno' => $this->turno,
            'regiao' => $this->regiao,
            'sistema' => $this->sistema?->nome,
            'area' => $this->sistema?->area?->nome,
            'superintendencia' => $this->sistema?->area?->superintendencia?->nome,
            'gestor_id' => $this->gestor_id,
            'subordinados' => $this->subordinadosAtivos
                ->sortBy(fn($p) => [$p->ordem_nivel, $p->ordem, $p->nome])
                ->map(fn($p) => $p->getArvoreCompleta())
                ->values()
                ->toArray(),
        ];
    }

    public static function getOpcoesNivel(): array
    {
        return self::NIVEIS;
    }
}