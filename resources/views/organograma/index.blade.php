@extends('layouts.app')

@section('title', 'Organograma Corporativo - General Water')

@section('organograma-content')
    <!-- ================= NÍVEL 1: DIREÇÃO ================= -->
    <div class="flex justify-center w-full">
        <div class="node-card bg-lte-orange text-white rounded shadow-md border-b-2 border-lte-orange-dark p-2 w-72 flex items-center gap-2"
             onclick="openCardModal('DIR-THIAGO')" data-id="DIR-THIAGO" data-name="Thiago" data-role="Direção Geral" data-sector="direcao" data-nivel="direcao" data-label-nivel="Nível Executivo" data-cor-nivel="bg-lte-orange" data-area-atuacao="Supervisão Geral do Grupo">
            <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
            <div class="flex-1 min-w-0">
                <span class="bg-black/20 text-[9px] font-bold px-1.5 py-0.2 rounded uppercase">Nível Executivo</span>
                <h2 class="font-bold text-sm leading-tight">DIREÇÃO (THIAGO)</h2>
                <p class="text-[10px] text-orange-100">Supervisão Geral do Grupo</p>
            </div>
        </div>
    </div>

    <!-- LINHA CONECTORA CENTRAL -->
    <div class="w-0.5 h-4 bg-slate-400"></div>

    <!-- ================= DIVISÃO EM DUAS COLUNAS PRINCIPAIS ================= -->
    <div class="grid grid-cols-2 gap-6 w-full max-w-[1600px] items-start">

        <!-- ================= COLUNA 1: ÁREAS DE PRODUÇÃO ================= -->
        <div class="bg-slate-100 p-3 rounded-lg border border-slate-300 shadow-sm flex flex-col gap-3">
            <div class="bg-slate-800 text-white font-bold text-center py-1 rounded text-xs uppercase tracking-wide">
                Áreas de Produção
            </div>

            <!-- NÍVEL 2 PRODUÇÃO: SUPERINTENDÊNCIAS -->
            <div class="grid grid-cols-2 gap-2">
                <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2"
                     onclick="openCardModal('SUP-RENATO')" data-id="SUP-RENATO" data-name="Renato Capuano" data-role="Superintendência" data-sector="producao" data-nivel="superintendencia" data-label-nivel="Superintendência" data-cor-nivel="bg-lte-purple" data-area-atuacao="Sistemas 1 a 6">
                    <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    <div class="min-w-0">
                        <span class="text-[9px] opacity-80 block font-semibold truncate">SUPERINTENDÊNCIA</span>
                        <h3 class="font-bold text-xs truncate">RENATO CAPUANO</h3>
                    </div>
                </div>

                <div class="node-card bg-lte-cyan text-white p-2 rounded flex items-center gap-2"
                     onclick="openCardModal('SUP-ARTHUR')" data-id="SUP-ARTHUR" data-name="Arthur" data-role="Superintendência" data-sector="producao" data-nivel="superintendencia" data-label-nivel="Superintendência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="Sistemas 7 a 9">
                    <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    <div class="min-w-0">
                        <span class="text-[9px] opacity-80 block font-semibold truncate">SUPERINTENDÊNCIA</span>
                        <h3 class="font-bold text-xs truncate">ARTHUR</h3>
                    </div>
                </div>
            </div>

            <!-- NÍVEL 3 PRODUÇÃO: GERÊNCIA CORPORATIVA -->
            <div class="node-card bg-lte-purple text-white p-1.5 rounded flex items-center justify-center gap-2"
                 onclick="openCardModal('GER-NEVES')" data-id="GER-NEVES" data-name="Neves" data-role="Ger. Corporativa" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência Corporativa" data-cor-nivel="bg-lte-purple" data-area-atuacao="Transversal a todas as áreas">
                <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                <div class="text-left">
                    <span class="text-[8px] uppercase font-bold bg-black/20 px-1 rounded block w-max">Gerência Corporativa</span>
                    <h4 class="font-bold text-xs">NEVES</h4>
                </div>
            </div>

            <!-- NÍVEL 4 & 5 PRODUÇÃO: SISTEMAS 1 A 9 (GRID COMPACTO COM FOTOS) -->
            <div class="grid grid-cols-6 gap-1.5">

                <!-- SISTEMAS 1 -->
                <div class="bg-purple-50 border border-purple-200 rounded p-1 space-y-1">
                    <div class="bg-lte-purple text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 1</div>
                    
                    <div class="node-card bg-lte-purple text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-FREDDY')" data-id="COO-FREDDY" data-name="Freddy" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Rotas + RMSP">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[9px] truncate">Coord. FREDDY</p>
                            <p class="text-[7.5px] opacity-80 truncate">Rotas + RMSP</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/90 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-DENIS')" data-id="SUP-DENIS" data-name="Denis" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Integrados + Rota 3">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 1 DENIS</p>
                            <p class="text-[7.5px] opacity-80 truncate">Integ. Rota 3</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-PAULO')" data-id="SUP-PAULO" data-name="Paulo" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Integrados + Rota 2">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 2 PAULO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Integ. Rota 2</p>
                        </div>
                    </div>
                </div>

                <!-- SISTEMAS 2 -->
                <div class="bg-purple-50 border border-purple-200 rounded p-1 space-y-1">
                    <div class="bg-lte-purple text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 2</div>
                    
                    <div class="node-card bg-lte-purple text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-LEONARDO')" data-id="COO-LEONARDO" data-name="Leonardo M." data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Rotas + RMSP (ABC)">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[9px] truncate">Coord. LEONARDO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Rotas + RMSP</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/90 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-VAGNER')" data-id="SUP-VAGNER" data-name="Vagner" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="RMSP (ABC)">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 1 VAGNER</p>
                            <p class="text-[7.5px] opacity-80 truncate">RMSP (ABC)</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-ERIC')" data-id="SUP-ERIC" data-name="Eric" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Rota Paulista">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 2 ERIC</p>
                            <p class="text-[7.5px] opacity-80 truncate">Rota Paulista</p>
                        </div>
                    </div>
                </div>

                <!-- SISTEMAS 3 + 4 -->
                <div class="bg-purple-50 border border-purple-200 rounded p-1 space-y-1">
                    <div class="bg-lte-purple text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 3+4</div>
                    
                    <div class="node-card bg-lte-purple text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-VILELA')" data-id="COO-VILELA" data-name="Vilela + Wellington" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Interior SP / CFO">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[8.5px] truncate">VILELA + WELLINGTON</p>
                            <p class="text-[7px] opacity-80 truncate">Interior SP / CFO</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/90 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-JULIO')" data-id="SUP-JULIO" data-name="Julio" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Campinas+SJRP">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 1 JULIO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Campinas+SJRP</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/85 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('OP-LUCAS')" data-id="OP-LUCAS" data-name="Lucas" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-purple/85" data-area-atuacao="Bragança+Jundiaí">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Op. Líder LUCAS</p>
                            <p class="text-[7.5px] opacity-80 truncate">Bragança+Jundiaí</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-ALAN')" data-id="SUP-ALAN" data-name="Alan" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="CFO + Campinas">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 2 ALAN</p>
                            <p class="text-[7.5px] opacity-80 truncate">CFO + Campinas</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/75 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-JOAO')" data-id="SUP-JOAO" data-name="João" data-role="Supervisão 3" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/75" data-area-atuacao="Interior SP/Rota">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 3 JOÃO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Interior SP/Rota</p>
                        </div>
                    </div>
                </div>

                <!-- SISTEMAS 5 -->
                <div class="bg-purple-50 border border-purple-200 rounded p-1 space-y-1">
                    <div class="bg-lte-purple text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 5</div>
                    
                    <div class="node-card bg-lte-purple text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-ANDRE')" data-id="COO-ANDRE" data-name="André" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Integ. RMSP">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[9px] truncate">Coord. ANDRÉ</p>
                            <p class="text-[7.5px] opacity-80 truncate">Integ. RMSP</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/90 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-ANFRISIO')" data-id="SUP-ANFRISIO" data-name="Anfrísio" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Integ. ZL + Sh D">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 1 ANFRÍSIO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Integ. ZL + Sh D</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-EVERTON')" data-id="SUP-EVERTON" data-name="Everton" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Rota 1 + Expo">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 2 EVERTON</p>
                            <p class="text-[7.5px] opacity-80 truncate">Rota 1 + Expo</p>
                        </div>
                    </div>
                </div>

                <!-- SISTEMAS 6 -->
                <div class="bg-purple-50 border border-purple-200 rounded p-1 space-y-1">
                    <div class="bg-lte-purple text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 6</div>
                    
                    <div class="node-card bg-lte-purple text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-RODRIGO')" data-id="COO-RODRIGO" data-name="Rodrigo" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Integ. RMSP">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[9px] truncate">Coord. RODRIGO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Integ. RMSP</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/90 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-VANDERSO')" data-id="SUP-VANDERSO" data-name="Vanderso" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Castelo + Granja">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 1 VANDERSO</p>
                            <p class="text-[7.5px] opacity-80 truncate">Castelo + Granja</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('SUP-CESAR')" data-id="SUP-CESAR" data-name="Cesar" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Continental + ZN">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8.5px] truncate">Superv. 2 CESAR</p>
                            <p class="text-[7.5px] opacity-80 truncate">Continental + ZN</p>
                        </div>
                    </div>
                </div>

                <!-- SISTEMAS 7, 8, 9 -->
                <div class="bg-cyan-50 border border-cyan-200 rounded p-1 space-y-1">
                    <div class="bg-lte-cyan text-white font-bold text-[9px] p-0.5 rounded text-center">SISTEMAS 7,8,9</div>
                    
                    <div class="node-card bg-lte-cyan text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('GER-SERGIO')" data-id="GER-SERGIO" data-name="Sergio Luiz" data-role="Gerência S7" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="Bahia">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[8.5px] truncate">Ger. SERGIO LUIZ</p>
                            <p class="text-[7.5px] opacity-90 truncate">Bahia</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-cyan text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('COO-PEDRO')" data-id="COO-PEDRO" data-name="Pedro" data-role="Coord. S8" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-cyan" data-area-atuacao="RMSP + RJ">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[8.5px] truncate">Coord. PEDRO</p>
                            <p class="text-[7.5px] opacity-90 truncate">RMSP + RJ</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-cyan text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('GER-DIOGO')" data-id="GER-DIOGO" data-name="Diogo" data-role="Gerência S9" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="DF">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold leading-tight text-[8.5px] truncate">Ger. DIOGO</p>
                            <p class="text-[7.5px] opacity-90 truncate">DF</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- GESTÃO OPERACIONAL E LÍDERES REGIONAIS -->
            <div class="bg-cyan-100/60 border border-cyan-300 p-2 rounded space-y-1.5">
                <div class="node-card bg-lte-cyan text-white p-1.5 rounded flex items-center justify-center gap-2" onclick="openCardModal('GOP-ANA')" data-id="GOP-ANA" data-name="Ana Luiza" data-role="Gestão Op." data-sector="producao" data-nivel="gerencia" data-label-nivel="Gestão Op." data-cor-nivel="bg-lte-cyan" data-area-atuacao="Integ. RMSP (Pinheiros) / DF / Bahia">
                    <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    <div class="text-left">
                        <span class="text-[8px] uppercase font-bold bg-black/20 px-1 rounded block w-max">Gestão Op.</span>
                        <h4 class="font-bold text-xs">ANA LUIZA</h4>
                        <p class="text-[8px] text-cyan-100">Integ. RMSP (Pinheiros) / DF / Bahia</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-1">
                    <div class="node-card bg-lte-cyan/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('OP-DEIVISON')" data-id="OP-DEIVISON" data-name="Deivison" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="Bahia">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[8px] truncate">Op. DEIVISON</p>
                            <p class="text-[7px] opacity-80 truncate">Bahia</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-cyan/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('OP-LAGUS')" data-id="OP-LAGUS" data-name="Lagus" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="RJ">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[8px] truncate">Op. LAGUS</p>
                            <p class="text-[7px] opacity-80 truncate">RJ</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-cyan/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('OP-RAFAEL')" data-id="OP-RAFAEL" data-name="Rafael" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="DF">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[8px] truncate">Op. RAFAEL</p>
                            <p class="text-[7px] opacity-80 truncate">DF</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- ================= COLUNA 2: ÁREAS DE APOIO ================= -->
        <div class="bg-slate-100 p-3 rounded-lg border border-slate-300 shadow-sm flex flex-col gap-3">
            <div class="bg-slate-800 text-white font-bold text-center py-1 rounded text-xs uppercase tracking-wide">
                Áreas de Apoio
            </div>

            <!-- LIDERANÇA APOIO -->
            <div class="grid grid-cols-3 gap-1 text-[10px] text-center font-bold text-white">
                <div class="bg-lte-orange p-1 rounded">DIREÇÃO (THIAGO)</div>
                <div class="bg-lte-cyan p-1 rounded">SUPERINT. (ARTHUR)</div>
                <div class="bg-lte-purple p-1 rounded">SUPERINT. (CAPUANO)</div>
            </div>

            <!-- SETORES DE APOIO: LABOR, LICENC, RIC, MANUT POÇOS -->
            <div class="grid grid-cols-4 gap-2">
                <!-- LABOR -->
                <div class="space-y-1">
                    <div class="bg-lte-orange text-white text-[9px] font-bold p-0.5 rounded text-center">LABOR</div>
                    <div class="node-card bg-lte-orange text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('GER-RICARDO')" data-id="GER-RICARDO" data-name="Ricardo" data-role="Gerência Labor" data-sector="apoio" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-orange" data-area-atuacao="Laboratório">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <span class="text-[7.5px] font-bold block text-orange-200 uppercase">GERÊNCIA</span>
                            <p class="font-bold text-[9px] truncate">RICARDO</p>
                        </div>
                    </div>
                </div>

                <!-- LICENC -->
                <div class="space-y-1">
                    <div class="bg-lte-orange text-white text-[9px] font-bold p-0.5 rounded text-center">LICENC</div>
                    <div class="node-card bg-lte-orange text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('GER-MARILIA')" data-id="GER-MARILIA" data-name="Marília" data-role="Gerência Licenc" data-sector="apoio" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-orange" data-area-atuacao="Licenciamento">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <span class="text-[7.5px] font-bold block text-orange-200 uppercase">GERÊNCIA</span>
                            <p class="font-bold text-[9px] truncate">MARÍLIA</p>
                            <p class="text-[7px] text-orange-100 truncate">Coord. Gabriel</p>
                        </div>
                    </div>
                </div>

                <!-- RIC -->
                <div class="space-y-1">
                    <div class="bg-lte-orange text-white text-[9px] font-bold p-0.5 rounded text-center">RIC</div>
                    <div class="node-card bg-lte-orange text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('GER-RIC')" data-id="GER-RIC" data-name="Sergio / Diogo / Neves" data-role="Gerência RIC" data-sector="apoio" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-orange" data-area-atuacao="RIC Corporativo">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <span class="text-[7.5px] font-bold block text-orange-200 uppercase">GERÊNCIA</span>
                            <p class="font-bold text-[8px] leading-tight truncate">SERGIO / DIOGO / NEVES</p>
                        </div>
                    </div>
                </div>

                <!-- MANUT. POÇOS -->
                <div class="space-y-1">
                    <div class="bg-lte-navy text-white text-[9px] font-bold p-0.5 rounded text-center">MANUT. POÇOS</div>
                    <div class="node-card bg-lte-navy text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('GER-PEDRO-ALC')" data-id="GER-PEDRO-ALC" data-name="Pedro Alcântara" data-role="Gerência Poços" data-sector="apoio" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-navy" data-area-atuacao="Manutenção Poços">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <span class="text-[7.5px] font-bold block text-slate-300 uppercase">GERÊNCIA</span>
                            <p class="font-bold text-[9px] truncate">PEDRO ALC.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MANUTENÇÃO + LODO, CCO E ENGENHARIA DE PROCESSOS -->
            <div class="grid grid-cols-3 gap-2">

                <!-- MANUTENÇÃO + LODO -->
                <div class="bg-blue-50 border border-blue-200 p-1.5 rounded space-y-1">
                    <div class="bg-lte-navy text-white text-[9px] font-bold p-0.5 rounded text-center">MANUTENÇÃO + LODO</div>
                    
                    <div class="node-card bg-lte-navy text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('GER-CARLOS')" data-id="GER-CARLOS" data-name="Carlos" data-role="Gerência Manut." data-sector="manutencao" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-navy" data-area-atuacao="Manutenção Industrial + Tratamento Lodo">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[9px] truncate">Gerência CARLOS</p>
                        </div>
                    </div>

                    <div class="space-y-1 pt-1">
                        <div class="node-card bg-lte-navy/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('SUP-DIEGO')" data-id="SUP-DIEGO" data-name="Diego" data-role="Superv. Manut." data-sector="manutencao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-navy/90" data-area-atuacao="Manutenção Industrial">
                            <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                            <p class="font-semibold text-[8px] truncate">Superv. DIEGO</p>
                        </div>

                        <div class="node-card bg-lte-navy/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('SUP-LEONARDO-NE')" data-id="SUP-LEONARDO-NE" data-name="Leonardo" data-role="Superv. Nordeste" data-sector="manutencao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-navy/90" data-area-atuacao="Região Nordeste">
                            <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                            <div class="min-w-0">
                                <p class="font-semibold text-[8px] truncate">Superv. LEONARDO</p>
                                <p class="text-[7px] text-cyan-300 font-bold truncate">NORDESTE</p>
                            </div>
                        </div>

                        <div class="node-card bg-lte-navy/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('SUP-NELSON')" data-id="SUP-NELSON" data-name="Nelson" data-role="Superv. PCM" data-sector="manutencao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-navy/90" data-area-atuacao="Planejamento e Controle Manutenção">
                            <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                            <p class="font-semibold text-[8px] truncate">PCM NELSON</p>
                        </div>

                        <div class="node-card bg-lte-navy/90 text-white p-1 rounded flex items-center gap-1" onclick="openCardModal('SUP-OSIAS')" data-id="SUP-OSIAS" data-name="Osias" data-role="Superv. Lodo" data-sector="manutencao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-navy/90" data-area-atuacao="Tratamento de Lodo">
                            <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                            <p class="font-semibold text-[8px] truncate">Lodo OSIAS</p>
                        </div>
                    </div>
                </div>

                <!-- CCO -->
                <div class="bg-blue-50 border border-blue-200 p-1.5 rounded space-y-1">
                    <div class="bg-lte-cyan text-white text-[9px] font-bold p-0.5 rounded text-center">CCO</div>
                    
                    <div class="node-card bg-lte-cyan text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('COO-ANDRE-CCO')" data-id="COO-ANDRE-CCO" data-name="André" data-role="Coordenação CCO" data-sector="apoio" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-cyan" data-area-atuacao="Central Operações">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[8.5px] truncate">Coord. ANDRÉ</p>
                            <p class="text-[7.5px] opacity-80 truncate">Central Operações</p>
                        </div>
                    </div>
                </div>

                <!-- ENGENHARIA DE PROCESSOS -->
                <div class="bg-purple-50 border border-purple-200 p-1.5 rounded space-y-1">
                    <div class="bg-lte-purple-dark text-white text-[9px] font-bold p-0.5 rounded text-center">ENG PROC</div>
                    
                    <div class="node-card bg-lte-purple-dark text-white p-1.5 rounded flex items-center gap-1.5" onclick="openCardModal('ENG-BEATRIZ')" data-id="ENG-BEATRIZ" data-name="Beatriz" data-role="Engenharia" data-sector="apoio" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple-dark" data-area-atuacao="Engenharia de Processos">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[8.5px] truncate">Engª BEATRIZ</p>
                        </div>
                    </div>

                    <div class="node-card bg-lte-purple-dark/80 text-white p-1 rounded flex items-center gap-1.5" onclick="openCardModal('ENG-TRAINEE')" data-id="ENG-TRAINEE" data-name="Trainee" data-role="Eng. Trainee" data-sector="apoio" data-nivel="trainee" data-label-nivel="Trainee" data-cor-nivel="bg-lte-purple-dark/80" data-area-atuacao="Engenharia de Processos">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-semibold text-[8px] truncate">ENGª TRAINEE</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection


