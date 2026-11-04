@extends('layouts.app')

@section('title', 'Cadastros')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-clipboard-list text-lte-purple mr-2"></i> Cadastros
            <span class="badge badge-pill badge-secondary ml-1">{{ $cadastros->count() }}</span>
        </h4>
        <a href="{{ route('organograma.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-sitemap mr-1"></i> Ir para o organograma
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-filter mr-1"></i> Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('cadastros.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Buscar</label>
                    <input type="text" name="busca" class="form-control form-control-sm"
                           value="{{ request('busca') }}" placeholder="Nome do cadastro...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Tipo</label>
                    <select name="tipo" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-lte-purple mr-2">
                        <i class="fas fa-search mr-1"></i> Filtrar
                    </button>
                    <a href="{{ route('cadastros.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela DataTable -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tabelaCadastros" class="table table-hover table-striped table-bordered w-100 mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>Nome</th>
                            <th style="width: 100px;">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cadastros as $cadastro)
                            <tr>
                                <td class="font-weight-bold">{{ $cadastro->nome }}</td>
                                <td>
                                    @if($cadastro->tipo === 'ETA')
                                        <span class="badge badge-primary">ETA</span>
                                    @else
                                        <span class="badge badge-warning">EPAR</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-5">
                                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                    Nenhum cadastro encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
    $(function() {
        $('#tabelaCadastros').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'B>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Imprimir',
                    className: 'btn btn-info btn-sm'
                },
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy mr-1"></i> Copiar',
                    className: 'btn btn-secondary btn-sm'
                }
            ],
            pageLength: -1,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            order: [[0, 'asc']]
        });
    });
</script>
@endsection
