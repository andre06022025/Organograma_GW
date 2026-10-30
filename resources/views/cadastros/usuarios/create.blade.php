@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-plus text-lte-purple mr-2"></i> Novo Usuário</h4>
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
            <h6 class="mb-0 font-weight-bold">Dados do Usuário</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cadastros.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="previewFoto" src="https://ui-avatars.com/api/?name=Novo+Usuário&background=6f42c1&color=fff&size=128&rounded=true" 
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
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Sistemas de Acesso</label>
                            <div class="row">
                                @foreach($sistemas as $s)
                                    <div class="col-md-3 mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="sistemas[]" value="{{ $s->id }}" class="custom-control-input" id="sistema_{{ $s->id }}">
                                            <label class="custom-control-label small" for="sistema_{{ $s->id }}">
                                                <strong>{{ $s->sigla ?? $s->nome }}</strong>
                                                @if($s->nome != $s->sigla)
                                                    <br><span class="text-muted">{{ $s->nome }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cadastros.usuarios.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Cancelar
                            </a>
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