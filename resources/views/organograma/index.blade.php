@extends('layouts.app')

@section('title', 'Organograma Corporativo - General Water')

@section('organograma-content')
    @if(session('success'))
        <div id="flashSuccess" class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-emerald-600 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function () {
                var el = document.getElementById('flashSuccess');
                if (el) el.remove();
            }, 4000);
        </script>
    @endif

    @php
        $roxo = 'bg-lte-purple';
        $azul = 'bg-lte-steel';
        $laranja = 'bg-lte-ambar';
    @endphp

    <div class="w-full min-w-[1320px] flex flex-col gap-1">

        {{-- ================= DIREÇÃO (FULL WIDTH) ================= --}}
        @include('organograma.partials._cell', [
            'colaborador' => $m['thiago@empresa.com.br'] ?? null,
            'cor' => $laranja,
            'barra' => true,
            'texto' => 'DIREÇÃO (' . strtoupper($m['thiago@empresa.com.br']->nome_completo ?? 'THIAGO') . ')',
            'fixo' => true,
        ])

        <div class="flex items-stretch gap-2">

            {{-- ================= ÁREAS DE PRODUÇÃO ================= --}}
            <div class="js-area flex-[1.33] basis-0 min-w-0" data-area="producao">
                <div class="text-center text-[clamp(11px,0.85vw,16px)] font-bold uppercase tracking-wide text-slate-700 dark:text-slate-200 mb-1">
                    Áreas de Produção
                </div>
                <div class="grid gap-[clamp(2px,0.18vw,4px)]"
                     style="grid-template-columns: 0.8fr 1.15fr 1.15fr 1.15fr 0.9fr 0.9fr 0.75fr 0.75fr 0.75fr;">

                    {{-- Linha 1: Superintendências --}}
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['renato.capuano@empresa.com.br'] ?? null,
                        'cor' => $roxo,
                        'barra' => true,
                        'texto' => 'SUPERINTENDÊNCIA (' . strtoupper($m['renato.capuano@empresa.com.br']->nome_completo ?? 'RENATO CAPUANO') . ')',
                        'style' => 'grid-column: 1 / span 2; grid-row: 1;',
                    ])
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['arthur@empresa.com.br'] ?? null,
                        'cor' => $azul,
                        'barra' => true,
                        'texto' => 'SUPERINTENDÊNCIA (' . strtoupper($m['arthur@empresa.com.br']->nome_completo ?? 'ARTHUR') . ')',
                        'style' => 'grid-column: 3 / span 4; grid-row: 1;',
                    ])

                    {{-- Linha 2: Gerência Corporativa + título da área --}}
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['neves@empresa.com.br'] ?? null,
                        'cor' => $roxo,
                        'barra' => true,
                        'texto' => 'GER. CORPORATIVA (' . strtoupper($m['neves@empresa.com.br']->nome_completo ?? 'NEVES') . ')',
                        'style' => 'grid-column: 1 / span 2; grid-row: 2;',
                    ])

                    {{-- Linha 3: Cabeçalhos dos sistemas --}}
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 1',   'style' => 'grid-column: 1; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 2',   'style' => 'grid-column: 2; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 3',   'style' => 'grid-column: 3; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 4',   'style' => 'grid-column: 4; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 5',   'style' => 'grid-column: 5; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo, 'barra' => true, 'texto' => 'SISTEMAS 6',   'style' => 'grid-column: 6; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul, 'barra' => true, 'texto' => 'SISTEMAS 7',   'style' => 'grid-column: 7; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul, 'barra' => true, 'texto' => 'SISTEMAS 8',   'style' => 'grid-column: 8; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul, 'barra' => true, 'texto' => 'SISTEMAS 9',   'style' => 'grid-column: 9; grid-row: 3;'])

                    {{-- Linha 4: Coordenações / Gerências --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['freddy@empresa.com.br'] ?? null,      'cor' => $roxo, 'style' => 'grid-column: 1; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['leonardo.m@empresa.com.br'] ?? null,  'cor' => $roxo, 'style' => 'grid-column: 2; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['vilela@empresa.com.br'] ?? null,      'cor' => $roxo, 'style' => 'grid-column: 3; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['wellington@empresa.com.br'] ?? null,  'cor' => $roxo, 'style' => 'grid-column: 4; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['andre.s5@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 5; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['rodrigo@empresa.com.br'] ?? null,     'cor' => $roxo, 'style' => 'grid-column: 6; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['sergio.luiz@empresa.com.br'] ?? null, 'cor' => $azul, 'style' => 'grid-column: 7; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['pedro@empresa.com.br'] ?? null,       'cor' => $azul, 'style' => 'grid-column: 8; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['diogo@empresa.com.br'] ?? null,       'cor' => $azul, 'style' => 'grid-column: 9; grid-row: 4;'])

                    {{-- Linha 5: Supervisão 1 / Gestão Operacional --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['denis@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 1; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['vagner@empresa.com.br'] ?? null,   'cor' => $roxo, 'style' => 'grid-column: 2; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['julio@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 3; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['lucas@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 4; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['anfrisio@empresa.com.br'] ?? null, 'cor' => $roxo, 'style' => 'grid-column: 5; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['vanderso@empresa.com.br'] ?? null, 'cor' => $roxo, 'style' => 'grid-column: 6; grid-row: 5;'])
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['ana.luiza@empresa.com.br'] ?? null,
                        'cor' => $azul,
                        'style' => 'grid-column: 7 / span 3; grid-row: 5;',
                    ])

                    {{-- Linha 6: Supervisão 2 / Operadores Líderes --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['paulo@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 1; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['eric@empresa.com.br'] ?? null,     'cor' => $roxo, 'style' => 'grid-column: 2; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['joao.s34@empresa.com.br'] ?? null, 'cor' => $roxo, 'style' => 'grid-column: 3; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['alan@empresa.com.br'] ?? null,     'cor' => $roxo, 'style' => 'grid-column: 4; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['everton@empresa.com.br'] ?? null,  'cor' => $roxo, 'style' => 'grid-column: 5; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['cesar@empresa.com.br'] ?? null,    'cor' => $roxo, 'style' => 'grid-column: 6; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['deivison@empresa.com.br'] ?? null, 'cor' => $azul, 'style' => 'grid-column: 7; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['lagus@empresa.com.br'] ?? null,    'cor' => $azul, 'style' => 'grid-column: 8; grid-row: 6;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['rafael@empresa.com.br'] ?? null,   'cor' => $azul, 'style' => 'grid-column: 9; grid-row: 6;'])
                </div>
            </div>

            {{-- Divisor central --}}
            <div class="js-divisor w-px self-stretch bg-slate-700 dark:bg-slate-400 mx-1"></div>

            {{-- ================= ÁREAS DE APOIO ================= --}}
            <div class="js-area flex-1 basis-0 min-w-0" data-area="apoio">
                <div class="text-center text-[clamp(11px,0.85vw,16px)] font-bold uppercase tracking-wide text-slate-700 dark:text-slate-200 mb-1">
                    Áreas de Apoio
                </div>
                <div class="grid gap-[clamp(2px,0.18vw,4px)]"
                     style="grid-template-columns: 0.9fr 1fr 0.9fr 0.85fr 1fr 0.9fr 0.75fr;">

                    {{-- Linha 1: Lideranças --}}
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['thiago@empresa.com.br'] ?? null,
                        'cor' => $laranja,
                        'barra' => true,
                        'texto' => 'DIREÇÃO (THIAGO)',
                        'areaForcada' => 'apoio',
                        'style' => 'grid-column: 1 / span 2; grid-row: 1;',
                    ])
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['arthur@empresa.com.br'] ?? null,
                        'cor' => $azul,
                        'barra' => true,
                        'texto' => 'SUPERINTENDÊNCIA (' . strtoupper($m['arthur@empresa.com.br']->nome_completo ?? 'ARTHUR') . ')',
                        'areaForcada' => 'apoio',
                        'style' => 'grid-column: 3 / span 3; grid-row: 1;',
                    ])
                    @include('organograma.partials._cell', [
                        'colaborador' => $m['capuano@empresa.com.br'] ?? null,
                        'cor' => $roxo,
                        'barra' => true,
                        'texto' => 'SUPERINT. (' . strtoupper($m['capuano@empresa.com.br']->nome_completo ?? 'CAPUANO') . ')',
                        'style' => 'grid-column: 6 / span 2; grid-row: 1;',
                    ])

                    {{-- Linha 2: respiro para alinhar com a Gerência Corporativa --}}
                    <div style="grid-column: 1 / span 7; grid-row: 2;"
                         class="min-h-[clamp(26px,2vw,38px)]"></div>

                    {{-- Linha 3: Cabeçalhos --}}
                    @include('organograma.partials._cell', ['cor' => $laranja, 'barra' => true, 'texto' => 'LABOR',              'style' => 'grid-column: 1; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $laranja, 'barra' => true, 'texto' => 'LICENC',             'style' => 'grid-column: 2; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $laranja, 'barra' => true, 'texto' => 'RIC',                'style' => 'grid-column: 3; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul,    'barra' => true, 'texto' => 'MANUT. POÇOS',       'style' => 'grid-column: 4; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul,    'barra' => true, 'texto' => 'MANUTENÇÃO + LODO',  'style' => 'grid-column: 5; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $azul,    'barra' => true, 'texto' => 'CCO',                'style' => 'grid-column: 6; grid-row: 3;'])
                    @include('organograma.partials._cell', ['cor' => $roxo,    'barra' => true, 'texto' => 'ENG PROC',           'style' => 'grid-column: 7; grid-row: 3;'])

                    {{-- Linha 4 --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['ricardo@empresa.com.br'] ?? null,        'cor' => $laranja, 'style' => 'grid-column: 1; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['marilia@empresa.com.br'] ?? null,        'cor' => $laranja, 'style' => 'grid-column: 2; grid-row: 4;'])

                    {{-- RIC: gestão compartilhada em cards separados --}}
                    <div style="grid-column: 3; grid-row: 4;" class="{{ $laranja }} flex flex-col">
                        <div class="text-center text-white text-[clamp(7.5px,0.56vw,10px)] leading-none py-0.5">Gerência</div>
                        @foreach(['sergio.luiz@empresa.com.br', 'diogo@empresa.com.br', 'neves@empresa.com.br'] as $emailRic)
                            @include('organograma.partials._cell', [
                                'colaborador' => $m[$emailRic] ?? null,
                                'corForcada' => $laranja,
                                'compacto' => true,
                                'areaForcada' => 'apoio',
                                'style' => 'border-top: 1px solid rgba(255,255,255,0.35);',
                            ])
                        @endforeach
                    </div>

                    @include('organograma.partials._cell', ['colaborador' => $m['pedro.alcantara@empresa.com.br'] ?? null, 'cor' => $azul, 'style' => 'grid-column: 4; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['carlos@empresa.com.br'] ?? null,          'cor' => $azul, 'style' => 'grid-column: 5; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['andre.cco@empresa.com.br'] ?? null,       'cor' => $azul, 'style' => 'grid-column: 6; grid-row: 4;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['beatriz@empresa.com.br'] ?? null,         'cor' => $roxo, 'style' => 'grid-column: 7; grid-row: 4;'])

                    {{-- Linha 5 --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['gabriel@empresa.com.br'] ?? null,         'cor' => $laranja, 'style' => 'grid-column: 2; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['diego.manut@empresa.com.br'] ?? null,     'cor' => $azul,    'style' => 'grid-column: 5; grid-row: 5;'])
                    @include('organograma.partials._cell', ['colaborador' => $m['trainee.eng@empresa.com.br'] ?? null,     'cor' => $roxo,    'style' => 'grid-column: 7; grid-row: 5;'])

                    {{-- Linha 6 --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['leonardo.ne@empresa.com.br'] ?? null,     'cor' => $azul,    'style' => 'grid-column: 5; grid-row: 6;'])

                    {{-- Linha 7 --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['nelson@empresa.com.br'] ?? null,          'cor' => $azul,    'style' => 'grid-column: 5; grid-row: 7;'])

                    {{-- Linha 8 --}}
                    @include('organograma.partials._cell', ['colaborador' => $m['osias@empresa.com.br'] ?? null,           'cor' => $azul,    'style' => 'grid-column: 5; grid-row: 8;'])
                </div>
            </div>
        </div>
    </div>
@endsection
