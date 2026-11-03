@extends('layouts.app')

@section('title', 'Cadastro de Colaboradores')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-users-cog text-lte-purple mr-2"></i> Colaboradores</h4>
        <a href="{{ route('cadastros.colaboradores.create') }}" class="btn btn-lte-purple">
            <i class="fas fa-plus mr-1"></i> Novo Colaborador
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-filter mr-1"></i> Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small">Buscar</label>
                    <input type="text" name="busca" class="form-control form-control-sm" 
                           value="{{ request('busca') }}" placeholder="Nome, cargo, setor...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Setor</label>
                    <select name="setor" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($setores as $s)
                            <option value="{{ $s }}" {{ request('setor') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5 d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-lte-purple mr-2"><i class="fas fa-search mr-1"></i> Filtrar</button>
                    <a href="{{ route('cadastros.colaboradores.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th style="width: 60px;">Foto</th>
                            <th>Nome Completo</th>
                            <th style="width: 150px;">Cargo</th>
                            <th style="width: 120px;">Setor</th>
                            <th style="width: 100px;">Grupo</th>
                            <th style="width: 100px;">Gestor</th>
                            <th style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colaboradores as $colab)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $colab->foto_url }}" alt="{{ $colab->nome_completo }}" 
                                         class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td class="font-weight-bold">{{ $colab->nome_completo }}</td>
                                <td>{{ $colab->cargo }}</td>
                                <td>{{ $colab->setor ?? '-' }}</td>
                                <td>
                                    @if($colab->grupo)
                                        <small>{{ $colab->grupo->nome }} ({{ $colab->grupo->numero }})</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($colab->gestor)
                                        <small>{{ $colab->gestor->nome_completo }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('cadastros.colaboradores.edit', $colab) }}" 
                                           class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cadastros.colaboradores.destroy', $colab) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Confirma a exclusão de {{ $colab->nome_completo }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    Nenhum colaborador encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($colaboradores->hasPages())
                <div class="card-footer px-4 py-3">
                    {{ $colaboradores->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection