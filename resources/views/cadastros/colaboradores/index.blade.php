@extends('layouts.app')

@section('title', 'Cadastro de Colaboradores')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@endsection

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
            <form method="GET" class="row g-3" id="filtrosForm">
                <div class="col-md-4">
                    <label class="form-label small">Buscar</label>
                    <input type="text" name="busca" class="form-control form-control-sm" 
                           value="{{ request('busca') }}" placeholder="Nome, cargo, setor..." id="filtroBusca">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Setor</label>
                    <select name="setor" class="form-control form-control-sm" id="filtroSetor">
                        <option value="">Todos</option>
                        @foreach($setores as $s)
                            <option value="{{ $s }}" {{ request('setor') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Grupo</label>
                    <select name="grupo" class="form-control form-control-sm" id="filtroGrupo">
                        <option value="">Todos</option>
                        @foreach($grupos as $g)
                            <option value="{{ $g->id }}" {{ request('grupo') == $g->id ? 'selected' : '' }}>{{ $g->nome }} ({{ $g->numero }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-lte-purple mr-2 w-100"><i class="fas fa-search mr-1"></i> Filtrar</button>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('cadastros.colaboradores.index') }}" class="btn btn-sm btn-outline-secondary w-100">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela DataTable -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tabelaColaboradores" class="table table-hover table-striped table-bordered w-100 mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th style="width: 50px;">Foto</th>
                            <th>Nome Completo</th>
                            <th style="width: 180px;">Cargo</th>
                            <th style="width: 130px;">Setor</th>
                            <th style="width: 120px;">Grupo</th>
                            <th style="width: 150px;">Gestor</th>
                            <th style="width: 140px;">Área</th>
                            <th style="width: 130px;">Nível (card)</th>
                            <th style="width: 90px;">Cor</th>
                            <th style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colaboradores as $colab)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $colab->foto_url }}" alt="{{ $colab->nome_completo }}" 
                                         class="rounded-circle border" style="width: 36px; height: 36px; object-fit: cover;">
                                </td>
                                <td class="font-weight-bold">{{ $colab->nome_completo }}</td>
                                <td>{{ $colab->cargo }}</td>
                                <td>{{ $colab->setor ?? '-' }}</td>
                                <td>
                                    @if($colab->grupo)
                                        <small class="badge badge-info">{{ $colab->grupo->nome }} ({{ $colab->grupo->numero }})</small>
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
                                    <small>{{ \App\Models\Colaborador::AREAS[$colab->area] ?? '-' }}</small>
                                </td>
                                <td>
                                    <small>{{ $colab->nivel_card_texto }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $colab->cor_classe }} text-white">{{ $colab->cor_label }}</span>
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
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    Nenhum colaborador encontrado.
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
        // Inicializar DataTable
        var table = $('#tabelaColaboradores').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                 "<'row'<'col-sm-12'B>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: { columns: ':not(:last-child)' },
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print mr-1"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-copy mr-1"></i> Copiar',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                }
            ],
            columnDefs: [
                { orderable: false, targets: [0, 9] }, // Foto e Ações não ordenáveis
                { searchable: false, targets: [0, 9] }
            ],
            pageLength: -1,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            order: [[1, 'asc']], // Ordenar por Nome Completo
        });

        // Filtros personalizados - integrar com DataTable
        $('#filtroBusca').on('keyup', function() {
            table.column(1).search(this.value).draw(); // Buscar na coluna Nome
        });

        $('#filtroSetor').on('change', function() {
            table.column(3).search(this.value).draw(); // Filtrar Setor
        });

        $('#filtroGrupo').on('change', function() {
            table.column(4).search(this.value).draw(); // Filtrar Grupo
        });

        // Submit do formulário de filtros (para manter URL com parâmetros)
        $('#filtrosForm').on('submit', function(e) {
            e.preventDefault();
            var params = $(this).serialize();
            window.location.href = '{{ route("cadastros.colaboradores.index") }}?' + params;
        });

        // Ajustar responsividade ao redimensionar
        $(window).on('resize', function() {
            table.columns.adjust().responsive.recalc();
        });
    });
</script>
@endsection