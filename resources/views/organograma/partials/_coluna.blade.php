@php
    $cor = $cor ?? 'from-lte-purple to-lte-cyan';
    $classe = $classe ?? 'flex-1';
    $grid = $grid ?? 'md:grid-cols-2 2xl:grid-cols-3';
@endphp

<section class="js-coluna {{ $classe }} bg-slate-100 dark:bg-slate-800/40 p-3 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm flex flex-col gap-3">
    <header class="bg-gradient-to-r {{ $cor }} text-white font-bold text-center py-1.5 rounded-lg text-xs uppercase tracking-wider shadow-sm">
        {{ $coluna['titulo'] }}
    </header>

    {{-- Superintendências --}}
    @if($coluna['superintendencias']->isNotEmpty())
        <div class="js-filtravel grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach($coluna['superintendencias'] as $colaborador)
                @include('organograma.partials._card', [
                    'colaborador' => $colaborador,
                    'grande' => true,
                ])
            @endforeach
        </div>
    @endif

    {{-- Destaques transversais (Gerência Corporativa) --}}
    @foreach($coluna['destaques'] as $colaborador)
        @include('organograma.partials._card', [
            'colaborador' => $colaborador,
            'grande' => true,
            'badge' => 'Transversal',
        ])
    @endforeach

    {{-- Blocos por setor/sistema --}}
    @if(!empty($coluna['grupos']))
        <div class="grid grid-cols-1 {{ $grid }} gap-2.5">
            @foreach($coluna['grupos'] as $grupo)
                @include('organograma.partials._grupo', $grupo)
            @endforeach
        </div>
    @endif

    @if($coluna['superintendencias']->isEmpty() && $coluna['destaques']->isEmpty() && empty($coluna['grupos']))
        <p class="text-center text-[11px] text-slate-500 dark:text-slate-400 py-6">
            Nenhum colaborador cadastrado nesta área.
        </p>
    @endif
</section>
