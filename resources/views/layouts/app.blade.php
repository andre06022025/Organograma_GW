<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organograma Corporativo - General Water')</title>
    
    <!-- Bootstrap 4 CSS (telas de cadastro) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Tailwind CSS compilado via Vite + JS do app -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script>
        // Aplicar tema salvo ou preferência do sistema antes da renderização
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; }
        .dark ::-webkit-scrollbar-track { background: #334155; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        .dark ::-webkit-scrollbar-thumb { background: #64748b; }
        
        .node-card {
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.2s ease;
            cursor: pointer;
        }
        .node-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .dark .node-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* Cards no estilo planilha (sem elevação) */
        .node-cell {
            transition: filter 0.15s ease;
        }
        .node-cell:hover {
            transform: none;
            box-shadow: none;
            filter: brightness(1.1);
        }

        /* Drag and drop dos cards */
        body.edit-mode .node-cell[data-draggable="true"] {
            cursor: grab;
            outline: 2px solid rgba(255, 255, 255, 0.45);
            outline-offset: -2px;
        }
        .node-cell.dragging {
            opacity: 0.45;
            cursor: grabbing;
            transform: none !important;
        }
        .node-cell.drag-over {
            outline: 2px dashed #ffffff;
            outline-offset: -3px;
        }

        /* Modo edição */
        body.edit-mode .node-cell.card-selected {
            outline: 3px solid #f59e0b;
            outline-offset: -3px;
        }
        #editModeToggle.is-active {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
        #editModeToggle.is-active i,
        #editModeToggle.is-active span {
            color: #ffffff !important;
        }
        
        #viewportCanvas {
            transform-origin: top center;
            transition: transform 0.1s ease-out;
        }
        
        .modal-enter {
            animation: modalIn 0.2s ease-out;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        /* Transições suaves para mudança de tema */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        
        /* Estados minimizados */
        body.ui-minimized #topHeader {
            height: 0 !important;
            padding: 0 !important;
            border: none !important;
            overflow: hidden !important;
        }
        body.ui-minimized #mainSidebar {
            width: 0 !important;
            padding: 0 !important;
            border: none !important;
            overflow: hidden !important;
        }
        body.ui-minimized #canvasContainer {
            padding: 0 !important;
        }
        body.ui-minimized #minimizeUIIcon {
            transform: rotate(180deg);
        }

        /* Botão flutuante para restaurar as barras quando a UI está minimizada */
        #restoreUIBtn {
            display: none;
        }
        body.ui-minimized #restoreUIBtn {
            display: inline-flex;
        }
        
        /* Transições suaves para minimizar */
        #topHeader, #mainSidebar, #canvasContainer {
            transition: all 0.3s ease;
        }
        
        /* Ajustes para dark mode nas modais Bootstrap */
        .dark .modal-content {
            background-color: #334155;
            border-color: #475569;
        }
        .dark .modal-header,
        .dark .modal-footer {
            border-color: #475569;
        }
        .dark .form-control {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }
        .dark .form-control:focus {
            background-color: #1e293b;
            border-color: #6f42c1;
            color: #f1f5f9;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        .dark .form-select {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }
        .dark .custom-control-label::before {
            background-color: #1e293b;
            border-color: #475569;
        }
        .dark .custom-control-input:checked~.custom-control-label::before {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }
        .dark .card {
            background-color: #334155;
            border-color: #475569;
        }
        .dark .table {
            color: #f1f5f9;
        }
        .dark .table th {
            background-color: #1e293b;
            border-color: #475569;
        }
        .dark .table td {
            border-color: #475569;
        }
        .dark .dropdown-menu {
            background-color: #334155;
            border-color: #475569;
        }
        .dark .dropdown-item {
            color: #f1f5f9;
        }
        .dark .dropdown-item:hover {
            background-color: #475569;
        }
        .dark .bg-white { background-color: #334155 !important; }
        .dark .bg-gray-50 { background-color: #1e293b !important; }
        .dark .bg-gray-100 { background-color: #334155 !important; }
        .dark .bg-slate-50 { background-color: #1e293b !important; }
        .dark .bg-slate-100 { background-color: #334155 !important; }
        .dark .bg-slate-200 { background-color: #475569 !important; }
        .dark .bg-slate-800 { background-color: #1e293b !important; }
        .dark .bg-slate-900 { background-color: #0f172a !important; }
        .dark .text-slate-700 { color: #f1f5f9 !important; }
        .dark .text-slate-600 { color: #cbd5e1 !important; }
        .dark .text-slate-500 { color: #94a3b8 !important; }
        .dark .text-slate-400 { color: #94a3b8 !important; }
        .dark .text-slate-300 { color: #cbd5e1 !important; }
        .dark .text-slate-200 { color: #e2e8f0 !important; }
        .dark .border-slate-200 { border-color: #475569 !important; }
        .dark .border-slate-300 { border-color: #475569 !important; }
        .dark .bg-slate-800 { background-color: #1e293b !important; }
    </style>
    
    @yield('css')
    @yield('styles')
</head>
<body class="bg-lte-gray-bg dark:bg-lte-gray-bg-dark font-sans text-lte-text dark:text-lte-text-dark text-xs antialiased h-screen overflow-hidden flex flex-col">

    <!-- Topbar -->
    <header id="topHeader" class="bg-lte-card-bg dark:bg-lte-card-bg-dark border-b border-lte-border dark:border-lte-border-dark px-4 py-2 flex items-center justify-between shadow-sm z-30 shrink-0 transition-all duration-300">
        <div class="flex items-center gap-3">
            <button id="sidebarToggle" onclick="toggleSidebar()" class="text-lte-text-muted dark:text-lte-text-muted-dark hover:text-lte-text dark:hover:text-lte-text p-1 lg:hidden">
                <i class="fa-solid fa-bars text-base"></i>
            </button>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-sitemap text-lte-orange text-lg"></i>
                <h1 class="font-bold text-lte-text dark:text-lte-text-dark text-base">Organograma Geral <span class="text-xs font-normal text-lte-text-muted dark:text-lte-text-muted-dark">(General Water)</span></h1>
            </div>
        </div>

        <!-- Controles Globais de Zoom & Filtros -->
        <div class="flex items-center gap-2 flex-wrap">
            <!-- Pesquisa -->
            <div class="relative w-48 md:w-64 lg:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-lte-text-muted dark:text-lte-text-muted-dark"></i>
                <input type="text" id="searchInput" onkeyup="filterNodes()" placeholder="Buscar colaborador ou cargo..." class="w-full pl-8 pr-3 py-1 text-xs border border-lte-border dark:border-lte-border-dark rounded bg-lte-card-bg dark:bg-lte-card-bg-dark text-lte-text dark:text-lte-text-dark focus:outline-none focus:ring-1 focus:ring-lte-purple">
            </div>

            <!-- Filtro de Área -->
            <select id="sectorFilter" onchange="filterNodes()" class="border border-lte-border dark:border-lte-border-dark rounded px-2 py-1 text-xs bg-lte-card-bg dark:bg-lte-card-bg-dark text-lte-text dark:text-lte-text-dark hidden sm:block">
                <option value="all">Todas as Áreas</option>
                <option value="producao">Áreas de Produção</option>
                <option value="apoio">Áreas de Apoio</option>
            </select>

            <!-- Controles de Zoom -->
            <div class="flex items-center bg-lte-gray-bg dark:bg-lte-gray-bg-dark rounded border border-lte-border dark:border-lte-border-dark p-0.5">
                <button onclick="changeZoom(-0.1)" title="Reduzir Zoom" class="px-2 py-0.5 hover:bg-lte-card-bg dark:hover:bg-lte-card-bg-dark rounded text-lte-text dark:text-lte-text-dark font-bold">-</button>
                <span id="zoomLevelText" class="px-2 text-[11px] font-semibold text-lte-text-muted dark:text-lte-text-muted-dark">100%</span>
                <button onclick="changeZoom(0.1)" title="Aumentar Zoom" class="px-2 py-0.5 hover:bg-lte-card-bg dark:hover:bg-lte-card-bg-dark rounded text-lte-text dark:text-lte-text-dark font-bold">+</button>
                <button onclick="resetZoom()" title="Ajustar Tela" class="px-2 py-0.5 hover:bg-lte-card-bg dark:hover:bg-lte-card-bg-dark rounded text-lte-text-muted dark:text-lte-text-muted-dark text-[10px] border-l border-lte-border dark:border-lte-border-dark ml-0.5">Reset</button>
                <button onclick="fitToScreen()" title="Ajustar Tudo" class="px-2 py-0.5 hover:bg-lte-card-bg dark:hover:bg-lte-card-bg-dark rounded text-lte-text-muted dark:text-lte-text-muted-dark text-[10px] border-l border-lte-border dark:border-lte-border-dark ml-0.5">
                    <i class="fas fa-compress-alt"></i>
                </button>
            </div>

            <!-- Modo edição (somente organograma) -->
            @if(request()->routeIs('organograma.index'))
            <button id="editModeToggle" onclick="toggleEditMode()" title="Modo edição: arrastar, renomear e ajustar largura dos cards"
                    class="p-2 rounded-lg bg-lte-gray-bg dark:bg-lte-gray-bg-dark border border-lte-border dark:border-lte-border-dark hover:bg-lte-border dark:hover:bg-lte-border-dark transition-colors flex items-center gap-1"
                    aria-label="Modo edição">
                <i class="fas fa-pen text-lte-purple text-lg"></i>
                <span class="hidden sm:inline text-xs font-semibold text-lte-text dark:text-lte-text-dark">Editar</span>
            </button>
            @endif

            <!-- Theme Toggle -->
            <button id="themeToggle" onclick="toggleTheme()" title="Alternar tema" class="p-2 rounded-lg bg-lte-gray-bg dark:bg-lte-gray-bg-dark border border-lte-border dark:border-lte-border-dark hover:bg-lte-border dark:hover:bg-lte-border-dark transition-colors" aria-label="Alternar tema claro/escuro">
                <i id="themeIcon" class="fas fa-sun text-lte-orange text-lg"></i>
            </button>

            <!-- Minimize UI Toggle -->
            <button id="minimizeUIToggle" onclick="toggleMinimizeUI()" title="Ocultar/Mostrar barras" class="p-2 rounded-lg bg-lte-gray-bg dark:bg-lte-gray-bg-dark border border-lte-border dark:border-lte-border-dark hover:bg-lte-border dark:hover:bg-lte-border-dark transition-colors" aria-label="Ocultar/Mostrar barras">
                <i id="minimizeUIIcon" class="fas fa-compress-arrows-alt text-lte-purple text-lg"></i>
            </button>
        </div>
    </header>

    <!-- Botão flutuante: aparece apenas quando topbar/sidebar estão ocultas -->
    <button id="restoreUIBtn" onclick="toggleMinimizeUI()"
            title="Mostrar barras (topbar e menu)"
            aria-label="Mostrar barras"
            class="fixed bottom-3 right-3 z-40 items-center gap-1.5 px-3 py-1.5 rounded-lg bg-lte-purple text-white text-xs font-semibold shadow-lg hover:bg-lte-purple-dark transition-colors">
        <i class="fa-solid fa-expand-arrows-alt"></i>
        <span class="hidden sm:inline">Mostrar barras</span>
    </button>

    <div class="flex flex-1 overflow-hidden relative">

        <!-- Sidebar Retrátil -->
        <aside id="mainSidebar" class="w-56 bg-slate-800 dark:bg-slate-900 text-slate-200 shrink-0 transition-all duration-300 flex flex-col z-20 lg:block">
            <div class="p-3 bg-slate-900 dark:bg-slate-950 flex items-center gap-2 border-b border-slate-700 dark:border-slate-800">
                <div class="w-8 h-8 rounded-full border border-lte-orange bg-gradient-to-br from-lte-purple to-lte-cyan flex items-center justify-center">
                    <i class="fas fa-sitemap text-white text-sm"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="font-bold text-white text-xs truncate">Organograma GW</p>
                    <span class="text-[10px] text-emerald-400 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Acesso Livre
                    </span>
                </div>
            </div>

            <nav class="p-2 space-y-1 text-xs flex-1">
                <a href="{{ route('organograma.index') }}" class="flex items-center gap-2 px-2.5 py-2 bg-lte-orange text-white font-semibold rounded">
                    <i class="fa-solid fa-sitemap w-4"></i> Organograma Completo
                </a>
                <a href="#" class="flex items-center gap-2 px-2.5 py-2 text-slate-300 hover:bg-slate-700 dark:hover:bg-slate-800 rounded transition" onclick="filterNodes('producao')">
                    <i class="fa-solid fa-industry w-4"></i> Áreas de Produção
                </a>
                <a href="#" class="flex items-center gap-2 px-2.5 py-2 text-slate-300 hover:bg-slate-700 dark:hover:bg-slate-800 rounded transition" onclick="filterNodes('apoio')">
                    <i class="fa-solid fa-headset w-4"></i> Áreas de Apoio
                </a>
                <li class="nav-header text-[10px] text-uppercase tracking-wide text-slate-500 mt-2 mb-1 px-2">CADASTROS</li>
                <a href="{{ route('cadastros.colaboradores.index') }}" class="flex items-center gap-2 px-2.5 py-2 text-slate-300 hover:bg-slate-700 dark:hover:bg-slate-800 rounded transition">
                    <i class="fa-solid fa-users-cog w-4"></i> Colaboradores
                </a>
                <a href="{{ route('cadastros.index') }}" class="flex items-center gap-2 px-2.5 py-2 text-slate-300 hover:bg-slate-700 dark:hover:bg-slate-800 rounded transition">
                    <i class="fa-solid fa-clipboard-list w-4"></i> Cadastros
                </a>
            </nav>

            <div class="p-3 border-t border-slate-700 dark:border-slate-800 text-[10px] text-slate-400">
                General Water - CCO v1.0
            </div>
        </aside>

        <!-- Canvas Principal de Navegação (Zoom & Pan) -->
        <main class="flex-1 bg-lte-gray-bg dark:bg-lte-gray-bg-dark overflow-auto p-4 relative" id="canvasContainer">

            {{-- Conteúdo das telas de cadastro (Bootstrap) --}}
            @yield('content')

            <div id="viewportCanvas" class="w-full min-w-0 mx-auto pb-12 flex flex-col items-stretch gap-4">

                @yield('organograma-content')

            </div>

        </main>
    </div>

    <!-- Painel de edição dos cards (modo edição) -->
    <div id="cardEditPanel"
         class="hidden bg-lte-card-bg dark:bg-lte-card-bg-dark border border-lte-border dark:border-lte-border-dark rounded-lg shadow-2xl text-xs"
         style="position: fixed; top: 112px; right: 12px; width: 320px; max-height: calc(100vh - 128px); overflow-y: auto; z-index: 40;">
        <div class="bg-lte-purple text-white px-3 py-2 rounded-t-lg flex items-center justify-between">
            <span class="font-bold uppercase tracking-wide text-[11px]">Editar card</span>
            <button type="button" onclick="voltarEdicaoCard()" class="text-white/80 hover:text-white" title="Voltar sem salvar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="editCardHint" class="p-4 text-center text-lte-text-muted dark:text-lte-text-muted-dark">
            Clique em um card do organograma para editar.
        </div>

        <div id="editCardForm" class="hidden p-3 space-y-3">
            <div>
                <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Nome / texto</label>
                <input type="text" id="editCardName" maxlength="255" oninput="previewNomeCard()"
                       class="w-full border border-lte-border dark:border-lte-border-dark rounded px-2 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
            </div>

            <div id="editCardPosicaoFields" class="space-y-3">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">
                            Coluna <span id="editCardColunaInfo" class="font-normal opacity-80">1/9</span>
                        </label>
                        <div class="flex items-stretch gap-1">
                            <button type="button" onclick="ajustarNumeroCard('editCardColuna', -1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Mover para a esquerda">←</button>
                            <input type="number" id="editCardColuna" min="1" max="9" oninput="previewPosicaoCard()"
                                   class="flex-1 min-w-0 text-center border border-lte-border dark:border-lte-border-dark rounded px-1 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
                            <button type="button" onclick="ajustarNumeroCard('editCardColuna', 1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Mover para a direita">→</button>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">
                            Linha <span id="editCardLinhaInfo" class="font-normal opacity-80">1/20</span>
                        </label>
                        <div class="flex items-stretch gap-1">
                            <button type="button" onclick="ajustarNumeroCard('editCardLinha', -1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Mover para cima">↑</button>
                            <input type="number" id="editCardLinha" min="1" max="20" oninput="previewPosicaoCard()"
                                   class="flex-1 min-w-0 text-center border border-lte-border dark:border-lte-border-dark rounded px-1 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
                            <button type="button" onclick="ajustarNumeroCard('editCardLinha', 1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Mover para baixo">↓</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Largura (colunas)</label>
                        <div class="flex items-stretch gap-1">
                            <button type="button" onclick="ajustarNumeroCard('editCardColspan', -1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Diminuir largura">−</button>
                            <input type="number" id="editCardColspan" min="1" max="9" oninput="previewPosicaoCard()"
                                   class="flex-1 min-w-0 text-center border border-lte-border dark:border-lte-border-dark rounded px-1 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
                            <button type="button" onclick="ajustarNumeroCard('editCardColspan', 1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Aumentar largura">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Altura (linhas)</label>
                        <div class="flex items-stretch gap-1">
                            <button type="button" onclick="ajustarNumeroCard('editCardRowspan', -1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Diminuir altura">−</button>
                            <input type="number" id="editCardRowspan" min="1" max="6" oninput="previewPosicaoCard()"
                                   class="flex-1 min-w-0 text-center border border-lte-border dark:border-lte-border-dark rounded px-1 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
                            <button type="button" onclick="ajustarNumeroCard('editCardRowspan', 1)"
                                    class="w-7 rounded bg-slate-200 dark:bg-slate-700 font-bold leading-none"
                                    title="Aumentar altura">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                Aumentar largura/altura faz o card ocupar as colunas/linhas vizinhas.
            </p>

            <p class="text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                Dica: arraste o próprio card na grade para reposicionar.
            </p>

            <div id="editCardAlignFields" class="space-y-2">
                <div>
                    <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Alinhamento horizontal</label>
                    <div class="grid grid-cols-3 gap-1">
                        <button type="button" data-align="left" onclick="definirAlinhamento('left')"
                                title="Alinhar à esquerda"
                                class="align-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-arrow-left"></i><span class="text-[10px]">Esquerda</span>
                        </button>
                        <button type="button" data-align="center" onclick="definirAlinhamento('center')"
                                title="Centralizar"
                                class="align-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-align-center"></i><span class="text-[10px]">Centro</span>
                        </button>
                        <button type="button" data-align="right" onclick="definirAlinhamento('right')"
                                title="Alinhar à direita"
                                class="align-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-arrow-right"></i><span class="text-[10px]">Direita</span>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Alinhamento vertical</label>
                    <div class="grid grid-cols-3 gap-1">
                        <button type="button" data-valign="top" onclick="definirAlinhamentoVertical('top')"
                                title="Alinhar ao topo"
                                class="valign-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-arrow-up"></i><span class="text-[10px]">Topo</span>
                        </button>
                        <button type="button" data-valign="center" onclick="definirAlinhamentoVertical('center')"
                                title="Centralizar verticalmente"
                                class="valign-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-arrows-alt-v"></i><span class="text-[10px]">Meio</span>
                        </button>
                        <button type="button" data-valign="bottom" onclick="definirAlinhamentoVertical('bottom')"
                                title="Alinhar à base"
                                class="valign-btn flex flex-col items-center justify-center gap-0.5 py-1 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark">
                            <i class="fas fa-arrow-down"></i><span class="text-[10px]">Base</span>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="centralizarCard()"
                        class="w-full flex items-center justify-center gap-1 py-1.5 rounded bg-slate-200 dark:bg-slate-700 text-lte-text dark:text-lte-text-dark font-semibold"
                        title="Centralizar horizontal e verticalmente">
                    <i class="fas fa-crosshairs"></i> Centralizar tudo
                </button>
            </div>

            <p id="editCardFullWidthHint" class="hidden text-[10px] text-amber-700 dark:text-amber-400">
                Card de largura total: apenas o texto pode ser alterado.
            </p>

            <p class="text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                Salvamento automático ativo. <strong>Salvar</strong> aplica agora; <strong>Voltar</strong> fecha e descarta alterações ainda não salvas.
            </p>

            <input type="hidden" id="editCardId">
            <input type="hidden" id="editCardBar" value="0">

            <div class="flex justify-end gap-2 pt-2 pb-1 sticky bottom-0 z-10 bg-lte-card-bg dark:bg-lte-card-bg-dark border-t border-lte-border dark:border-lte-border-dark -mx-3 px-3">
                <button type="button" onclick="voltarEdicaoCard()"
                        class="px-3 py-1.5 rounded bg-slate-500 hover:bg-slate-600 text-white font-semibold">Voltar</button>
                <button type="button" onclick="salvarCardEdit()"
                        class="px-4 py-1.5 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">Salvar</button>
            </div>
        </div>
    </div>

    <!-- Modal Detalhes do Colaborador -->
    <div id="cardModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-200">
        <div class="bg-lte-card-bg dark:bg-lte-card-bg-dark rounded-lg shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-200 modal-enter" id="modalContainer">
            
            <!-- Header Modal -->
            <div id="modalHeaderBg" class="bg-lte-orange text-white p-3 flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <img id="modalAvatar" src="" class="w-12 h-12 rounded-full border-2 border-white object-cover shadow">
                    <div>
                        <span id="modalRoleBadge" class="bg-black/20 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">Cargo</span>
                        <h3 id="modalName" class="font-bold text-base leading-tight">Nome Profissional</h3>
                        <p id="modalRole" class="text-xs opacity-90">Título do Cargo</p>
                    </div>
                </div>
                <button onclick="closeCardModal()" class="text-white/80 hover:text-white text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-4 space-y-3 max-h-[75vh] overflow-y-auto text-xs">

                <!-- Informações -->
                <div class="grid grid-cols-2 gap-2 bg-lte-gray-bg dark:bg-lte-gray-bg-dark p-2 rounded border border-lte-border dark:border-lte-border-dark">
                    <div>
                        <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Nível:</span>
                        <span id="modalNivel" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                    </div>
                    <div>
                        <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Grupo:</span>
                        <span id="modalGrupo" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                    </div>
                    <div>
                        <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Setor / Área:</span>
                        <span id="modalLocation" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                    </div>
                    <div>
                        <span class="text-lte-text-muted dark:text-lte-text-muted-dark block font-semibold">Gestor direto:</span>
                        <span id="modalGestor" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                    </div>
                </div>

                <div class="text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                    <span class="font-semibold">Data de contratação:</span>
                    <span id="modalDataContratacao" class="font-bold text-lte-text dark:text-lte-text-dark">-</span>
                </div>

                <!-- CONTATO -->
                <div class="flex items-center gap-1.5 pt-2 border-t border-lte-border dark:border-lte-border-dark text-[11px] text-lte-text-muted dark:text-lte-text-muted-dark">
                    <i class="fa-solid fa-envelope text-lte-orange"></i>
                    <span id="modalEmail">-</span>
                </div>

                <!-- CADASTROS SOB GESTÃO -->
                <div id="modalCadastrosSection" class="hidden pt-2 border-t border-lte-border dark:border-lte-border-dark">
                    <h4 class="font-bold text-lte-text-muted dark:text-lte-text-muted-dark uppercase tracking-wide text-[10px] mb-1">
                        Cadastros sob gestão
                    </h4>
                    <div id="modalCadastrosList" class="space-y-1.5 max-h-48 overflow-y-auto text-[11px]"></div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="bg-lte-gray-bg dark:bg-lte-gray-bg-dark px-4 py-2 border-t border-lte-border dark:border-lte-border-dark flex justify-between items-center text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                <span>ID do colaborador: <strong id="modalUserId">#-</strong></span>
                <button onclick="closeCardModal()" class="px-3 py-1 bg-slate-700 dark:bg-slate-600 text-white font-semibold rounded hover:bg-slate-600 dark:hover:bg-slate-500">Fechar</button>
            </div>

        </div>
    </div>

    <!-- Modal Foto do Colaborador -->
    <div id="photoModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-200">
        <div class="bg-lte-card-bg dark:bg-lte-card-bg-dark rounded-lg shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-200 modal-enter">

            <div class="bg-lte-purple text-white p-3 flex justify-between items-start">
                <div>
                    <span class="bg-black/20 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">Foto</span>
                    <h3 id="photoModalName" class="font-bold text-base leading-tight">Colaborador</h3>
                </div>
                <button type="button" onclick="closePhotoModal()" class="text-white/80 hover:text-white text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="photoForm" method="POST" enctype="multipart/form-data" action="">
                @csrf
                <div class="p-4 space-y-3 text-xs">
                    <div class="flex justify-center">
                        <div class="w-28 h-28 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-700 flex items-center justify-center border-4 border-white dark:border-slate-600 shadow">
                            <img id="photoPreview" src="" alt="Prévia da foto" class="w-full h-full object-cover hidden">
                            <svg id="photoPlaceholder" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-slate-400" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold block mb-1" for="photoInput">Selecionar nova foto</label>
                        <input type="file" name="foto" id="photoInput" accept="image/*" class="form-control-file" onchange="previewPhoto(this)" required>
                        <small class="text-muted">JPG, PNG ou WebP (máx. 2MB)</small>
                    </div>
                </div>

                <div class="bg-lte-gray-bg dark:bg-lte-gray-bg-dark px-4 py-2 border-t border-lte-border dark:border-lte-border-dark flex justify-end gap-2">
                    <button type="button" onclick="closePhotoModal()" class="px-3 py-1 bg-slate-500 dark:bg-slate-600 text-white font-semibold rounded hover:bg-slate-600 dark:hover:bg-slate-500">Cancelar</button>
                    <button type="submit" class="px-3 py-1 bg-lte-purple text-white font-semibold rounded hover:bg-lte-purple-dark">
                        <i class="fa-solid fa-upload mr-1"></i> Salvar foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ==========================================
        // TEMA DARK/LIGHT
        // ==========================================
        function initTheme() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);
            
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.getElementById('themeIcon').classList.replace('fa-sun', 'fa-moon');
            }
        }
        
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');
            const isDark = html.classList.toggle('dark');
            
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            if (isDark) {
                icon.classList.replace('fa-sun', 'fa-moon');
            } else {
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        }
        
        // ==========================================
        // ESTADO GLOBAL DA APLICAÇÃO
        // ==========================================
        let currentZoom = 1.0;
        const ZOOM_MIN = 0.5;
        const ZOOM_MAX = 1.5;
        const ZOOM_STEP = 0.1;
        
        let filteredNodes = new Set();
        
        // ==========================================
        // ZOOM
        // ==========================================
        function changeZoom(delta) {
            currentZoom = Math.min(Math.max(ZOOM_MIN, currentZoom + delta), ZOOM_MAX);
            updateZoom();
        }
        function resetZoom() {
            currentZoom = 1.0;
            updateZoom();
        }
        function fitToScreen() {
            const viewport = document.getElementById('viewportCanvas');
            const container = document.getElementById('canvasContainer');
            if (!viewport || !container) return;
            
            const containerRect = container.getBoundingClientRect();
            const viewportRect = viewport.getBoundingClientRect();
            
            const scaleX = (containerRect.width * 0.9) / viewportRect.width;
            const scaleY = (containerRect.height * 0.9) / viewportRect.height;
            const scale = Math.min(scaleX, scaleY, ZOOM_MAX);
            
            currentZoom = Math.max(ZOOM_MIN, Math.min(scale, ZOOM_MAX));
            updateZoom();
        }
        function updateZoom() {
            const viewport = document.getElementById('viewportCanvas');
            if (viewport) {
                viewport.style.transform = `scale(${currentZoom})`;
            }
            document.getElementById('zoomLevelText').textContent = `${Math.round(currentZoom * 100)}%`;
        }

        // ==========================================
        // SIDEBAR TOGGLE
        // ==========================================
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            sidebar.classList.toggle('-ml-56');
        }

        // ==========================================
        // FILTROS E BUSCA
        // ==========================================
        function filterNodes(setorForcado = null) {
            const buscaInput = document.getElementById('searchInput');
            const filtroArea = document.getElementById('sectorFilter');
            const busca = (buscaInput?.value || '').toLowerCase().trim();
            const setor = setorForcado || filtroArea?.value || 'all';

            // Sincroniza o select quando o filtro vem da sidebar
            if (setorForcado && filtroArea) {
                filtroArea.value = setorForcado;
            }

            // Mostra/oculta cada card
            document.querySelectorAll('.node-card').forEach(card => {
                const nome = (card.dataset.nome || '').toLowerCase();
                const cargo = (card.dataset.cargo || '').toLowerCase();
                const setorCard = card.dataset.sector || '';
                const fixo = card.dataset.fixo === 'true';

                const matchBusca = !busca || nome.includes(busca) || cargo.includes(busca);
                const matchSetor = setor === 'all' || setorCard === setor;

                card.style.display = (fixo || (matchBusca && matchSetor)) ? '' : 'none';
            });

            // Esconde blocos (grupos/superintendências) que ficaram sem cards
            document.querySelectorAll('.js-filtravel').forEach(box => {
                const cards = box.querySelectorAll('.node-card');
                const algumVisivel = Array.from(cards).some(c => c.style.display !== 'none');
                box.style.display = algumVisivel ? '' : 'none';
            });

            // Esconde colunas inteiras sem nenhum card visível
            document.querySelectorAll('.js-coluna').forEach(col => {
                const algumVisivel = Array.from(col.querySelectorAll('.node-card'))
                    .some(c => c.style.display !== 'none');
                col.style.display = algumVisivel ? '' : 'none';
            });

            // Filtro por área: mostra apenas a área selecionada
            document.querySelectorAll('.js-area').forEach(area => {
                const pertence = setor === 'all' || area.dataset.area === setor;
                area.style.display = pertence ? '' : 'none';
            });

            const divisor = document.querySelector('.js-divisor');
            if (divisor) {
                divisor.style.display = setor === 'all' ? '' : 'none';
            }

            setTimeout(updateZoom, 50);
        }

        // ==========================================
        // MODAL DETALHES
        // ==========================================
        function openCardModal(nodeId) {
            if (document.body.classList.contains('edit-mode')) return;

            if (/^\d+$/.test(String(nodeId))) {
                // IDs numéricos: busca os dados no backend
                fetch(`/organograma/detalhes/${nodeId}`, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.ok ? r.json() : Promise.reject())
                    .then(data => populateModal(data))
                    .catch(() => populateModalFromDOM(nodeId));
            } else {
                // Cards estáticos do organograma: usa os data-attributes do próprio card
                populateModalFromDOM(nodeId);
            }
            
            document.getElementById('cardModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('cardModal').classList.remove('opacity-0');
            }, 10);
        }

        function closeCardModal() {
            const modal = document.getElementById('cardModal');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function populateModal(data) {
            document.getElementById('modalHeaderBg').className = 'text-white p-3 flex justify-between items-start ' + (data.cor_nivel || 'bg-lte-orange');
            document.getElementById('modalAvatar').src = data.foto_url || '';
            document.getElementById('modalAvatar').alt = data.nome;
            document.getElementById('modalRoleBadge').textContent = data.label_nivel || data.nivel || 'Colaborador';
            document.getElementById('modalRoleBadge').className = 'bg-black/20 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase';
            document.getElementById('modalName').textContent = data.nome || '-';
            document.getElementById('modalRole').textContent = data.cargo || '-';

            document.getElementById('modalNivel').textContent = data.label_nivel || data.nivel || '-';
            document.getElementById('modalLocation').textContent = data.setor || data.area_atuacao || '-';
            document.getElementById('modalGrupo').textContent = data.grupo ? data.grupo.nome + ' (' + data.grupo.numero + ')' : '-';
            document.getElementById('modalGestor').textContent = data.gestor ? data.gestor.nome : '-';
            document.getElementById('modalEmail').textContent = data.email || '-';
            document.getElementById('modalDataContratacao').textContent = data.data_contratacao || '-';
            document.getElementById('modalUserId').textContent = '#' + data.id;

            const secaoCadastros = document.getElementById('modalCadastrosSection');
            const listaCadastros = document.getElementById('modalCadastrosList');
            listaCadastros.innerHTML = '';

            if (Array.isArray(data.cadastros) && data.cadastros.length > 0) {
                data.cadastros.forEach(function (c) {
                    const card = document.createElement('div');
                    card.className = 'rounded border border-lte-border dark:border-lte-border-dark bg-lte-gray-bg dark:bg-lte-gray-bg-dark overflow-hidden';

                    const botao = document.createElement('button');
                    botao.type = 'button';
                    botao.className = 'w-full flex items-center justify-between gap-2 p-2 text-left text-lte-text dark:text-lte-text-dark hover:bg-slate-200/60 dark:hover:bg-slate-700/40';
                    botao.setAttribute('aria-expanded', 'false');

                    const titulo = document.createElement('span');
                    titulo.className = 'font-bold';
                    titulo.textContent = c.nome + ' (' + c.tipo + ')';

                    const icone = document.createElement('span');
                    icone.className = 'text-base font-bold leading-none shrink-0';
                    icone.textContent = '+';

                    botao.appendChild(titulo);
                    botao.appendChild(icone);

                    const detalhes = document.createElement('div');
                    detalhes.className = 'hidden px-2 pb-2 space-y-0.5';

                    const linhas = [];
                    if (c.sistema) linhas.push('Sistema: ' + c.sistema);
                    if (c.operacao) linhas.push('Operação: ' + c.operacao);
                    if (c.operadores && c.operadores.length) linhas.push('Operadores: ' + c.operadores.join(', '));
                    if (c.numero_pocos) linhas.push('Nº Poços: ' + c.numero_pocos);
                    if (c.quantidade_operadores) linhas.push('Qtd Operadores: ' + c.quantidade_operadores);

                    linhas.forEach(function (texto) {
                        const p = document.createElement('p');
                        p.className = 'text-lte-text-muted dark:text-lte-text-muted-dark';
                        p.textContent = texto;
                        detalhes.appendChild(p);
                    });

                    if (!linhas.length) {
                        const p = document.createElement('p');
                        p.className = 'text-lte-text-muted dark:text-lte-text-muted-dark';
                        p.textContent = 'Sem informações adicionais.';
                        detalhes.appendChild(p);
                    }

                    botao.addEventListener('click', function () {
                        const aberto = !detalhes.classList.contains('hidden');
                        detalhes.classList.toggle('hidden');
                        icone.textContent = aberto ? '+' : '−';
                        botao.setAttribute('aria-expanded', aberto ? 'false' : 'true');
                    });

                    card.appendChild(botao);
                    card.appendChild(detalhes);
                    listaCadastros.appendChild(card);
                });

                secaoCadastros.classList.remove('hidden');
            } else {
                secaoCadastros.classList.add('hidden');
            }
        }

        function populateModalFromDOM(nodeId) {
            const card = document.querySelector(`.node-card[data-id="${nodeId}"]`);
            if (!card) return;

            const data = {
                id: card.dataset.id,
                nome: card.dataset.nome,
                cargo: card.dataset.cargo,
                setor: card.dataset.setor,
                nivel: card.dataset.nivel,
                label_nivel: card.dataset.labelNivel,
                cor_nivel: card.dataset.corNivel,
                grupo: card.dataset.grupo === 'true'
                    ? { nome: card.dataset.grupoNome, numero: card.dataset.grupoNumero }
                    : null,
                gestor: card.dataset.gestor ? { nome: card.dataset.gestor } : null,
                foto_url: card.querySelector('img')?.src,
            };

            populateModal(data);
        }

        // ==========================================
        // MODAL FOTO
        // ==========================================
        function openPhotoModal(button) {
            if (document.body.classList.contains('edit-mode')) return;

            const id = button.dataset.id;
            const nome = button.dataset.nome || 'Colaborador';
            const foto = button.dataset.foto || '';

            document.getElementById('photoForm').action = '/organograma/' + id + '/foto';
            document.getElementById('photoModalName').textContent = nome;

            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');

            if (foto) {
                preview.src = foto;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            document.getElementById('photoInput').value = '';

            const modal = document.getElementById('photoModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            if (!modal) return;
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    document.getElementById('photoPlaceholder').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ==========================================
        // DRAG AND DROP DOS CARDS
        // ==========================================
        let draggedCard = null;

        function initDragAndDrop() {
            const cards = document.querySelectorAll('.node-cell[data-draggable="true"]');
            if (!cards.length) return;

            cards.forEach(card => {
                card.addEventListener('dragstart', function (e) {
                    draggedCard = this;
                    this.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', this.dataset.id || '');

                    // Abre o editor do card que está sendo movido.
                    if (editMode && selectedCardEl !== this) {
                        selectCardForEdit(this);
                    }

                    // Esconde o painel durante o arraste para liberar a visão da grade.
                    const panel = document.getElementById('cardEditPanel');
                    if (panel) panel.classList.add('hidden');
                });

                card.addEventListener('dragend', function () {
                    this.classList.remove('dragging');
                    document.querySelectorAll('.drag-over').forEach(el => el.classList.remove('drag-over'));
                    esconderPreviewDrop();
                    draggedCard = null;

                    const panel = document.getElementById('cardEditPanel');
                    if (panel && editMode && selectedCardEl) {
                        panel.classList.remove('hidden');
                    }
                });

                card.addEventListener('dragover', function (e) {
                    if (!podeTrocar(draggedCard, this)) return;
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    this.classList.add('drag-over');
                });

                card.addEventListener('dragleave', function () {
                    this.classList.remove('drag-over');
                });

                card.addEventListener('drop', function (e) {
                    if (!podeTrocar(draggedCard, this)) return;

                    e.preventDefault();
                    e.stopPropagation();
                    this.classList.remove('drag-over');
                    trocarCards(draggedCard, this);
                });
            });

            // Permite soltar o card em qualquer coluna/linha da grade, mesmo sobre outro card.
            document.querySelectorAll('.js-area').forEach(area => {
                const grid = area.querySelector('.grid');
                if (!grid) return;
                grid.style.position = 'relative';

                area.addEventListener('dragover', function (e) {
                    if (!draggedCard) return;
                    if (draggedCard.dataset.sector !== area.dataset.area) return;

                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';

                    const pos = calcularPosicaoGrid(area, e, draggedCard);
                    if (pos) mostrarPreviewDrop(grid, pos, draggedCard);
                });

                area.addEventListener('dragleave', function (e) {
                    if (!area.contains(e.relatedTarget)) esconderPreviewDrop();
                });

                area.addEventListener('drop', function (e) {
                    if (!draggedCard) return;
                    if (draggedCard.dataset.sector !== area.dataset.area) return;
                    if (e.defaultPrevented) return;

                    e.preventDefault();
                    esconderPreviewDrop();

                    const pos = calcularPosicaoGrid(area, e, draggedCard);
                    if (!pos) return;

                    const ocupante = encontrarCardNaPosicao(area, pos, draggedCard);
                    if (ocupante) {
                        trocarCards(draggedCard, ocupante);
                    } else {
                        moverCardSalvando(draggedCard, pos);
                    }
                });
            });
        }

        function trocarCards(origem, destino) {
            if (!origem || !destino) return;

            const posOrigem = parsePosicao(origem);
            const posDestino = parsePosicao(destino);

            origem.style.gridColumn = posDestino.coluna + ' / span ' + posDestino.colspan;
            origem.style.gridRow = posDestino.linha + ' / span ' + posDestino.rowspan;
            destino.style.gridColumn = posOrigem.coluna + ' / span ' + posOrigem.colspan;
            destino.style.gridRow = posOrigem.linha + ' / span ' + posOrigem.rowspan;

            salvarPosicoes([parsePosicao(origem), parsePosicao(destino)]);
            sincronizarPainelComCard(origem);
            sincronizarPainelComCard(destino);
        }

        function encontrarCardNaPosicao(area, pos, ignorar) {
            const cards = Array.from(area.querySelectorAll('.node-cell'));

            for (const card of cards) {
                if (card === ignorar) continue;
                if (card === draggedCard) continue;

                const p = parsePosicao(card);
                const colunasSobrepostas = pos.coluna < (p.coluna + p.colspan) &&
                    (pos.coluna + pos.colspan) > p.coluna;
                const linhasSobrepostas = pos.linha < (p.linha + p.rowspan) &&
                    (pos.linha + pos.rowspan) > p.linha;

                if (colunasSobrepostas && linhasSobrepostas) return card;
            }

            return null;
        }

        function moverCardSalvando(card, pos) {
            if (!card) return;

            if (editMode && selectedCardEl !== card) {
                selectCardForEdit(card);
            }

            card.style.gridColumn = pos.coluna + ' / span ' + pos.colspan;
            card.style.gridRow = pos.linha + ' / span ' + pos.rowspan;

            if (selectedCardEl === card) {
                document.getElementById('editCardColuna').value = pos.coluna;
                document.getElementById('editCardLinha').value = pos.linha;
                document.getElementById('editCardColspan').value = pos.colspan;
                document.getElementById('editCardRowspan').value = pos.rowspan;
                atualizarInfoPosicao();
                originalCardStyle = card.getAttribute('style') || '';
            }

            salvarPosicoes([parsePosicao(card)]);
        }

        function calcularPosicaoGrid(area, event, card) {
            const grid = area.querySelector('.grid');
            if (!grid) return null;

            const rect = grid.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            const cs = getComputedStyle(grid);
            const colWidths = cs.gridTemplateColumns.split(' ').map(parseFloat).filter(n => !isNaN(n));
            if (!colWidths.length) return null;

            const colGap = parseFloat(cs.columnGap) || 0;
            const maxCols = colWidths.length;

            let coluna = maxCols;
            let acumulado = 0;
            for (let i = 0; i < colWidths.length; i++) {
                acumulado += colWidths[i];
                if (x <= acumulado) {
                    coluna = i + 1;
                    break;
                }
                acumulado += colGap;
            }

            const colspan = Math.max(1, Math.min(cardSpan(card), maxCols));
            const rowspan = Math.max(1, cardRowSpan(card));
            coluna = Math.max(1, Math.min(coluna, maxCols - colspan + 1));

            const cells = Array.from(grid.querySelectorAll('.node-cell'));
            const rowTops = new Map();
            let ultimoBottom = 0;

            cells.forEach(c => {
                const rowNum = parseInt(getComputedStyle(c).gridRowStart, 10);
                if (isNaN(rowNum)) return;

                const r = c.getBoundingClientRect();
                const top = r.top - rect.top;
                const bottom = r.bottom - rect.top;

                if (!rowTops.has(rowNum) || top < rowTops.get(rowNum)) {
                    rowTops.set(rowNum, top);
                }
                if (bottom > ultimoBottom) ultimoBottom = bottom;
            });

            const rows = Array.from(rowTops.entries()).sort((a, b) => a[1] - b[1]);
            let linha = 1;

            if (rows.length) {
                for (let i = 0; i < rows.length; i++) {
                    const nextTop = i + 1 < rows.length ? rows[i + 1][1] : Infinity;
                    if (y < nextTop) {
                        linha = rows[i][0];
                        break;
                    }
                }
                if (y > ultimoBottom + 1) {
                    linha = rows[rows.length - 1][0] + 1;
                }
            }

            return { coluna: coluna, linha: Math.max(1, linha), colspan: colspan, rowspan: rowspan };
        }

        function mostrarPreviewDrop(grid, pos, card) {
            let preview = document.getElementById('cardDropPreview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'cardDropPreview';
                grid.appendChild(preview);
            }
            if (preview.parentElement !== grid) {
                grid.appendChild(preview);
            }

            const rect = grid.getBoundingClientRect();
            const cs = getComputedStyle(grid);
            const colWidths = cs.gridTemplateColumns.split(' ').map(parseFloat).filter(n => !isNaN(n));
            const colGap = parseFloat(cs.columnGap) || 0;
            const rowGap = parseFloat(cs.rowGap) || 0;

            let left = 0;
            for (let i = 0; i < pos.coluna - 1 && i < colWidths.length; i++) {
                left += (colWidths[i] || 0) + colGap;
            }

            let width = 0;
            for (let i = pos.coluna - 1; i < pos.coluna - 1 + pos.colspan && i < colWidths.length; i++) {
                width += colWidths[i] || 0;
                if (i > pos.coluna - 1) width += colGap;
            }

            const cells = Array.from(grid.querySelectorAll('.node-cell'));
            let top = null;
            let ultimoBottom = 0;

            cells.forEach(c => {
                const r = c.getBoundingClientRect();
                const rowNum = parseInt(getComputedStyle(c).gridRowStart, 10);
                const cardTop = r.top - rect.top;
                const cardBottom = r.bottom - rect.top;

                if (rowNum === pos.linha) {
                    if (top === null || cardTop < top) top = cardTop;
                }
                if (cardBottom > ultimoBottom) ultimoBottom = cardBottom;
            });

            if (top === null) {
                top = ultimoBottom + rowGap;
            }

            const posAtual = parsePosicao(card);
            const alturaAtual = card.getBoundingClientRect().height;
            const alturaLinha = posAtual.rowspan > 1
                ? (alturaAtual - (posAtual.rowspan - 1) * rowGap) / posAtual.rowspan
                : alturaAtual;
            const alturaPreview = Math.max(0, alturaLinha * pos.rowspan + (pos.rowspan - 1) * rowGap);

            preview.style.position = 'absolute';
            preview.style.left = left + 'px';
            preview.style.top = top + 'px';
            preview.style.width = Math.max(0, width) + 'px';
            preview.style.height = alturaPreview + 'px';
            preview.style.border = '2px dashed rgba(255,255,255,0.95)';
            preview.style.background = 'rgba(255,255,255,0.18)';
            preview.style.borderRadius = '4px';
            preview.style.pointerEvents = 'none';
            preview.style.zIndex = '5';
            preview.style.display = 'block';
        }

        function esconderPreviewDrop() {
            const preview = document.getElementById('cardDropPreview');
            if (preview) preview.remove();
        }

        function sincronizarPainelComCard(card) {
            if (!card || selectedCardEl !== card) return;

            const pos = parsePosicao(card);
            document.getElementById('editCardColuna').value = pos.coluna;
            document.getElementById('editCardLinha').value = pos.linha;
            document.getElementById('editCardColspan').value = pos.colspan;
            document.getElementById('editCardRowspan').value = pos.rowspan;
            atualizarInfoPosicao();
            originalCardStyle = card.getAttribute('style') || '';
        }

        function podeTrocar(origem, destino) {
            if (!origem || origem === destino) return false;
            if (!destino.classList.contains('node-cell')) return false;
            if (origem.dataset.sector !== destino.dataset.sector) return false;
            return cardSpan(origem) === cardSpan(destino) && cardRowSpan(origem) === cardRowSpan(destino);
        }

        function cardSpan(el) {
            const cs = getComputedStyle(el);
            const inicio = parseInt(cs.gridColumnStart, 10);
            const fim = String(cs.gridColumnEnd || '');
            if (fim.indexOf('span') !== -1) {
                return parseInt(fim.replace('span', ''), 10) || 1;
            }
            const fimNum = parseInt(fim, 10);
            return (!isNaN(fimNum) && fimNum > inicio) ? fimNum - inicio : 1;
        }

        function cardRowSpan(el) {
            const cs = getComputedStyle(el);
            const inicio = parseInt(cs.gridRowStart, 10);
            const fim = String(cs.gridRowEnd || '');
            if (fim.indexOf('span') !== -1) {
                return parseInt(fim.replace('span', ''), 10) || 1;
            }
            const fimNum = parseInt(fim, 10);
            return (!isNaN(fimNum) && fimNum > inicio) ? fimNum - inicio : 1;
        }

        function parsePosicao(el) {
            const cs = getComputedStyle(el);
            const inicio = parseInt(cs.gridColumnStart, 10) || 1;
            const fim = String(cs.gridColumnEnd || '');
            let colspan = 1;
            if (fim.indexOf('span') !== -1) {
                colspan = parseInt(fim.replace('span', ''), 10) || 1;
            } else {
                const fimNum = parseInt(fim, 10);
                if (!isNaN(fimNum) && fimNum > inicio) colspan = fimNum - inicio;
            }

            const inicioLinha = parseInt(cs.gridRowStart, 10) || 1;
            const fimLinha = String(cs.gridRowEnd || '');
            let rowspan = 1;
            if (fimLinha.indexOf('span') !== -1) {
                rowspan = parseInt(fimLinha.replace('span', ''), 10) || 1;
            } else {
                const fimLinhaNum = parseInt(fimLinha, 10);
                if (!isNaN(fimLinhaNum) && fimLinhaNum > inicioLinha) rowspan = fimLinhaNum - inicioLinha;
            }

            return {
                id: parseInt(el.dataset.id, 10),
                coluna: inicio,
                colspan: colspan,
                linha: inicioLinha,
                rowspan: rowspan,
            };
        }

        function salvarPosicoes(posicoes) {
            const token = document.querySelector('meta[name="csrf-token"]');
            fetch('/organograma/posicoes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token ? token.content : '',
                },
                body: JSON.stringify({ posicoes: posicoes }),
            })
                .then(function (response) {
                    if (response.ok) {
                        mostrarToast('Posição salva!');
                    }
                })
                .catch(function () {
                    // Em caso de falha, a posição anterior volta no próximo carregamento.
                });
        }

        function mostrarToast(mensagem) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-lg';
            toast.textContent = mensagem;
            document.body.appendChild(toast);
            setTimeout(function () {
                toast.remove();
            }, 2500);
        }

        // ==========================================
        // MODO EDIÇÃO DOS CARDS
        // ==========================================
        let editMode = false;
        let selectedCardEl = null;
        let originalCardText = '';
        let originalCardName = '';
        let originalCardStyle = '';
        let currentAlign = 'center';
        let currentValign = 'center';
        let originalAlign = 'center';
        let originalValign = 'center';
        let salvandoCard = false;
        let salvamentoPendente = false;
        let autoSaveTimer = null;

        function toggleEditMode() {
            editMode = !editMode;
            document.body.classList.toggle('edit-mode', editMode);

            const btn = document.getElementById('editModeToggle');
            if (btn) {
                btn.classList.toggle('is-active', editMode);
                const icone = btn.querySelector('i');
                const texto = btn.querySelector('span');
                if (icone) icone.className = editMode ? 'fas fa-check text-lg' : 'fas fa-pen text-lte-purple text-lg';
                if (texto) texto.textContent = editMode ? 'Concluir' : 'Editar';
            }

            document.querySelectorAll('.node-cell[data-draggable="true"]').forEach(card => {
                card.setAttribute('draggable', editMode ? 'true' : 'false');
            });

            if (!editMode) {
                // Ao sair do modo edição, salva alterações pendentes.
                if (autoSaveTimer) {
                    clearTimeout(autoSaveTimer);
                    autoSaveTimer = null;
                    salvarCardEdit(true);
                }

                limparSelecaoCard();
                const panel = document.getElementById('cardEditPanel');
                if (panel) panel.classList.add('hidden');
                const form = document.getElementById('editCardForm');
                const hint = document.getElementById('editCardHint');
                if (form) form.classList.add('hidden');
                if (hint) hint.classList.remove('hidden');
            } else {
                mostrarPainelEdicao();
                document.getElementById('editCardForm').classList.add('hidden');
                document.getElementById('editCardHint').classList.remove('hidden');
                mostrarToast('Modo edição ativo: clique em um card para editar ou arraste para mover.');
            }
        }

        function mostrarPainelEdicao() {
            const panel = document.getElementById('cardEditPanel');
            if (panel) panel.classList.remove('hidden');
        }

        function limparSelecaoCard() {
            document.querySelectorAll('.node-cell.card-selected').forEach(el => el.classList.remove('card-selected'));
            selectedCardEl = null;
        }

        function voltarEdicaoCard() {
            // Cancela o salvamento automático pendente e desfaz a pré-visualização.
            if (autoSaveTimer) {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = null;
            }

            if (selectedCardEl) {
                if (originalCardStyle) {
                    selectedCardEl.setAttribute('style', originalCardStyle);
                } else {
                    selectedCardEl.removeAttribute('style');
                }

                const nameEl = selectedCardEl.querySelector('.card-name');
                if (nameEl && originalCardName !== '') {
                    nameEl.textContent = originalCardName;
                }
            }

            limparSelecaoCard();
            const panel = document.getElementById('cardEditPanel');
            if (panel) panel.classList.add('hidden');
            const form = document.getElementById('editCardForm');
            const hint = document.getElementById('editCardHint');
            if (form) form.classList.add('hidden');
            if (hint) hint.classList.remove('hidden');
        }

        function atualizarInfoPosicao() {
            const coluna = document.getElementById('editCardColuna');
            const linha = document.getElementById('editCardLinha');
            const infoColuna = document.getElementById('editCardColunaInfo');
            const infoLinha = document.getElementById('editCardLinhaInfo');
            if (infoColuna && coluna) infoColuna.textContent = coluna.value + '/' + (coluna.max || 9);
            if (infoLinha && linha) infoLinha.textContent = linha.value + '/' + (linha.max || 20);
        }

        function ajustarNumeroCard(id, delta) {
            const input = document.getElementById(id);
            if (!input) return;
            const min = parseInt(input.getAttribute('min'), 10) || 1;
            const max = parseInt(input.getAttribute('max'), 10) || 99;
            let valor = parseInt(input.value, 10);
            if (isNaN(valor)) valor = min;
            valor = Math.max(min, Math.min(max, valor + delta));
            input.value = valor;
            atualizarInfoPosicao();
            previewPosicaoCard();
        }

        function agendarSalvamento() {
            if (!selectedCardEl) return;
            if (autoSaveTimer) clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () {
                autoSaveTimer = null;
                salvarCardEdit(true);
            }, 600);
        }

        function previewNomeCard() {
            if (!selectedCardEl) return;
            const nome = document.getElementById('editCardName').value;
            const nameEl = selectedCardEl.querySelector('.card-name');
            if (!nameEl) return;
            const isBar = selectedCardEl.dataset.bar === 'true';
            nameEl.textContent = isBar ? nome : nome.toUpperCase();
            agendarSalvamento();
        }

        function previewPosicaoCard() {
            if (!selectedCardEl) return;
            if (selectedCardEl.dataset.fixo === 'true') return;

            let coluna = parseInt(document.getElementById('editCardColuna').value, 10);
            const linha = parseInt(document.getElementById('editCardLinha').value, 10);
            let colspan = parseInt(document.getElementById('editCardColspan').value, 10);
            let rowspan = parseInt(document.getElementById('editCardRowspan').value, 10);
            const maxCol = selectedCardEl.dataset.sector === 'apoio' ? 7 : 9;

            if (isNaN(coluna) || isNaN(linha) || isNaN(colspan) || isNaN(rowspan)) return;

            // Limita a largura/altura ao tamanho da área e reposiciona a coluna
            // para a esquerda quando o card crescer além da borda.
            colspan = Math.max(1, Math.min(maxCol, colspan));
            rowspan = Math.max(1, Math.min(6, rowspan));

            if (coluna < 1) coluna = 1;
            if (coluna + colspan - 1 > maxCol) {
                coluna = Math.max(1, maxCol - colspan + 1);
            }

            document.getElementById('editCardColuna').value = coluna;
            document.getElementById('editCardColspan').value = colspan;
            document.getElementById('editCardRowspan').value = rowspan;
            atualizarInfoPosicao();

            selectedCardEl.style.gridColumn = coluna + ' / span ' + colspan;
            selectedCardEl.style.gridRow = linha + ' / span ' + rowspan;
            agendarSalvamento();
        }

        function aplicarAlinhamentoCard(card, align, valign) {
            if (!card) return;
            const alignMap = { left: 'flex-start', center: 'center', right: 'flex-end' };
            const valignMap = { top: 'flex-start', center: 'center', bottom: 'flex-end' };
            const textAlignMap = { left: 'left', center: 'center', right: 'right' };
            const isBar = card.dataset.bar === 'true';

            if (isBar) {
                card.style.justifyContent = alignMap[align] || 'center';
                card.style.alignItems = valignMap[valign] || 'center';
            } else {
                card.style.alignItems = alignMap[align] || 'center';
                card.style.justifyContent = valignMap[valign] || 'center';
                const row = card.querySelector('.card-name-row');
                if (row) row.style.justifyContent = alignMap[align] || 'center';
            }

            // AdminLTE define .text-center com !important; o inline também precisa de !important.
            card.style.setProperty('text-align', textAlignMap[align] || 'center', 'important');
        }

        function atualizarBotoesAlinhamento() {
            document.querySelectorAll('#editCardAlignFields .align-btn').forEach(btn => {
                const ativo = btn.dataset.align === currentAlign;
                btn.classList.toggle('bg-emerald-600', ativo);
                btn.classList.toggle('text-white', ativo);
                btn.classList.toggle('bg-slate-200', !ativo);
                btn.classList.toggle('dark:bg-slate-700', !ativo);
                btn.classList.toggle('text-lte-text', !ativo);
                btn.classList.toggle('dark:text-lte-text-dark', !ativo);
            });

            document.querySelectorAll('#editCardAlignFields .valign-btn').forEach(btn => {
                const ativo = btn.dataset.valign === currentValign;
                btn.classList.toggle('bg-emerald-600', ativo);
                btn.classList.toggle('text-white', ativo);
                btn.classList.toggle('bg-slate-200', !ativo);
                btn.classList.toggle('dark:bg-slate-700', !ativo);
                btn.classList.toggle('text-lte-text', !ativo);
                btn.classList.toggle('dark:text-lte-text-dark', !ativo);
            });
        }

        function definirAlinhamento(valor) {
            currentAlign = valor;
            if (selectedCardEl) aplicarAlinhamentoCard(selectedCardEl, currentAlign, currentValign);
            atualizarBotoesAlinhamento();
            agendarSalvamento();
        }

        function definirAlinhamentoVertical(valor) {
            currentValign = valor;
            if (selectedCardEl) aplicarAlinhamentoCard(selectedCardEl, currentAlign, currentValign);
            atualizarBotoesAlinhamento();
            agendarSalvamento();
        }

        function centralizarCard() {
            currentAlign = 'center';
            currentValign = 'center';
            if (selectedCardEl) aplicarAlinhamentoCard(selectedCardEl, 'center', 'center');
            atualizarBotoesAlinhamento();
            agendarSalvamento();
        }

        function handleCardClick(card) {
            if (editMode) {
                selectCardForEdit(card);
                return;
            }
            const id = parseInt(card.dataset.id, 10);
            if (!isNaN(id)) openCardModal(id);
        }

        function lerPosicaoCard(card) {
            const style = card.getAttribute('style') || '';
            let coluna = 1;
            let colspan = 1;
            let linha = 1;

            const colMatch = style.match(/grid-column\s*:\s*(\d+)\s*\/\s*span\s*(\d+)/i);
            if (colMatch) {
                coluna = parseInt(colMatch[1], 10) || 1;
                colspan = parseInt(colMatch[2], 10) || 1;
            } else {
                const cs = getComputedStyle(card);
                coluna = parseInt(cs.gridColumnStart, 10) || 1;
                const fim = String(cs.gridColumnEnd || '');
                if (fim.indexOf('span') !== -1) {
                    colspan = parseInt(fim.replace('span', ''), 10) || 1;
                } else {
                    const fimNum = parseInt(fim, 10);
                    colspan = (!isNaN(fimNum) && fimNum > coluna) ? fimNum - coluna : 1;
                }
            }

            const rowMatch = style.match(/grid-row\s*:\s*(\d+)\s*\/\s*span\s*(\d+)/i);
            let rowspan = 1;
            if (rowMatch) {
                linha = parseInt(rowMatch[1], 10) || 1;
                rowspan = parseInt(rowMatch[2], 10) || 1;
            } else {
                const rowSimples = style.match(/grid-row\s*:\s*(\d+)/i);
                if (rowSimples) {
                    linha = parseInt(rowSimples[1], 10) || 1;
                } else {
                    linha = parseInt(getComputedStyle(card).gridRowStart, 10) || 1;
                }
                rowspan = cardRowSpan(card);
            }

            return { coluna: coluna, linha: linha, colspan: colspan, rowspan: rowspan };
        }

        function selectCardForEdit(card) {
            // Salva as alterações pendentes do card anterior antes de trocar de card.
            if (selectedCardEl && selectedCardEl !== card) {
                if (autoSaveTimer) {
                    clearTimeout(autoSaveTimer);
                    autoSaveTimer = null;
                    salvarCardEdit(true);
                }
            }

            selectedCardEl = card;

            document.querySelectorAll('.node-cell.card-selected').forEach(el => el.classList.remove('card-selected'));
            card.classList.add('card-selected');

            const nameEl = card.querySelector('.card-name');
            const pos = lerPosicaoCard(card);
            const fullWidth = card.dataset.fixo === 'true';
            const isBar = card.dataset.bar === 'true';
            const nomeAtual = isBar
                ? (nameEl ? nameEl.textContent.trim() : '')
                : (card.dataset.nome || (nameEl ? nameEl.textContent.trim() : ''));

            originalCardStyle = card.getAttribute('style') || '';
            originalCardName = nameEl ? nameEl.textContent : '';
            originalCardText = nomeAtual;
            currentAlign = card.dataset.align || 'center';
            currentValign = card.dataset.valign || 'center';
            originalAlign = currentAlign;
            originalValign = currentValign;

            document.getElementById('editCardId').value = card.dataset.id || '';
            document.getElementById('editCardBar').value = isBar ? '1' : '0';
            document.getElementById('editCardName').value = nomeAtual;
            document.getElementById('editCardName').maxLength = isBar ? 255 : 150;
            document.getElementById('editCardColuna').value = pos.coluna;
            document.getElementById('editCardLinha').value = pos.linha;
            document.getElementById('editCardColspan').value = pos.colspan;
            document.getElementById('editCardRowspan').value = pos.rowspan;

            const maxCol = card.dataset.sector === 'apoio' ? 7 : 9;
            document.getElementById('editCardColuna').max = maxCol;
            document.getElementById('editCardColspan').max = maxCol;
            document.getElementById('editCardRowspan').max = 6;
            atualizarInfoPosicao();
            atualizarBotoesAlinhamento();

            document.getElementById('editCardPosicaoFields').classList.toggle('hidden', fullWidth);
            document.getElementById('editCardFullWidthHint').classList.toggle('hidden', !fullWidth);

            document.getElementById('editCardForm').classList.remove('hidden');
            document.getElementById('editCardHint').classList.add('hidden');
            mostrarPainelEdicao();
        }

        function salvarCardEdit(auto) {
            auto = auto === true;

            if (autoSaveTimer) {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = null;
            }

            if (!selectedCardEl) return;

            if (salvandoCard) {
                salvamentoPendente = true;
                return;
            }

            const id = document.getElementById('editCardId').value;
            if (!id) return;

            const isBar = document.getElementById('editCardBar').value === '1';
            const nome = document.getElementById('editCardName').value.trim();
            let coluna = parseInt(document.getElementById('editCardColuna').value, 10);
            const linha = parseInt(document.getElementById('editCardLinha').value, 10);
            let colspan = parseInt(document.getElementById('editCardColspan').value, 10);
            let rowspan = parseInt(document.getElementById('editCardRowspan').value, 10);
            const fullWidth = selectedCardEl && selectedCardEl.dataset.fixo === 'true';
            const maxCol = selectedCardEl && selectedCardEl.dataset.sector === 'apoio' ? 7 : 9;

            if (!isNaN(colspan)) colspan = Math.max(1, Math.min(maxCol, colspan));
            if (!isNaN(rowspan)) rowspan = Math.max(1, Math.min(6, rowspan));
            if (!isNaN(coluna) && !isNaN(colspan) && coluna + colspan - 1 > maxCol) {
                coluna = Math.max(1, maxCol - colspan + 1);
                document.getElementById('editCardColuna').value = coluna;
            }

            if (!nome) {
                if (!auto) mostrarToast('Informe o nome ou texto do card.');
                return;
            }

            if (!fullWidth && (
                isNaN(coluna) || isNaN(linha) || isNaN(colspan) || isNaN(rowspan) ||
                coluna < 1 || colspan < 1 || rowspan < 1 ||
                coluna > maxCol || colspan > maxCol || rowspan > 6 ||
                (coluna + colspan - 1) > maxCol
            )) {
                if (!auto) mostrarToast('Tamanho ou posição inválidos para esta área.');
                return;
            }

            const textoMudou = nome !== originalCardText;
            const alignMudou = currentAlign !== originalAlign;
            const valignMudou = currentValign !== originalValign;
            let dados = {};

            if (!fullWidth) {
                dados.card_coluna = coluna;
                dados.card_linha = linha;
                dados.card_colspan = colspan;
                dados.card_rowspan = rowspan;
            }

            if (textoMudou) {
                if (isBar || fullWidth) {
                    dados.card_texto = nome;
                } else {
                    dados.nome_completo = nome;
                }
            }

            if (alignMudou) dados.card_align = currentAlign;
            if (valignMudou) dados.card_valign = currentValign;

            if (Object.keys(dados).length === 0) {
                if (!auto) mostrarToast('Nenhuma alteração para salvar.');
                return;
            }

            const cardRef = selectedCardEl;
            const nameEl = cardRef ? cardRef.querySelector('.card-name') : null;

            if (cardRef) {
                if (!fullWidth) {
                    cardRef.style.gridColumn = coluna + ' / span ' + colspan;
                    cardRef.style.gridRow = linha + ' / span ' + rowspan;
                }

                if (textoMudou && nameEl) {
                    nameEl.textContent = isBar ? nome : nome.toUpperCase();
                    if (!isBar) cardRef.dataset.nome = nome;
                }

                aplicarAlinhamentoCard(cardRef, currentAlign, currentValign);
                cardRef.dataset.align = currentAlign;
                cardRef.dataset.valign = currentValign;
            }

            salvarCard(id, dados).then(function (sucesso) {
                if (!cardRef) return;

                if (sucesso) {
                    // Só atualiza o ponto de retorno se o card ainda for o selecionado.
                    if (selectedCardEl === cardRef) {
                        originalCardText = nome;
                        originalAlign = currentAlign;
                        originalValign = currentValign;
                        originalCardStyle = cardRef.getAttribute('style') || '';
                        originalCardName = nameEl ? nameEl.textContent : '';
                    }
                    if (!isBar) cardRef.dataset.nome = nome;
                    return;
                }

                // No salvamento automático, mantém a pré-visualização para o usuário corrigir.
                if (auto) return;

                if (originalCardStyle) {
                    cardRef.setAttribute('style', originalCardStyle);
                } else {
                    cardRef.removeAttribute('style');
                }
                if (nameEl && originalCardName !== '') {
                    nameEl.textContent = originalCardName;
                }
                cardRef.dataset.align = originalAlign;
                cardRef.dataset.valign = originalValign;
                if (!isBar) cardRef.dataset.nome = originalCardText;
            });
        }

        function salvarCard(id, dados) {
            if (salvandoCard) return Promise.resolve(false);
            salvandoCard = true;

            const token = document.querySelector('meta[name="csrf-token"]');
            const botao = Array.from(document.querySelectorAll('#editCardForm button'))
                .find(b => b.textContent.trim() === 'Salvar' || b.textContent.trim() === 'Salvando...');

            if (botao) {
                botao.disabled = true;
                botao.textContent = 'Salvando...';
            }

            return fetch('/organograma/card/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token ? token.content : '',
                },
                body: JSON.stringify(dados),
            })
                .then(async function (response) {
                    if (response.ok) {
                        mostrarToast('Card atualizado!');
                        return true;
                    }

                    if (response.status === 419) {
                        mostrarToast('Sessão expirada. Recarregue a página com Ctrl+F5.');
                        return false;
                    }

                    let mensagem = 'Não foi possível salvar o card (HTTP ' + response.status + ').';
                    try {
                        const erro = await response.json();
                        if (erro && erro.errors) {
                            const primeiro = Object.values(erro.errors)[0];
                            if (Array.isArray(primeiro) && primeiro.length) mensagem = primeiro[0];
                        } else if (erro && erro.message) {
                            mensagem = erro.message;
                        }
                    } catch (e) {
                        // mantém a mensagem padrão
                    }
                    mostrarToast(mensagem);
                    return false;
                })
                .catch(function () {
                    mostrarToast('Falha de conexão ao salvar o card.');
                    return false;
                })
                .finally(function () {
                    salvandoCard = false;
                    if (botao) {
                        botao.disabled = false;
                        botao.textContent = 'Salvar';
                    }

                    if (salvamentoPendente) {
                        salvamentoPendente = false;
                        if (editMode && selectedCardEl) {
                            setTimeout(function () {
                                if (editMode && selectedCardEl) salvarCardEdit(true);
                            }, 60);
                        }
                    }
                });
        }

        // ==========================================
        // MINIMIZAR UI (TOPBAR + SIDEBAR)
        // ==========================================
        function toggleMinimizeUI() {
            const body = document.body;
            const icon = document.getElementById('minimizeUIIcon');
            const isMinimized = body.classList.toggle('ui-minimized');
            
            if (isMinimized) {
                icon.classList.replace('fa-compress-arrows-alt', 'fa-expand-arrows-alt');
                localStorage.setItem('uiMinimized', 'true');
            } else {
                icon.classList.replace('fa-expand-arrows-alt', 'fa-compress-arrows-alt');
                localStorage.setItem('uiMinimized', 'false');
            }
            
            // Recalcular zoom após animação
            setTimeout(() => {
                updateZoom();
            }, 300);
        }

        function initMinimizeUI() {
            const saved = localStorage.getItem('uiMinimized');
            const icon = document.getElementById('minimizeUIIcon');
            if (saved === 'true') {
                document.body.classList.add('ui-minimized');
                if (icon) icon.classList.replace('fa-compress-arrows-alt', 'fa-expand-arrows-alt');
            }
        }

        // ==========================================
        // INICIALIZAÇÃO
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            initMinimizeUI();
            initDragAndDrop();
            
            // Atalhos teclado
            document.addEventListener('keydown', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') return;
                
                switch(e.key) {
                    case '+': case '=': e.preventDefault(); changeZoom(ZOOM_STEP); break;
                    case '-': case '_': e.preventDefault(); changeZoom(-ZOOM_STEP); break;
                    case '0': e.preventDefault(); resetZoom(); break;
                    case 'f': case 'F': e.preventDefault(); fitToScreen(); break;
                    case '/': e.preventDefault(); document.getElementById('searchInput').focus(); break;
                    case 'Escape': closeCardModal(); closePhotoModal(); break;
                    case 'd': case 'D': 
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            toggleTheme();
                        }
                        break;
                }
            });
            
            // Fechar modal ao clicar fora
            document.getElementById('cardModal').addEventListener('click', function(e) {
                if (e.target === this) closeCardModal();
            });

            document.getElementById('photoModal').addEventListener('click', function(e) {
                if (e.target === this) closePhotoModal();
            });
        });

        // Disponibilizar globalmente
        window.changeZoom = changeZoom;
        window.resetZoom = resetZoom;
        window.fitToScreen = fitToScreen;
        window.filterNodes = filterNodes;
        window.openCardModal = openCardModal;
        window.closeCardModal = closeCardModal;
        window.openPhotoModal = openPhotoModal;
        window.closePhotoModal = closePhotoModal;
        window.previewPhoto = previewPhoto;
        window.toggleTheme = toggleTheme;
        window.toggleMinimizeUI = toggleMinimizeUI;
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>