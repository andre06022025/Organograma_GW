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
                const areaCard = card.dataset.area || '';
                const fixo = card.dataset.fixo === 'true';

                const matchBusca = !busca || nome.includes(busca) || cargo.includes(busca);
                const matchArea = setor === 'all' || areaCard === setor;

                card.style.display = (fixo || (matchBusca && matchArea)) ? '' : 'none';
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
            document.getElementById('modalRoleBadge').textContent = data.cargo || data.nivel_label || '-';
            document.getElementById('modalRoleBadge').className = 'bg-black/20 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase';
            document.getElementById('modalName').textContent = data.nome || '-';
            document.getElementById('modalRole').textContent = data.cargo || '-';

            document.getElementById('modalNivel').textContent = data.nivel_label || data.label_nivel || data.nivel || '-';
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
                nivel_label: card.dataset.labelNivel,
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
                    if (draggedCard.dataset.area !== area.dataset.area) return;

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
                    if (draggedCard.dataset.area !== area.dataset.area) return;
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
            if (origem.dataset.area !== destino.dataset.area) return false;
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
                area: el.dataset.area || 'producao',
                coluna: inicio,
                colspan: colspan,
                linha: inicioLinha,
                rowspan: rowspan,
            };
        }

        /**
         * Marca as posições recém-gravadas pelo drag-and-drop como o novo
         * estado salvo, para que o botão Voltar não desfaça o que já está no
         * banco.
         */
        function registrarPosicoesSalvas(posicoes) {
            posicoes.forEach(function (p) {
                if (!p || !p.id) return;

                const el = document.querySelector(
                    '.node-cell[data-id="' + p.id + '"][data-area="' + p.area + '"]'
                );

                if (!el) return;

                el.dataset.posPersiste = 'true';
                el.dataset.posColuna = p.coluna;
                el.dataset.posLinha = p.linha;
                el.dataset.posColspan = p.colspan;
                el.dataset.posRowspan = p.rowspan;

                if (el === selectedCardEl && estadoOriginal) {
                    estadoOriginal.posicao = {
                        coluna: p.coluna,
                        linha: p.linha,
                        colspan: p.colspan,
                        rowspan: p.rowspan,
                    };
                    originalCardStyle = el.getAttribute('style') || '';
                    estadoAlterado = false;
                }
            });
        }

        function salvarPosicoes(posicoes) {
            if (!posicoes.length) return Promise.resolve(false);

            const area = posicoes[0].area || 'producao';
            const token = document.querySelector('meta[name="csrf-token"]');

            return fetch('/organograma/posicoes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token ? token.content : '',
                },
                body: JSON.stringify({ area: area, posicoes: posicoes }),
            })
                .then(function (response) {
                    if (response.ok) {
                        registrarPosicoesSalvas(posicoes);
                        mostrarToast('Posição salva!');
                        return true;
                    }
                    return response.json()
                        .then(function (erro) {
                            mostrarToast((erro && erro.message) || 'Não foi possível salvar a posição.');
                        })
                        .catch(function () {
                            mostrarToast('Não foi possível salvar a posição.');
                        });
                })
                .catch(function () {
                    mostrarToast('Falha de conexão ao salvar a posição.');
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
        let originalCardStyle = '';
        let originalCardName = '';
        let currentAlign = 'center';
        let currentValign = 'center';
        let salvandoCard = false;
        let filaSalvamento = [];
        let autoSaveTimer = null;
        // Estado persistido no momento da seleção (usado pelo botão Voltar).
        let estadoOriginal = null;
        // Último estado gravado com sucesso (usado para reverter falhas).
        let estadoSalvo = null;
        // Indica se houve alguma alteração desde a seleção do card.
        let estadoAlterado = false;

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
                // Ao sair do modo edição, cancela o agendamento pendente.
                // O que já foi enfileirado continua sendo gravado.
                if (autoSaveTimer) {
                    clearTimeout(autoSaveTimer);
                    autoSaveTimer = null;
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

        // Posição do painel de edição (arrastável), persistida no navegador.
        let painelPosicaoSalva = null;
        let painelArrastando = false;
        let painelDeslocX = 0;
        let painelDeslocY = 0;

        function carregarPosicaoPainel() {
            try {
                const salvo = JSON.parse(localStorage.getItem('organograma.painelEdicao') || 'null');
                if (salvo && Number.isFinite(salvo.left) && Number.isFinite(salvo.top)) {
                    return salvo;
                }
            } catch (e) {
                // localStorage indisponível: usa a posição padrão
            }

            return null;
        }

        function limitarPosicaoPainel(left, top) {
            const painel = document.getElementById('cardEditPanel');
            const largura = (painel && painel.offsetWidth) || 320;
            const altura = (painel && painel.offsetHeight) || 220;
            const maxLeft = Math.max(0, window.innerWidth - largura);
            const maxTop = Math.max(0, window.innerHeight - Math.min(altura, 48));

            return {
                left: Math.min(Math.max(0, left), maxLeft),
                top: Math.min(Math.max(0, top), maxTop),
            };
        }

        function aplicarPosicaoPainel(left, top) {
            const painel = document.getElementById('cardEditPanel');
            if (!painel) return;

            const pos = limitarPosicaoPainel(left, top);
            painel.style.left = pos.left + 'px';
            painel.style.top = pos.top + 'px';
            painel.style.right = 'auto';
        }

        function mostrarPainelEdicao() {
            const panel = document.getElementById('cardEditPanel');
            if (!panel) return;

            panel.classList.remove('hidden');

            if (!painelPosicaoSalva) painelPosicaoSalva = carregarPosicaoPainel();
            if (painelPosicaoSalva) aplicarPosicaoPainel(painelPosicaoSalva.left, painelPosicaoSalva.top);
        }

        /**
         * Permite arrastar o painel de edição pela tela (pela barra de título),
         * para que ele não cubra o card que está sendo editado. A posição é
         * lembrada no navegador.
         */
        function initPainelArrastavel() {
            const painel = document.getElementById('cardEditPanel');
            const alca = document.getElementById('cardEditPanelHeader');

            if (!painel || !alca) return;

            function iniciarArraste(e) {
                // O botão de fechar continua clicável.
                if (e.target.closest('button')) return;

                const ponto = e.touches ? e.touches[0] : e;
                const rect = painel.getBoundingClientRect();

                painelArrastando = true;
                painelDeslocX = ponto.clientX - rect.left;
                painelDeslocY = ponto.clientY - rect.top;

                painel.style.left = rect.left + 'px';
                painel.style.top = rect.top + 'px';
                painel.style.right = 'auto';
                document.body.style.userSelect = 'none';

                if (e.cancelable) e.preventDefault();
            }

            function moverArraste(e) {
                if (!painelArrastando) return;

                const ponto = e.touches ? e.touches[0] : e;
                const pos = limitarPosicaoPainel(
                    ponto.clientX - painelDeslocX,
                    ponto.clientY - painelDeslocY
                );

                painel.style.left = pos.left + 'px';
                painel.style.top = pos.top + 'px';
                painel.style.right = 'auto';

                if (e.cancelable) e.preventDefault();
            }

            function finalizarArraste() {
                if (!painelArrastando) return;

                painelArrastando = false;
                document.body.style.userSelect = '';

                painelPosicaoSalva = {
                    left: parseFloat(painel.style.left) || 0,
                    top: parseFloat(painel.style.top) || 0,
                };

                try {
                    localStorage.setItem('organograma.painelEdicao', JSON.stringify(painelPosicaoSalva));
                } catch (e) {
                    // sem persistência: a posição vale só nesta sessão
                }
            }

            alca.addEventListener('mousedown', iniciarArraste);
            alca.addEventListener('touchstart', iniciarArraste, { passive: false });
            document.addEventListener('mousemove', moverArraste);
            document.addEventListener('touchmove', moverArraste, { passive: false });
            document.addEventListener('mouseup', finalizarArraste);
            document.addEventListener('touchend', finalizarArraste);

            // Reajusta o painel se a janela mudar de tamanho.
            window.addEventListener('resize', function () {
                if (!painel.classList.contains('hidden') && painel.style.left) {
                    aplicarPosicaoPainel(parseFloat(painel.style.left) || 0, parseFloat(painel.style.top) || 0);
                }
            });
        }

        function limparSelecaoCard() {
            document.querySelectorAll('.node-cell.card-selected').forEach(el => el.classList.remove('card-selected'));
            selectedCardEl = null;
            estadoOriginal = null;
            estadoSalvo = null;
        }

        /**
         * Payload que devolve o card ao estado persistido no momento da seleção.
         * Campos null removem a customização da área.
         */
        function payloadReverter(estado) {
            if (!estado) return null;

            const dados = { area: estado.area };

            if (estado.isBar) {
                // null volta ao texto padrão da view.
                dados.texto = estado.texto;
            } else {
                dados.nome_completo = estado.nome;
            }

            dados.posicao = estado.posicao;
            dados.align = estado.align;
            dados.valign = estado.valign;

            return dados;
        }

        function voltarEdicaoCard() {
            // Cancela o salvamento automático agendado.
            if (autoSaveTimer) {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = null;
            }

            const card = selectedCardEl;
            const id = document.getElementById('editCardId').value;
            const temAlteracaoPendente = !!estadoAlterado;

            // Remove da fila o que ainda não foi gravado para este card.
            if (id) {
                filaSalvamento = filaSalvamento.filter(function (item) {
                    return item.id !== id;
                });
            }

            // Só desfaz o que ainda não foi gravado. O que já está salvo no
            // banco permanece (posição, texto e alinhamento).
            if (card && estadoOriginal && id && temAlteracaoPendente) {
                const payload = payloadReverter(estadoOriginal);
                if (payload) {
                    enfileirarSalvamento({
                        id: id,
                        dados: payload,
                        card: card,
                        silencioso: true,
                        reverter: true,
                    });
                }

                // Restaura a pré-visualização na tela.
                if (originalCardStyle) {
                    card.setAttribute('style', originalCardStyle);
                } else {
                    card.removeAttribute('style');
                }

                const nameEl = card.querySelector('.card-name');
                if (nameEl && originalCardName !== '') {
                    nameEl.textContent = originalCardName;
                }
                card.dataset.align = estadoOriginal.align;
                card.dataset.valign = estadoOriginal.valign;
            }

            estadoAlterado = false;

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
            estadoAlterado = true;
            agendarSalvamento();
        }

        function previewPosicaoCard() {
            if (!selectedCardEl) return;
            if (selectedCardEl.dataset.fixo === 'true') return;

            let coluna = parseInt(document.getElementById('editCardColuna').value, 10);
            const linha = parseInt(document.getElementById('editCardLinha').value, 10);
            let colspan = parseInt(document.getElementById('editCardColspan').value, 10);
            let rowspan = parseInt(document.getElementById('editCardRowspan').value, 10);
            const maxCol = maxColunasArea(selectedCardEl.dataset.area);

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
            estadoAlterado = true;
            agendarSalvamento();
        }

        function maxColunasArea(area) {
            return area === 'apoio' ? 7 : 9;
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
            estadoAlterado = true;
            agendarSalvamento();
        }

        function definirAlinhamentoVertical(valor) {
            currentValign = valor;
            if (selectedCardEl) aplicarAlinhamentoCard(selectedCardEl, currentAlign, currentValign);
            atualizarBotoesAlinhamento();
            estadoAlterado = true;
            agendarSalvamento();
        }

        function centralizarCard() {
            currentAlign = 'center';
            currentValign = 'center';
            if (selectedCardEl) aplicarAlinhamentoCard(selectedCardEl, 'center', 'center');
            atualizarBotoesAlinhamento();
            estadoAlterado = true;
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
            // Enfileira as alterações pendentes do card anterior antes de trocar.
            if (selectedCardEl && selectedCardEl !== card) {
                if (autoSaveTimer) {
                    clearTimeout(autoSaveTimer);
                    autoSaveTimer = null;
                }
                salvarCardEdit(true);
            }

            selectedCardEl = card;

            document.querySelectorAll('.node-cell.card-selected').forEach(el => el.classList.remove('card-selected'));
            card.classList.add('card-selected');

            const nameEl = card.querySelector('.card-name');
            const pos = lerPosicaoCard(card);
            const fullWidth = card.dataset.fixo === 'true';
            const isBar = card.dataset.bar === 'true';
            const area = card.dataset.area || 'producao';
            const nomeAtual = isBar
                ? (nameEl ? nameEl.textContent.trim() : '')
                : (card.dataset.nome || (nameEl ? nameEl.textContent.trim() : ''));

            originalCardStyle = card.getAttribute('style') || '';
            originalCardName = nameEl ? nameEl.textContent : '';
            currentAlign = card.dataset.align || 'center';
            currentValign = card.dataset.valign || 'center';

            // Estado persistido no momento da seleção (base do botão Voltar).
            const posPersiste = card.dataset.posPersiste === 'true';
            const posicaoOriginal = posPersiste ? {
                coluna: parseInt(card.dataset.posColuna, 10) || pos.coluna,
                linha: parseInt(card.dataset.posLinha, 10) || pos.linha,
                colspan: parseInt(card.dataset.posColspan, 10) || pos.colspan,
                rowspan: parseInt(card.dataset.posRowspan, 10) || pos.rowspan,
            } : null;

            estadoOriginal = {
                id: card.dataset.id || '',
                area: area,
                isBar: isBar,
                nome: card.dataset.nome || '',
                // Texto exibido no momento da seleção (para detectar alteração).
                textoExibido: isBar
                    ? (nameEl ? nameEl.textContent.trim() : '')
                    : (card.dataset.nome || ''),
                // Texto customizado salvo no banco (null = usa o padrão da view).
                texto: card.dataset.texto || null,
                posicao: posicaoOriginal,
                align: currentAlign,
                valign: currentValign,
            };
            estadoSalvo = estadoOriginal;
            estadoAlterado = false;

            document.getElementById('editCardId').value = card.dataset.id || '';
            document.getElementById('editCardBar').value = isBar ? '1' : '0';
            document.getElementById('editCardName').value = nomeAtual;
            document.getElementById('editCardName').maxLength = isBar ? 255 : 150;
            document.getElementById('editCardColuna').value = pos.coluna;
            document.getElementById('editCardLinha').value = pos.linha;
            document.getElementById('editCardColspan').value = pos.colspan;
            document.getElementById('editCardRowspan').value = pos.rowspan;

            const maxCol = maxColunasArea(area);
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

        /**
         * Monta o payload de salvamento do card selecionado.
         */
        function montarDadosCard() {
            const card = selectedCardEl;
            if (!card) return null;

            const id = document.getElementById('editCardId').value;
            if (!id) return null;

            const isBar = document.getElementById('editCardBar').value === '1';
            const nome = document.getElementById('editCardName').value.trim();
            const area = card.dataset.area || 'producao';
            const fullWidth = card.dataset.fixo === 'true';
            const maxCol = maxColunasArea(area);

            let coluna = parseInt(document.getElementById('editCardColuna').value, 10);
            const linha = parseInt(document.getElementById('editCardLinha').value, 10);
            let colspan = parseInt(document.getElementById('editCardColspan').value, 10);
            let rowspan = parseInt(document.getElementById('editCardRowspan').value, 10);

            if (!isNaN(colspan)) colspan = Math.max(1, Math.min(maxCol, colspan));
            if (!isNaN(rowspan)) rowspan = Math.max(1, Math.min(6, rowspan));
            if (!isNaN(coluna) && !isNaN(colspan) && coluna + colspan - 1 > maxCol) {
                coluna = Math.max(1, maxCol - colspan + 1);
                document.getElementById('editCardColuna').value = coluna;
            }

            if (!nome) {
                mostrarToast('Informe o nome ou texto do card.');
                return null;
            }

            if (!fullWidth && (
                isNaN(coluna) || isNaN(linha) || isNaN(colspan) || isNaN(rowspan) ||
                coluna < 1 || colspan < 1 || rowspan < 1 ||
                coluna > maxCol || colspan > maxCol || rowspan > 6 ||
                (coluna + colspan - 1) > maxCol
            )) {
                mostrarToast('Tamanho ou posição inválidos para esta área.');
                return null;
            }

            const dados = { area: area };

            // A posição só é enviada quando muda em relação ao que está salvo.
            // Sem isso, salvar um card gravaria um override com o valor padrão
            // da view, congelando o layout.
            const posicaoOriginal = estadoOriginal ? estadoOriginal.posicao : null;
            const posicaoAtual = {
                coluna: coluna,
                linha: linha,
                colspan: colspan,
                rowspan: rowspan,
            };

            const posicaoMudou = !posicaoOriginal || (
                posicaoOriginal.coluna !== posicaoAtual.coluna ||
                posicaoOriginal.linha !== posicaoAtual.linha ||
                posicaoOriginal.colspan !== posicaoAtual.colspan ||
                posicaoOriginal.rowspan !== posicaoAtual.rowspan
            );

            if (!fullWidth && posicaoMudou) {
                dados.posicao = posicaoAtual;
            }

            // O texto só é enviado quando mudou de fato: o rótulo padrão das
            // barras é derivado do nome e não deve ficar congelado no banco.
            const textoMudou = nome !== (estadoOriginal ? estadoOriginal.textoExibido : nome);

            if (textoMudou) {
                if (isBar || fullWidth) {
                    dados.texto = nome;
                } else {
                    dados.nome_completo = nome;
                }
            }

            if (currentAlign !== (estadoOriginal ? estadoOriginal.align : currentAlign)) {
                dados.align = currentAlign;
            }

            if (currentValign !== (estadoOriginal ? estadoOriginal.valign : currentValign)) {
                dados.valign = currentValign;
            }

            if (Object.keys(dados).length === 1) {
                return { id: id, dados: dados, card: card, semAlteracao: true };
            }

            return { id: id, dados: dados, card: card };
        }

        function salvarCardEdit(auto) {
            auto = auto === true;

            if (autoSaveTimer) {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = null;
            }

            if (!selectedCardEl) return;

            const montagem = montarDadosCard();
            if (!montagem) return;

            if (montagem.semAlteracao) {
                if (!auto) mostrarToast('Nenhuma alteração para salvar.');
                return;
            }

            const card = montagem.card;
            const isBar = document.getElementById('editCardBar').value === '1';
            const nome = document.getElementById('editCardName').value.trim();
            const nameEl = card.querySelector('.card-name');

            // Aplica a pré-visualização imediatamente.
            if (!card.dataset.fixo || card.dataset.fixo !== 'true') {
                if (montagem.dados.posicao) {
                    card.style.gridColumn = montagem.dados.posicao.coluna + ' / span ' + montagem.dados.posicao.colspan;
                    card.style.gridRow = montagem.dados.posicao.linha + ' / span ' + montagem.dados.posicao.rowspan;
                }
            }

            const textoMudou = nome !== (estadoOriginal ? estadoOriginal.textoExibido : nome);

            if (textoMudou && nameEl) {
                if (isBar || card.dataset.bar === 'true') {
                    nameEl.textContent = nome;
                } else {
                    nameEl.textContent = nome.toUpperCase();
                    card.dataset.nome = nome;
                }
            }

            aplicarAlinhamentoCard(card, currentAlign, currentValign);
            card.dataset.align = currentAlign;
            card.dataset.valign = currentValign;

            enfileirarSalvamento({
                id: montagem.id,
                dados: montagem.dados,
                card: card,
                silencioso: auto,
            });
        }

        /**
         * Fila de salvamento: garante que as edições de cada card sejam
         * gravadas mesmo quando o usuário troca de card durante a requisição.
         */
        function enfileirarSalvamento(item) {
            filaSalvamento.push(item);
            processarFilaSalvamento();
        }

        function processarFilaSalvamento() {
            if (salvandoCard) return;

            const item = filaSalvamento.shift();
            if (!item) return;

            salvandoCard = true;

            const token = document.querySelector('meta[name="csrf-token"]');
            const botao = Array.from(document.querySelectorAll('#editCardForm button'))
                .find(b => b.textContent.trim() === 'Salvar' || b.textContent.trim() === 'Salvando...');

            if (botao) {
                botao.disabled = true;
                botao.textContent = 'Salvando...';
            }

            fetch('/organograma/card/' + item.id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token ? token.content : '',
                },
                body: JSON.stringify(item.dados),
            })
                .then(async function (response) {
                    if (response.ok) {
                        item.sucesso = true;
                        if (!item.silencioso) mostrarToast('Card atualizado!');
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

                    // Sucesso: o card gravado passa a ser a referência do Voltar.
                    if (item.sucesso && item.card) {
                        const d = item.dados;
                        item.card.dataset.align = d.align !== undefined ? d.align : item.card.dataset.align;
                        item.card.dataset.valign = d.valign !== undefined ? d.valign : item.card.dataset.valign;

                        if (d.posicao) {
                            item.card.dataset.posPersiste = 'true';
                            item.card.dataset.posColuna = d.posicao.coluna;
                            item.card.dataset.posLinha = d.posicao.linha;
                            item.card.dataset.posColspan = d.posicao.colspan;
                            item.card.dataset.posRowspan = d.posicao.rowspan;
                        } else if (d.posicao === null) {
                            item.card.dataset.posPersiste = 'false';
                            item.card.dataset.posColuna = '';
                            item.card.dataset.posLinha = '';
                            item.card.dataset.posColspan = '';
                            item.card.dataset.posRowspan = '';
                        }

                        if (d.texto !== undefined) {
                            item.card.dataset.texto = d.texto || '';
                        }

                        // O que foi gravado deixa de ser "alteração pendente": o
                        // Voltar passa a fechar o painel sem desfazer o que já
                        // está salvo no banco.
                        if (item.card === selectedCardEl && estadoOriginal && !item.reverter) {
                            if (d.posicao !== undefined) {
                                estadoOriginal.posicao = d.posicao;
                            }

                            if (d.texto !== undefined) {
                                estadoOriginal.texto = d.texto || null;
                                estadoOriginal.textoExibido = d.texto || '';
                            }

                            if (d.nome_completo !== undefined) {
                                estadoOriginal.nome = d.nome_completo;
                                estadoOriginal.textoExibido = d.nome_completo;
                            }

                            if (d.align !== undefined) estadoOriginal.align = d.align;
                            if (d.valign !== undefined) estadoOriginal.valign = d.valign;

                            // A pré-visualização atual passa a ser o estado salvo.
                            originalCardStyle = item.card.getAttribute('style') || '';
                            const nameEl = item.card.querySelector('.card-name');
                            originalCardName = nameEl ? nameEl.textContent : '';

                            estadoAlterado = false;
                        }
                    }

                    processarFilaSalvamento();
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
            initPainelArrastavel();
            
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

        // Disponibilizar globalmente (usadas em atributos inline do Blade)
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
        window.toggleSidebar = toggleSidebar;
        window.toggleEditMode = toggleEditMode;
        window.handleCardClick = handleCardClick;
        window.selectCardForEdit = selectCardForEdit;
        window.salvarCardEdit = salvarCardEdit;
        window.voltarEdicaoCard = voltarEdicaoCard;
        window.ajustarNumeroCard = ajustarNumeroCard;
        window.previewNomeCard = previewNomeCard;
        window.previewPosicaoCard = previewPosicaoCard;
        window.definirAlinhamento = definirAlinhamento;
        window.definirAlinhamentoVertical = definirAlinhamentoVertical;
        window.centralizarCard = centralizarCard;
