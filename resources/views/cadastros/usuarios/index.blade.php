@extends('layouts.app')

@section('title', 'Cadastro de Usuários')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-cog text-lte-purple mr-2"></i> Usuários do Sistema</h4>
        <a href="{{ route('cadastros.usuarios.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Formulário de Cadastro -->
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Cadastrar Novo Usuário</h6>
            <a href="#" class="btn btn-sm btn-outline-secondary collapsed" data-toggle="collapse" data-target="#formCadastroUsuario" aria-expanded="false">
                <i class="fas fa-chevron-up"></i> Fechar formulário
            </a>
        </div>
        <div class="collapse show" id="formCadastroUsuario">
            <div class="card-body">
                <form action="{{ route('cadastros.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <div class="position-relative d-inline-block">
                                <img id="previewFoto" src="https://ui-avatars.com/api/?name=Novo+Usuario&background=6f42c1&color=fff&size=128&rounded=true" 
                                     alt="Pré-visualização" class="rounded-circle border shadow-sm" style="width: 128px; height: 128px; object-fit: cover;">
                                <label for="foto" class="position-absolute bottom-0 right-0 bg-lte-purple text-white rounded-circle p-2 cursor-pointer hover:bg-lte-purple-dark transition">
                                    <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                                    <i class="fas fa-camera"></i>
                                </label>
                            </div>
                            <small class="form-text text-muted d-block mt-2">JPG, PNG ou WebP (máx. 2MB)</small>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required maxlength="150" placeholder="Nome completo">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Cargo <span class="text-danger">*</span></label>
                                    <input type="text" name="cargo" class="form-control" value="{{ old('cargo') }}" maxlength="100" placeholder="Ex: Analista, Coordenador, Gerente">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Telefone (Celular)</label>
                                    <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" maxlength="20" placeholder="(11) 99999-9999">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Ramal</label>
                                    <input type="text" name="ramal" class="form-control" value="{{ old('ramal') }}" maxlength="20" placeholder="(11) 9999-9999">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Grupo</label>
                                    <select name="grupo_id" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($grupos as $g)
                                            <option value="{{ $g->id }}">{{ $g->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Gestor Direto</label>
                                    <select name="gestor_id" class="form-control">
                                        <option value="">Sem gestor</option>
                                        @foreach($gestores as $g)
                                            <option value="{{ $g->id }}">{{ $g->name }} ({{ $g->cargo ?? $g->role }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required maxlength="150" placeholder="email@empresa.com.br">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Unidade</label>
                                    <input type="text" name="unidade" class="form-control" value="{{ old('unidade') }}" maxlength="100" placeholder="Ex: Matriz, RMSP, Campo">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Senha <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required minlength="6" placeholder="Mínimo 6 caracteres">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Confirmar Senha <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" required minlength="6" placeholder="Confirme a senha">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Perfil <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" required>
                                        <option value="">Selecione</option>
                                        @foreach(\App\Models\User::ROLES as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        @foreach(\App\Models\User::STATUS as $key => $label)
                                            <option value="{{ $key }}" {{ $key === 'ativo' ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-1"></i> Limpar
                                </button>
                                <button type="submit" class="btn btn-lte-purple">
                                    <i class="fas fa-save mr-1"></i> Salvar Usuário
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                            <th style="width: 150px;">Ações</th>
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
                                <td colspan="10" class="text-center text-muted py-5">
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

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('previewFoto');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
