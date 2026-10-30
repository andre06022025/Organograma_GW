@extends('layouts.app')

@section('title', 'Organograma GW - Gerenciar Pessoas')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-people me-2"></i> Pessoas</h4>
            <button class="btn btn-primary" onclick="novoPessoa()">
                <i class="bi bi-plus-lg me-1"></i> Nova Pessoa
            </button>
        </div>
        
        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label small mb-1">Buscar</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="filtroBusca" placeholder="Nome, cargo...">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label small mb-1">Sistema</label>
                        <select class="form-select form-select-sm" id="filtroSistema">
                            <option value="">Todos</option>
                            @foreach($sistemas as $s)
                                <option value="{{ $s->id }}">{{ $s->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label small mb-1">Nível</label>
                        <select class="form-select form-select-sm" id="filtroNivel">
                            <option value="">Todos</option>
                            @foreach($niveis as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label small mb-1">Status</label>
                        <select class="form-select form-select-sm" id="filtroStatus">
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm flex-fill" onclick="limparFiltros()">
                            <i class="bi bi-x-circle me-1"></i> Limpar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabela -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-organograma mb-0" id="tabelaPessoas">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nome</th>
                                <th style="width: 140px;">Cargo</th>
                                <th style="width: 130px;">Nível</th>
                                <th style="width: 180px;">Sistema / Área</th>
                                <th style="width: 120px;">Gestor</th>
                                <th style="width: 100px;">Região</th>
                                <th style="width: 80px;">Status</th>
                                <th style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pessoas as $pessoa)
                                <tr data-id="{{ $pessoa->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $pessoa->nome }}</td>
                                    <td>{{ $pessoa->cargo }}</td>
                                    <td>
                                        <span class="badge badge-nivel" style="background: {{ $pessoa->cor_nivel }}">
                                            {{ $pessoa->label_nivel }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($pessoa->sistema)
                                            <div class="small">
                                                <strong>{{ $pessoa->sistema->nome }}</strong>
                                                @if($pessoa->sistema->area)
                                                    <br><span class="text-muted">{{ $pessoa->sistema->area->nome }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pessoa->gestor)
                                            <small>{{ $pessoa->gestor->nome }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pessoa->regiao)
                                            <small>{{ Str::limit($pessoa->regiao, 25) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pessoa->ativo)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-secondary">Inativo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="editarPessoa({{ json_encode($pessoa->only(['id','nome','cargo','nivel','sistema_id','gestor_id','email','telefone','veiculo','turno','regiao','observacoes','data_admissao','ordem','ativo'])) }})" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" onclick="excluirPessoa({{ $pessoa->id }}, '{{ $pessoa->nome }}')" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        Nenhuma pessoa cadastrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                @if($pessoas->hasPages())
                    <div class="card-footer px-3 py-2">
                        {{ $pessoas->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function novoPessoa() {
    document.getElementById('formPessoa').reset();
    document.getElementById('pessoa_id').value = '';
    document.getElementById('pessoa_ativo').checked = true;
    document.getElementById('pessoa_ordem').value = 0;
    document.getElementById('btnSalvarPessoa').innerHTML = '<i class="bi bi-save me-1"></i> Salvar';
    
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasCadastros'));
    offcanvas.show();
    
    const tab = new bootstrap.Tab(document.getElementById('aba-pessoa-tab'));
    tab.show();
}

function limparFiltros() {
    document.getElementById('filtroBusca').value = '';
    document.getElementById('filtroSistema').value = '';
    document.getElementById('filtroNivel').value = '';
    document.getElementById('filtroStatus').value = '1';
    // Recarregar com filtros padrão
    window.location.href = '{{ route('organograma.pessoas.index') }}';
}

// Filtros com debounce
let filtroTimeout;
['filtroBusca', 'filtroSistema', 'filtroNivel', 'filtroStatus'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', () => {
            clearTimeout(filtroTimeout);
            filtroTimeout = setTimeout(aplicarFiltros, 300);
        });
        el.addEventListener('change', aplicarFiltros);
    }
});

function aplicarFiltros() {
    const params = new URLSearchParams();
    const busca = document.getElementById('filtroBusca').value.trim();
    const sistema = document.getElementById('filtroSistema').value;
    const nivel = document.getElementById('filtroNivel').value;
    const status = document.getElementById('filtroStatus').value;
    
    if (busca) params.set('busca', busca);
    if (sistema) params.set('sistema_id', sistema);
    if (nivel) params.set('nivel', nivel);
    if (status !== '') params.set('ativo', status);
    
    window.location.href = '{{ route('organograma.pessoas.index') }}?' + params.toString();
}

async function excluirPessoa(id, nome) {
    if (!confirm(`Confirma a exclusão de "${nome}"?`)) return;
    
    try {
        const response = await fetch('{{ route('organograma.pessoas.destroy', ':id') }}'.replace(':id', id), {
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