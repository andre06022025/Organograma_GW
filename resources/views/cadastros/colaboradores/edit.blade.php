@extends('layouts.app')

@section('title', 'Editar Colaborador: {{ $colaborador->nome_completo }}')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-edit text-lte-purple mr-2"></i> Editar: {{ $colaborador->nome_completo }}</h4>
        <a href="{{ route('cadastros.colaboradores.index') }}" class="btn btn-outline-secondary">
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
            <h6 class="mb-0 font-weight-bold">Editar Colaborador</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cadastros.colaboradores.update', $colaborador) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="previewFoto" src="{{ $colaborador->foto_url }}" 
                                 alt="{{ $colaborador->nome_completo }}" class="rounded-circle border shadow-sm" style="width: 128px; height: 128px; object-fit: cover;">
                            <label for="foto" class="position-absolute bottom-0 right-0 bg-lte-purple text-white rounded-circle p-2 cursor-pointer hover:bg-lte-purple-dark transition">
                                <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                                <i class="fas fa-camera"></i>
                            </label>
                            @if($colaborador->foto_path)
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
                                <input type="text" name="nome_completo" class="form-control" value="{{ old('nome_completo', $colaborador->nome_completo) }}" required maxlength="150">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Cargo <span class="text-danger">*</span></label>
                                <input type="text" name="cargo" class="form-control" value="{{ old('cargo', $colaborador->cargo) }}" required maxlength="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Setor</label>
                                <input type="text" name="setor" class="form-control" value="{{ old('setor', $colaborador->setor) }}" maxlength="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Região / Atuação</label>
                                <input type="text" name="regiao" class="form-control" value="{{ old('regiao', $colaborador->regiao) }}" maxlength="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Grupo</label>
                                <select name="grupo_id" class="form-control">
                                    <option value="">Selecione um grupo</option>
                                    @foreach($grupos as $g)
                                        <option value="{{ $g->id }}" {{ old('grupo_id', $colaborador->grupo_id) == $g->id ? 'selected' : '' }}>
                                            {{ $g->nome }} ({{ $g->numero }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Área <span class="text-danger">*</span></label>
                                <select name="area" class="form-control" required>
                                    @foreach(\App\Models\Colaborador::AREAS as $valor => $rotulo)
                                        <option value="{{ $valor }}" {{ old('area', $colaborador->area) === $valor ? 'selected' : '' }}>{{ $rotulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Nível <span class="text-danger">*</span></label>
                                <select name="nivel" class="form-control" required>
                                    @foreach(\App\Models\Colaborador::NIVEIS as $valor => $info)
                                        <option value="{{ $valor }}" {{ old('nivel', $colaborador->nivel) === $valor ? 'selected' : '' }}>{{ $info['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label font-weight-bold">Ordem</label>
                                <input type="number" name="ordem" class="form-control" value="{{ old('ordem', $colaborador->ordem ?? 0) }}" min="0" max="999">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Rótulo do card</label>
                                <input type="text" name="rotulo" class="form-control" value="{{ old('rotulo', $colaborador->rotulo) }}" maxlength="150" placeholder="Ex: PEDRO ALC. (vazio = nome completo)">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label font-weight-bold">Nível no card</label>
                                <input type="text" name="nivel_card" class="form-control" value="{{ old('nivel_card', $colaborador->nivel_card) }}" maxlength="50" placeholder="Ex: Gestão Op.">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label font-weight-bold">Cor do card <span class="text-danger">*</span></label>
                                <select name="cor" class="form-control" required>
                                    @foreach(\App\Models\Colaborador::CORES as $valor => $info)
                                        <option value="{{ $valor }}" {{ old('cor', $colaborador->cor ?: 'roxo') === $valor ? 'selected' : '' }}>{{ $info['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" name="ric" id="ric" value="1" class="form-check-input" {{ old('ric', $colaborador->ric) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ric">Participa da RIC (gestão compartilhada)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">E-mail</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $colaborador->email) }}" maxlength="150">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Gestor Direto</label>
                                <select name="gestor_id" class="form-control">
                                    <option value="">Sem gestor (nível superior)</option>
                                    @foreach($gestores as $g)
                                        <option value="{{ $g->id }}" {{ old('gestor_id', $colaborador->gestor_id) == $g->id ? 'selected' : '' }}>
                                            {{ $g->nome_completo }} ({{ $g->cargo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cadastros.colaboradores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-lte-purple">
                                <i class="fas fa-save mr-1"></i> Atualizar
                            </button>
                        </div>
                    </div>
                </div>
                
                @if($colaborador->foto_path)
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
        document.getElementById('previewFoto').src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $colaborador->nome_completo }}') + '&background=6f42c1&color=fff&size=128&rounded=true';
        document.getElementById('foto').value = '';
    }
}
</script>
@endpush