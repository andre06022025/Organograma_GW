@extends('layouts.app')

@section('title', 'Organograma Corporativo - General Water')

@section('organograma-content')
    <!-- ================= NÍVEL 1: DIREÇÃO (FULL WIDTH) ================= -->
    <div class="w-full px-2">
        <div class="node-card bg-lte-orange text-white rounded-lg shadow-lg border-b-4 border-lte-orange-dark py-2 px-4 flex items-center justify-between w-full"
             onclick="openCardModal('DIR-THIAGO')" 
             data-id="DIR-THIAGO" 
             data-name="Thiago" 
             data-role="Direção Geral" 
             data-sector="direcao" 
             data-nivel="direcao" 
             data-label-nivel="Nível Executivo" 
             data-cor-nivel="bg-lte-orange" 
             data-area-atuacao="Supervisão Geral do Grupo"
             data-grupo="true"
             data-grupo-nome="Administrativo"
             data-grupo-numero="005">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                <div class="flex-1 min-w-0">
                    <span class="bg-black/20 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Nível Executivo</span>
                    <h2 class="font-bold text-lg leading-tight">DIREÇÃO GERAL - THIAGO</h2>
                    <p class="text-[11px] text-orange-100">Supervisão Geral do Grupo</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-white/80">
                <span class="text-xs font-medium">Grupo: Administrativo (005)</span>
                <i class="fa-solid fa-chevron-down text-lg"></i>
            </div>
        </div>
    </div>

    <!-- LINHA CONECTORA CENTRAL -->
    <div class="w-0.5 h-3 bg-slate-400 mx-auto"></div>

    <!-- ================= DIVISÃO EM DUAS COLUNAS PRINCIPAIS ================= -->
    <div class="grid grid-cols-2 gap-6 w-full max-w-[1600px] items-start">

        <!-- ================= COLUNA 1: ÁREAS DE PRODUÇÃO ================= -->
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-4 h-full min-h-[calc(100vh-200px)]">
            <!-- Header da coluna -->
            <div class="bg-gradient-to-r from-lte-purple to-lte-cyan text-white font-bold text-center py-2 rounded-lg text-sm uppercase tracking-wider shadow-md">
                <i class="fa-solid fa-industry mr-2"></i> Áreas de Produção
            </div>

            <!-- NÍVEL 2: SUPERINTENDÊNCIAS - Grid 2 colunas igual -->
            <div class="grid grid-cols-2 gap-3">
                <div class="node-card bg-gradient-to-br from-lte-purple to-lte-purple-dark text-white p-3 rounded-lg flex items-center gap-3 shadow-lg hover:shadow-xl transition-shadow"
                     onclick="openCardModal('SUP-RENATO')" 
                     data-id="SUP-RENATO" data-name="Renato Capuano" data-role="Superintendência" data-sector="producao" data-nivel="superintendencia" data-label-nivel="Superintendência" data-cor-nivel="bg-lte-purple" data-area-atuacao="Sistemas 1 a 6"
                     data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] opacity-90 block font-semibold uppercase tracking-wide">SUPERINTENDÊNCIA</span>
                        <h3 class="font-bold text-sm truncate">RENATO CAPUANO</h3>
                        <p class="text-[10px] opacity-80 mt-0.5">Sistemas 1 a 6</p>
                    </div>
                </div>

                <div class="node-card bg-gradient-to-br from-lte-cyan to-lte-blue text-white p-3 rounded-lg flex items-center gap-3 shadow-lg hover:shadow-xl transition-shadow"
                     onclick="openCardModal('SUP-ARTHUR')" 
                     data-id="SUP-ARTHUR" data-name="Arthur" data-role="Superintendência" data-sector="producao" data-nivel="superintendencia" data-label-nivel="Superintendência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="Sistemas 7 a 9"
                     data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] opacity-90 block font-semibold uppercase tracking-wide">SUPERINTENDÊNCIA</span>
                        <h3 class="font-bold text-sm truncate">ARTHUR</h3>
                        <p class="text-[10px] opacity-80 mt-0.5">Sistemas 7 a 9</p>
                    </div>
                </div>
            </div>

            <!-- NÍVEL 3: GERÊNCIA CORPORATIVA - Centralizada -->
            <div class="flex justify-center">
                <div class="node-card bg-gradient-to-br from-lte-purple to-lte-purple-dark text-white px-6 py-3 rounded-lg flex items-center gap-3 shadow-lg w-full max-w-md"
                     onclick="openCardModal('GER-NEVES')" 
                     data-id="GER-NEVES" data-name="Neves" data-role="Gerência Corporativa" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência Corporativa" data-cor-nivel="bg-lte-purple" data-area-atuacao="Transversal a todas as áreas"
                     data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    </div>
                    <div class="text-left min-w-0">
                        <span class="text-[9px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded block w-max">Gerência Corporativa</span>
                        <h4 class="font-bold text-base mt-1">NEVES</h4>
                        <p class="text-[10px] opacity-80 mt-0.5">Transversal a todas as áreas</p>
                    </div>
                </div>
            </div>

            <!-- DIVISOR -->
            <div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent my-2"></div>

            <!-- NÍVEL 4: COORDENAÇÕES (SISTEMAS 1-6) - Grid responsivo 3 colunas -->
            <div class="space-y-3">
                <div class="text-xs font-bold text-lte-purple uppercase tracking-wide flex items-center gap-1">
                    <i class="fa-solid fa-server text-lte-purple"></i>
                    <span>Coordenações de Sistemas (RMSP)</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <!-- Sistemas 1 -->
                    <div class="bg-white border border-purple-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-lte-purple text-white text-[10px] font-bold px-2 py-1 rounded text-center mb-2">SISTEMAS 1</div>
                        <div class="space-y-2">
                            <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('COO-FREDDY')" data-id="COO-FREDDY" data-name="Freddy" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Rotas + RMSP" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                <div class="min-w-0">
                                    <p class="font-bold text-[11px] truncate">Coord. FREDDY</p>
                                    <p class="text-[9px] opacity-80 truncate">Rotas + RMSP</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-DENIS')" data-id="SUP-DENIS" data-name="Denis" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Integrados + Rota 3" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 1 DENIS</p>
                                        <p class="text-[8px] opacity-80 truncate">Integ. Rota 3</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/80 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-PAULO')" data-id="SUP-PAULO" data-name="Paulo" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Integrados + Rota 2" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 2 PAULO</p>
                                        <p class="text-[8px] opacity-80 truncate">Integ. Rota 2</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sistemas 2 -->
                    <div class="bg-white border border-purple-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-lte-purple text-white text-[10px] font-bold px-2 py-1 rounded text-center mb-2">SISTEMAS 2</div>
                        <div class="space-y-2">
                            <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('COO-LEONARDO')" data-id="COO-LEONARDO" data-name="Leonardo M." data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Rotas + RMSP (ABC)" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                <div class="min-w-0">
                                    <p class="font-bold text-[11px] truncate">Coord. LEONARDO</p>
                                    <p class="text-[9px] opacity-80 truncate">Rotas + RMSP</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-VAGNER')" data-id="SUP-VAGNER" data-name="Vagner" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="RMSP (ABC)" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 1 VAGNER</p>
                                        <p class="text-[8px] opacity-80 truncate">RMSP (ABC)</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/80 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-ERIC')" data-id="SUP-ERIC" data-name="Eric" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Rota Paulista" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 2 ERIC</p>
                                        <p class="text-[8px] opacity-80 truncate">Rota Paulista</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sistemas 3+4 -->
                    <div class="bg-white border border-purple-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-lte-purple text-white text-[10px] font-bold px-2 py-1 rounded text-center mb-2">SISTEMAS 3+4</div>
                        <div class="space-y-2">
                            <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('COO-VILELA')" data-id="COO-VILELA" data-name="Vilela + Wellington" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Interior SP / CFO" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                <div class="min-w-0">
                                    <p class="font-bold text-[11px] truncate">VILELA + WELLINGTON</p>
                                    <p class="text-[9px] opacity-80 truncate">Interior SP / CFO</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-JULIO')" data-id="SUP-JULIO" data-name="Julio" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Campinas+SJRP" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 1 JULIO</p>
                                        <p class="text-[8px] opacity-80 truncate">Campinas+SJRP</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/85 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('OP-LUCAS')" data-id="OP-LUCAS" data-name="Lucas" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-purple/85" data-area-atuacao="Bragança+Jundiaí" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Op. Líder LUCAS</p>
                                        <p class="text-[8px] opacity-80 truncate">Bragança+Jundiaí</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/80 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-ALAN')" data-id="SUP-ALAN" data-name="Alan" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="CFO + Campinas" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 2 ALAN</p>
                                        <p class="text-[8px] opacity-80 truncate">CFO + Campinas</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/75 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-JOAO')" data-id="SUP-JOAO" data-name="João" data-role="Supervisão 3" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/75" data-area-atuacao="Interior SP/Rota" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 3 JOÃO</p>
                                        <p class="text-[8px] opacity-80 truncate">Interior SP/Rota</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NÍVEL 4: COORDENAÇÕES (SISTEMAS 5-6) - Grid responsivo 2 colunas -->
            <div class="space-y-3 pt-2 border-t border-slate-200">
                <div class="text-xs font-bold text-lte-purple uppercase tracking-wide flex items-center gap-1">
                    <i class="fa-solid fa-server text-lte-purple"></i>
                    <span>Coordenações de Sistemas (RMSP - Continuação)</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Sistemas 5 -->
                    <div class="bg-white border border-purple-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-lte-purple text-white text-[10px] font-bold px-2 py-1 rounded text-center mb-2">SISTEMAS 5</div>
                        <div class="space-y-2">
                            <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('COO-ANDRE')" data-id="COO-ANDRE" data-name="André" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Integ. RMSP" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                <div class="min-w-0">
                                    <p class="font-bold text-[11px] truncate">Coord. ANDRÉ</p>
                                    <p class="text-[9px] opacity-80 truncate">Integ. RMSP</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-ANFRISIO')" data-id="SUP-ANFRISIO" data-name="Anfrísio" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Integ. ZL + Sh D" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 1 ANFRÍSIO</p>
                                        <p class="text-[8px] opacity-80 truncate">Integ. ZL + Sh D</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/80 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-EVERTON')" data-id="SUP-EVERTON" data-name="Everton" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Rota 1 + Expo" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 2 EVERTON</p>
                                        <p class="text-[8px] opacity-80 truncate">Rota 1 + Expo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sistemas 6 -->
                    <div class="bg-white border border-purple-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-lte-purple text-white text-[10px] font-bold px-2 py-1 rounded text-center mb-2">SISTEMAS 6</div>
                        <div class="space-y-2">
                            <div class="node-card bg-lte-purple text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('COO-RODRIGO')" data-id="COO-RODRIGO" data-name="Rodrigo" data-role="Coordenação" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-purple" data-area-atuacao="Integ. RMSP" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                <div class="min-w-0">
                                    <p class="font-bold text-[11px] truncate">Coord. RODRIGO</p>
                                    <p class="text-[9px] opacity-80 truncate">Integ. RMSP</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="node-card bg-lte-purple/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-VANDERSO')" data-id="SUP-VANDERSO" data-name="Vanderso" data-role="Supervisão 1" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/90" data-area-atuacao="Castelo + Granja" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 1 VANDERSO</p>
                                        <p class="text-[8px] opacity-80 truncate">Castelo + Granja</p>
                                    </div>
                                </div>
                                <div class="node-card bg-lte-purple/80 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('SUP-CESAR')" data-id="SUP-CESAR" data-name="Cesar" data-role="Supervisão 2" data-sector="producao" data-nivel="supervisao" data-label-nivel="Supervisão" data-cor-nivel="bg-lte-purple/80" data-area-atuacao="Continental + ZN" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                                    <svg class="w-4 h-4 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[10px] truncate">Superv. 2 CESAR</p>
                                        <p class="text-[8px] opacity-80 truncate">Continental + ZN</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NÍVEL 4: SISTEMAS 7,8,9 (GERÊNCIAS REGIONAIS) -->
            <div class="space-y-3 pt-2 border-t border-slate-200">
                <div class="text-xs font-bold text-lte-cyan uppercase tracking-wide flex items-center gap-1">
                    <i class="fa-solid fa-globe-americas text-lte-cyan"></i>
                    <span>Gerências Regionais (Sistemas 7, 8, 9)</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="node-card bg-gradient-to-br from-lte-cyan to-lte-blue text-white p-3 rounded-lg flex items-center gap-3 shadow-md hover:shadow-lg transition-shadow" onclick="openCardModal('GER-SERGIO')" data-id="GER-SERGIO" data-name="Sergio Luiz" data-role="Gerência S7" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="Bahia" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-sm truncate">Ger. SERGIO LUIZ</p>
                            <p class="text-[10px] opacity-90 truncate">Bahia - Sistema 7</p>
                        </div>
                    </div>
                    <div class="node-card bg-gradient-to-br from-lte-cyan to-lte-blue text-white p-3 rounded-lg flex items-center gap-3 shadow-md hover:shadow-lg transition-shadow" onclick="openCardModal('COO-PEDRO')" data-id="COO-PEDRO" data-name="Pedro" data-role="Coord. S8" data-sector="producao" data-nivel="coordenacao" data-label-nivel="Coordenação" data-cor-nivel="bg-lte-cyan" data-area-atuacao="RMSP + RJ" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-sm truncate">Coord. PEDRO</p>
                            <p class="text-[10px] opacity-90 truncate">RMSP + RJ - Sistema 8</p>
                        </div>
                    </div>
                    <div class="node-card bg-gradient-to-br from-lte-cyan to-lte-blue text-white p-3 rounded-lg flex items-center gap-3 shadow-md hover:shadow-lg transition-shadow" onclick="openCardModal('GER-DIOGO')" data-id="GER-DIOGO" data-name="Diogo" data-role="Gerência S9" data-sector="producao" data-nivel="gerencia" data-label-nivel="Gerência" data-cor-nivel="bg-lte-cyan" data-area-atuacao="DF" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-sm truncate">Ger. DIOGO</p>
                            <p class="text-[10px] opacity-90 truncate">DF - Sistema 9</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GESTÃO OPERACIONAL E LÍDERES REGIONAIS -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-lg p-3 space-y-3 pt-2 border-t border-slate-200">
                <div class="text-xs font-bold text-lte-cyan uppercase tracking-wide flex items-center gap-1">
                    <i class="fa-solid fa-users-cog text-lte-cyan"></i>
                    <span>Gestão Operacional & Líderes Regionais</span>
                </div>
                <div class="node-card bg-gradient-to-br from-lte-cyan to-lte-blue text-white p-3 rounded-lg flex items-center gap-3 shadow-md" onclick="openCardModal('GOP-ANA')" data-id="GOP-ANA" data-name="Ana Luiza" data-role="Gestão Op." data-sector="producao" data-nivel="gerencia" data-label-nivel="Gestão Op." data-cor-nivel="bg-lte-cyan" data-area-atuacao="Integ. RMSP (Pinheiros) / DF / Bahia" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                    <svg class="w-6 h-6 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                    <div class="text-left min-w-0">
                        <span class="text-[9px] uppercase font-bold bg-white/20 px-2 py-0.5 rounded block w-max">Gestão Operacional</span>
                        <h4 class="font-bold text-sm mt-1">ANA LUIZA</h4>
                        <p class="text-[10px] opacity-90 mt-0.5">Integ. RMSP (Pinheiros) / DF / Bahia</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <div class="node-card bg-lte-cyan/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('OP-DEIVISON')" data-id="OP-DEIVISON" data-name="Deivison" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="Bahia" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[10px] truncate">Op. DEIVISON</p>
                            <p class="text-[8px] opacity-80 truncate">Bahia</p>
                        </div>
                    </div>
                    <div class="node-card bg-lte-cyan/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('OP-LAGUS')" data-id="OP-LAGUS" data-name="Lagus" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="RJ" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[10px] truncate">Op. LAGUS</p>
                            <p class="text-[8px] opacity-80 truncate">RJ</p>
                        </div>
                    </div>
                    <div class="node-card bg-lte-cyan/90 text-white p-2 rounded flex items-center gap-2" onclick="openCardModal('OP-RAFAEL')" data-id="OP-RAFAEL" data-name="Rafael" data-role="Op. Líder" data-sector="producao" data-nivel="operador_lider" data-label-nivel="Operador Líder" data-cor-nivel="bg-lte-cyan/90" data-area-atuacao="DF" data-grupo="true" data-grupo-nome="TI" data-grupo-numero="001">
                        <svg class="w-5 h-5 text-white/70 shrink-0" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                        <div class="min-w-0">
                            <p class="font-bold text-[10px] truncate">Op. RAFAEL</p>
                            <p class="text-[8px] opacity-80 truncate">DF</p>
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


