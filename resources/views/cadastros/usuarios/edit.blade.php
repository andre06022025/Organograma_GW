@extends('layouts.app')

@section('title', 'Editar Usuário: {{ $usuario->name }}')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-edit text-lte-purple mr-2"></i> Editar: {{ $usuario->name }}</h4>
        <a href="{{ route('cadastros.usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
        </a>
    </div>

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

    <div class="card">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold">Editar Usuário</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cadastros.usuarios.update', $usuario) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="previewFoto" src="{{ $usuario->foto_url }}" 
                                 alt="{{ $usuario->name }}" class="rounded-circle border shadow-sm" style="width: 128px; height: 128px; object-fit: cover;">
                            <label for="foto" class="position-absolute bottom-0 right-0 bg-lte-purple text-white rounded-circle p-2 cursor-pointer hover:bg-lte-purple-dark transition">
                                <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                                <i class="fas fa-camera"></i>
                            </label>
                            @if($usuario->foto_path)
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerFoto()">
                                    <i class="fas fa-trash mr-1"></i> Remover Foto
                                </button>
                            </div>
                            @endif
                        </div>
                        <small class="form-text text-muted d-block mt-2">JPG, PNG ou WebP (máx. 2MB)</small>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Nome Completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required maxlength="150">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Cargo <span class="text-danger">*</span></label>
                                <input type="text" name="cargo" class="form-control" value="{{ old('cargo', $usuario->cargo) }}" maxlength="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Telefone (Celular)</label>
                                <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $usuario->telefone) }}" maxlength="20" placeholder="(11) 99999-9999">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Ramal</label>
                                <input type="text" name="ramal" class="form-control" value="{{ old('ramal', $usuario->ramal) }}" maxlength="20" placeholder="(11) 9999-9999">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Grupo</label>
                                <select name="grupo_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($grupos as $g)
                                        <option value="{{ $g->id }}" {{ old('grupo_id', $usuario->grupo_id) == $g->id ? 'selected' : '' }}>{{ $g->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Gestor Direto</label>
                                <select name="gestor_id" class="form-control">
                                    <option value="">Sem gestor</option>
                                    @foreach($gestores as $g)
                                        <option value="{{ $g->id }}" {{ old('gestor_id', $usuario->gestor_id) == $g->id ? 'selected' : '' }}>
                                            {{ $g->name }} ({{ $g->cargo ?? $g->role }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">E-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required maxlength="150">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Unidade</label>
                                <input type="text" name="unidade" class="form-control" value="{{ old('unidade', $usuario->unidade) }}" maxlength="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Nova Senha</label>
                                <input type="password" name="password" class="form-control" minlength="6" placeholder="Deixe em branco para não alterar">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Confirmar Nova Senha</label>
                                <input type="password" name="password_confirmation" class="form-control" minlength="6" placeholder="Confirme a nova senha">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Perfil <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    @foreach(\App\Models\User::ROLES as $key => $label)
                                        <option value="{{ $key }}" {{ old('role', $usuario->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    @foreach(\App\Models\User::STATUS as $key => $label)
                                        <option value="{{ $key }}" {{ old('status', $usuario->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cadastros.usuarios.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-lte-purple">
                                <i class="fas fa-save mr-1"></i> Atualizar
                            </button>
                        </div>
                    </div>
                </div>
                
                @if($usuario->foto_path)
                <input type="hidden" name="remover_foto" id="remover_foto_input" value="0">
                @endif
            </form>
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

function removerFoto() {
    if (confirm('Confirma a remoção da foto?')) {
        document.getElementById('remover_foto_input').value = '1';
        document.getElementById('previewFoto').src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $usuario->name }}') + '&background=6f42c1&color=fff&size=128&rounded=true';
        document.getElementById('foto').value = '';
    }
}
</script>
@endpush