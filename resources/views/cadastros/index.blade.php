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
        <div class="d-flex align-items-center">
            <a href="{{ route('cadastros.create') }}" class="btn btn-lte-purple mr-2">
                <i class="fas fa-plus mr-1"></i> Novo Cadastro
            </a>
            <a href="{{ route('organograma.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-sitemap mr-1"></i> Organograma
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-filter mr-1"></i> Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('cadastros.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small">Buscar</label>
                    <input type="text" name="busca" class="form-control form-control-sm"
                           value="{{ request('busca') }}" placeholder="Nome do cadastro...">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tipo</label>
                    <select name="tipo" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Gestor</label>
                    <select name="gestor" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($gestores as $gestor)
                            <option value="{{ $gestor->id }}" {{ (string) request('gestor') === (string) $gestor->id ? 'selected' : '' }}>
                                {{ $gestor->nome_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Sistema</label>
                    <select name="sistema" class="form-control form-control-sm">
                        <option value="">Todos</option>
                        @foreach($sistemas as $valor => $rotulo)
                            <option value="{{ $valor }}" {{ request('sistema') === $valor ? 'selected' : '' }}>{{ $rotulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-2">
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
                            <th style="width: 80px;">Tipo</th>
                            <th style="width: 140px;">Gestor</th>
                            <th style="width: 110px;">Sistema</th>
                            <th style="width: 120px;">Contrato</th>
                            <th style="width: 100px;">Data</th>
                            <th style="width: 130px;">Operação</th>
                            <th style="width: 170px;">Operadores</th>
                            <th style="width: 90px;">Nº Poços</th>
                            <th style="width: 110px;">Qtd Operadores</th>
                            <th style="width: 90px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cadastros as $cadastro)
                            <tr class="cadastro-row" style="cursor: pointer;"
                                data-nome="{{ $cadastro->nome }}"
                                data-tipo="{{ $cadastro->tipo }}"
                                data-gestor="{{ $cadastro->gestor?->nome_completo }}"
                                data-sistema="{{ $cadastro->sistema }}"
                                data-contrato="{{ $cadastro->contrato }}"
                                data-data="{{ $cadastro->data_contrato?->format('d/m/Y') }}"
                                data-operacao="{{ $cadastro->operacao }}"
                                data-operadores="{{ json_encode($cadastro->operadores ?? []) }}"
                                data-pocos="{{ $cadastro->numero_pocos }}"
                                data-qtd="{{ $cadastro->quantidade_operadores }}"
                                data-informacoes="{{ $cadastro->informacoes }}"
                                onclick="openCadastroDetalhes(this)">
                                <td class="font-weight-bold">{{ $cadastro->nome }}</td>
                                <td>
                                    @if($cadastro->tipo === 'ETA')
                                        <span class="badge badge-primary">ETA</span>
                                    @else
                                        <span class="badge badge-warning">EPAR</span>
                                    @endif
                                </td>
                                <td>{{ $cadastro->gestor?->nome_completo ?? '' }}</td>
                                <td>{{ $cadastro->sistema ?? '' }}</td>
                                <td>{{ $cadastro->contrato ?? '' }}</td>
                                <td>{{ $cadastro->data_contrato?->format('d/m/Y') ?? '' }}</td>
                                <td>{{ $cadastro->operacao ?? '' }}</td>
                                <td>
                                    @if(!empty($cadastro->operadores))
                                        @foreach($cadastro->operadores as $operador)
                                            <div class="small">{{ $operador }}</div>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $cadastro->numero_pocos ?? '' }}</td>
                                <td>{{ $cadastro->quantidade_operadores ?? '' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-info" title="Visualizar"
                                                onclick="event.stopPropagation(); openCadastroDetalhes(this.closest('tr'))">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('cadastros.edit', $cadastro) }}"
                                           class="btn btn-outline-primary" title="Editar"
                                           onclick="event.stopPropagation()">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-5">
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

<!-- Modal Detalhes do Cadastro -->
<div id="cadastroDetalhesModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-200"
     onclick="if (event.target === this) closeCadastroDetalhes()">
    <div class="bg-lte-card-bg dark:bg-lte-card-bg-dark rounded-lg shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="bg-lte-purple text-white p-3 flex justify-between items-start">
            <div>
                <span id="detTipo" class="bg-black/20 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">-</span>
                <h3 id="detNome" class="font-bold text-base leading-tight">-</h3>
            </div>
            <button type="button" onclick="closeCadastroDetalhes()" class="text-white/80 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-4 space-y-2 text-xs max-h-[75vh] overflow-y-auto">
            <div class="grid grid-cols-2 gap-2 bg-lte-gray-bg dark:bg-lte-gray-bg-dark p-2 rounded border border-lte-border dark:border-lte-border-dark">
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Gestor:</span>
                    <span id="detGestor" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Sistema:</span>
                    <span id="detSistema" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Contrato:</span>
                    <span id="detContrato" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Data:</span>
                    <span id="detData" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Nº Poços:</span>
                    <span id="detPocos" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
                <div>
                    <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Qtd Operadores:</span>
                    <span id="detQtd" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>
            </div>

            <div>
                <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Operação:</span>
                <span id="detOperacao" class="text-lte-text dark:text-lte-text-dark">-</span>
            </div>

            <div>
                <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Operadores:</span>
                <div id="detOperadores" class="text-lte-text dark:text-lte-text-dark">-</div>
            </div>

            <div>
                <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Informações da gestão / contratos:</span>
                <p id="detInformacoes" class="mt-1 bg-lte-gray-bg dark:bg-lte-gray-bg-dark p-2 rounded border border-lte-border dark:border-lte-border-dark text-lte-text dark:text-lte-text-dark leading-relaxed whitespace-pre-line">-</p>
            </div>
        </div>

        <div class="bg-lte-gray-bg dark:bg-lte-gray-bg-dark px-4 py-2 border-t border-lte-border dark:border-lte-border-dark flex justify-end">
            <button type="button" onclick="closeCadastroDetalhes()" class="px-3 py-1 bg-slate-700 dark:bg-slate-600 text-white font-semibold rounded hover:bg-slate-600 dark:hover:bg-slate-500">
                Fechar
            </button>
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
    function openCadastroDetalhes(el) {
        const d = el.dataset;
        const modal = document.getElementById('cadastroDetalhesModal');

        document.getElementById('detNome').textContent = d.nome || '-';
        document.getElementById('detTipo').textContent = d.tipo || '-';
        document.getElementById('detGestor').textContent = d.gestor || '-';
        document.getElementById('detSistema').textContent = d.sistema || '-';
        document.getElementById('detContrato').textContent = d.contrato || '-';
        document.getElementById('detData').textContent = d.data || '-';
        document.getElementById('detOperacao').textContent = d.operacao || '-';
        document.getElementById('detPocos').textContent = d.pocos || '-';
        document.getElementById('detQtd').textContent = d.qtd || '-';
        document.getElementById('detInformacoes').textContent = d.informacoes || '-';

        let operadores = [];
        try {
            operadores = JSON.parse(d.operadores || '[]');
        } catch (e) {
            operadores = [];
        }

        const lista = document.getElementById('detOperadores');
        lista.innerHTML = '';
        if (operadores.length) {
            operadores.forEach(function (nome) {
                const linha = document.createElement('div');
                linha.textContent = nome;
                lista.appendChild(linha);
            });
        } else {
            lista.textContent = '-';
        }

        modal.classList.remove('hidden');
        setTimeout(function () {
            modal.classList.remove('opacity-0');
        }, 10);
    }

    function closeCadastroDetalhes() {
        const modal = document.getElementById('cadastroDetalhesModal');
        if (!modal) return;
        modal.classList.add('opacity-0');
        setTimeout(function () {
            modal.classList.add('hidden');
        }, 200);
    }

    $(function () {
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
                    className: 'btn btn-success btn-sm',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: { columns: ':not(:last-child)' }
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
            pageLength: -1,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [10] },
                { searchable: false, targets: [10] }
            ]
        });
    });
</script>
@endsection
