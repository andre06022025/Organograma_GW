@extends('layouts.app')

@section('title', 'Organograma GW - Gerenciar Sistemas/Áreas')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-diagram-3 me-2"></i> Sistemas / Áreas</h4>
            <button class="btn btn-primary" onclick="novoSistema()">
                <i class="bi bi-plus-lg me-1"></i> Novo Sistema
            </button>
        </div>
        
        <!-- Estatísticas rápidas -->
        <div class="row g-2 mb-3">
            <div class="col-12 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-2"><i class="bi bi-diagram-3 fs-4"></i></div>
                    <div class="fw-bold fs-4">{{ $sistemas->total() }}</div>
                    <small class="text-muted">Total de Sistemas</small>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-2"><i class="bi bi-building fs-4"></i></div>
                    <div class="fw-bold fs-4">{{ $sistemas->pluck('area_id')->unique()->count() }}</div>
                    <small class="text-muted">Áreas</small>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-2"><i class="bi bi-people fs-4"></i></div>
                    <div class="fw-bold fs-4">{{ $sistemas->sum('pessoas_ativas_count') }}</div>
                    <small class="text-muted">Pessoas Vinculadas</small>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info mx-auto mb-2"><i class="bi bi-diagram-2 fs-4"></i></div>
                    <div class="fw-bold fs-4">{{ $sistemas->pluck('area.superintendencia_id')->unique()->count() }}</div>
                    <small class="text-muted">Superintendências</small>
                </div>
            </div>
        </div>
        
        <!-- Tabela -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-organograma mb-0" id="tabelaSistemas">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Sistema</th>
                                <th style="width: 100px;">Sigla</th>
                                <th style="width: 180px;">Área / Tipo</th>
                                <th style="width: 180px;">Superintendência</th>
                                <th style="width: 150px;">Coordenador</th>
                                <th style="width: 80px;">Pessoas</th>
                                <th style="width: 80px;">Status</th>
                                <th style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sistemas as $sistema)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $sistema->nome }}</td>
                                    <td>
                                        @if($sistema->sigla)
                                            <code class="text-primary">{{ $sistema->sigla }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sistema->area)
                                            <div>
                                                <span class="badge bg-{{ $sistema->area->tipo === 'producao' ? 'primary' : 'warning' }} me-1">
                                                    {{ $sistema->area->tipo === 'producao' ? 'Produção' : 'Apoio' }}
                                                </span>
                                                <strong>{{ $sistema->area->nome }}</strong>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sistema->area && $sistema->area->superintendencia)
                                            {{ $sistema->area->superintendencia->nome }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sistema->coordenador)
                                            <small>{{ $sistema->coordenador->nome }}</small>
                                            <br><span class="badge badge-nivel" style="background: {{ $sistema->coordenador->cor_nivel }}">{{ $sistema->coordenador->label_nivel }}</span>
                                        @else
                                            <span class="text-muted">Não definido</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $sistema->pessoas_ativas_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($sistema->ativo)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-secondary">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="editarSistema({{ json_encode($sistema->only(['id','nome','sigla','descricao','area_id','coordenador_id','ordem','ativo'])) }})" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="excluirSistema({{ $sistema->id }}, '{{ $sistema->nome }}')" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <i class="bi bi-diagram-3 fs-1 d-block mb-2"></i>
                                        Nenhum sistema cadastrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($sistemas->hasPages())
                    <div class="card-footer px-3 py-2">
                        {{ $sistemas->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function novoSistema() {
    document.getElementById('formSistema').reset();
    document.getElementById('sistema_id').value = '';
    document.getElementById('sistema_ativo').checked = true;
    document.getElementById('sistema_ordem').value = 0;
    document.getElementById('btnSalvarSistema').innerHTML = '<i class="bi bi-save me-1"></i> Salvar';
    
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCadastros'));
    offcanvas.show();
    
    const tab = new bootstrap.Tab(document.getElementById('aba-sistema-tab'));
    tab.show();
}

async function excluirSistema(id, nome) {
    if (!confirm(`Confirma a exclusão do sistema "${nome}"?`)) return;
    
    try {
        const response = await fetch('{{ route('organograma.sistemas.destroy', ':id') }}'.replace(':id', id), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
        });
        
        if (response.ok) {
            location.reload();
        } else {
            const data = await response.json();
            alert(data.message || 'Erro ao excluir');
        }
    } catch (err) {
        console.error(err);
        alert('Erro de conexão');
    }
}
</script>
@endsection