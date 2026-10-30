@extends('layouts.app')

@section('title', 'Cadastro de Usuários')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-cog text-lte-purple mr-2"></i> Usuários do Sistema</h4>
        <a href="{{ route('cadastros.usuarios.create') }}" class="btn btn-lte-purple">
            <i class="fas fa-plus mr-1"></i> Novo Usuário
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
                <div class="col-md-3">
                    <label class="form-label small">Buscar</label>
                    <input type="text" name="busca" class="form-control form-control-sm" 
                           value="{{ request('busca') }}" placeholder="Nome, e-mail, cargo...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Perfil</label>
                    <select name="role" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach(\App\Models\User::ROLES as $key => $label)
                            <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach(\App\Models\User::STATUS as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Grupo</label>
                    <select name="grupo_id" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($grupos as $g)
                            <option value="{{ $g->id }}" {{ request('grupo_id') == $g->id ? 'selected' : '' }}>{{ $g->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-lte-purple mr-2"><i class="fas fa-search mr-1"></i> Filtrar</button>
                    <a href="{{ route('cadastros.usuarios.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
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
                            <th style="width: 50px;">Foto</th>
                            <th>Nome Completo</th>
                            <th style="width: 120px;">Cargo</th>
                            <th style="width: 120px;">Telefone</th>
                            <th style="width: 150px;">E-mail</th>
                            <th style="width: 120px;">Grupo</th>
                            <th style="width: 100px;">Perfil</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 120px;">Gestor</th>
                            <th style="width: 150px;">Sistemas</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $usuario->foto_url }}" alt="{{ $usuario->name }}" 
                                         class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td class="font-weight-bold">{{ $usuario->name }}</td>
                                <td>{{ $usuario->cargo ?? '-' }}</td>
                                <td>{{ $usuario->telefone ?? $usuario->ramal ?? '-' }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->grupo?->nome ?? '-' }}</td>
                                <td>
                                    <span class="badge" style="background: {{ 
                                        $usuario->role === 'admin' ? '#dc3545' : 
                                        ($usuario->role === 'gestao' ? '#fd7e14' : 
                                        ($usuario->role === 'operador' ? '#17a2b8' : '#6c757d')) }}">
                                        {{ $usuario->role_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($usuario->status === 'ativo')
                                        <span class="badge badge-success">Ativo</span>
                                    @else
                                        <span class="badge badge-secondary">Inativo</span>
                                    @endif
                                </td>
                                <td>{{ $usuario->gestor?->name ?? '-' }}</td>
                                <td><span class="text-muted">-</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('cadastros.usuarios.edit', $usuario) }}" 
                                           class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($usuario->id !== auth()->id())
                                            <form action="{{ route('cadastros.usuarios.destroy', $usuario) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Confirma a exclusão de {{ $usuario->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-5">
                                    <i class="fas fa-user-friends fa-2x mb-2 d-block"></i>
                                    Nenhum usuário encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($usuarios->hasPages())
                <div class="card-footer px-4 py-3">
                    {{ $usuarios->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection