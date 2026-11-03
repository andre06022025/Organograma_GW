<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
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

                <!-- CONTATO -->
                <div class="flex items-center gap-1.5 pt-2 border-t border-lte-border dark:border-lte-border-dark text-[11px] text-lte-text-muted dark:text-lte-text-muted-dark">
                    <i class="fa-solid fa-envelope text-lte-orange"></i>
                    <span id="modalEmail">-</span>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="bg-lte-gray-bg dark:bg-lte-gray-bg-dark px-4 py-2 border-t border-lte-border dark:border-lte-border-dark flex justify-between items-center text-[10px] text-lte-text-muted dark:text-lte-text-muted-dark">
                <span>ID do colaborador: <strong id="modalUserId">#-</strong></span>
                <button onclick="closeCardModal()" class="px-3 py-1 bg-slate-700 dark:bg-slate-600 text-white font-semibold rounded hover:bg-slate-600 dark:hover:bg-slate-500">Fechar</button>
            </div>

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
            document.getElementById('modalUserId').textContent = '#' + data.id;
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
            
            // Atalhos teclado
            document.addEventListener('keydown', function(e) {
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') return;
                
                switch(e.key) {
                    case '+': case '=': e.preventDefault(); changeZoom(ZOOM_STEP); break;
                    case '-': case '_': e.preventDefault(); changeZoom(-ZOOM_STEP); break;
                    case '0': e.preventDefault(); resetZoom(); break;
                    case 'f': case 'F': e.preventDefault(); fitToScreen(); break;
                    case '/': e.preventDefault(); document.getElementById('searchInput').focus(); break;
                    case 'Escape': closeCardModal(); break;
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
        });

        // Disponibilizar globalmente
        window.changeZoom = changeZoom;
        window.resetZoom = resetZoom;
        window.fitToScreen = fitToScreen;
        window.filterNodes = filterNodes;
        window.openCardModal = openCardModal;
        window.closeCardModal = closeCardModal;
        window.toggleTheme = toggleTheme;
        window.toggleMinimizeUI = toggleMinimizeUI;
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>