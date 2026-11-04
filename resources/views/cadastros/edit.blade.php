@extends('layouts.app')

@section('title', 'Editar Cadastro: ' . $cadastro->nome)

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-edit text-lte-purple mr-2"></i> Editar: {{ $cadastro->nome }}</h4>
        <a href="{{ route('cadastros.index') }}" class="btn btn-outline-secondary">
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
            <h6 class="mb-0 font-weight-bold">Informações do Cadastro</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cadastros.update', $cadastro) }}" method="POST">
                @csrf
                @method('PUT')

                @include('cadastros._form')

                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('cadastros.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-lte-purple">
                        <i class="fas fa-save mr-1"></i> Atualizar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
