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
                <label for="searchInput" class="sr-only">Buscar colaborador ou cargo</label>
                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-lte-text-muted dark:text-lte-text-muted-dark"></i>
                <input type="text" id="searchInput" onkeyup="filterNodes()" placeholder="Buscar colaborador ou cargo..." class="w-full pl-8 pr-3 py-1 text-xs border border-lte-border dark:border-lte-border-dark rounded bg-lte-card-bg dark:bg-lte-card-bg-dark text-lte-text dark:text-lte-text-dark focus:outline-none focus:ring-1 focus:ring-lte-purple">
            </div>

            <!-- Filtro de Área -->
            <label for="sectorFilter" class="sr-only">Filtrar por área</label>
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
                <label for="editCardName" class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Nome / texto</label>
                <input type="text" id="editCardName" maxlength="255" oninput="previewNomeCard()"
                       class="w-full border border-lte-border dark:border-lte-border-dark rounded px-2 py-1.5 bg-lte-card-bg dark:bg-slate-800 text-lte-text dark:text-lte-text-dark">
            </div>

            <div id="editCardPosicaoFields" class="space-y-3">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="editCardColuna" class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">
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
                        <label for="editCardLinha" class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">
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
                        <label for="editCardColspan" class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Largura (colunas)</label>
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
                        <label for="editCardRowspan" class="block font-semibold text-lte-text-muted dark:text-lte-text-muted-dark mb-0.5">Altura (linhas)</label>
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
    

    @yield('scripts')
    @stack('scripts')
</body>
</html>
