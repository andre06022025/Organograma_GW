@extends('layouts.app')

@section('title', 'Organograma Corporativo - General Water')

@section('organograma-content')
    <div class="w-full flex flex-col gap-4">

        {{-- ================= NÍVEL 1: DIREÇÃO (FULL WIDTH) ================= --}}
        @if($raiz)
            @include('organograma.partials._card', [
                'colaborador' => $raiz,
                'grande' => true,
                'fixo' => true,
            ])

            <p class="text-[11px] text-center text-slate-500 dark:text-slate-400 -mt-2">
                {{ $estatisticas['total'] }} colaboradores ativos
            </p>
        @endif

        {{-- Linha conectora --}}
        <div class="w-0.5 h-4 bg-slate-400 dark:bg-slate-600 mx-auto -my-1"></div>

        {{-- ================= COLUNAS POR ÁREA ================= --}}
        <div class="flex flex-col xl:flex-row gap-4 w-full items-stretch">
            @include('organograma.partials._coluna', [
                'coluna' => $colunas['producao'],
                'classe' => 'xl:flex-[3]',
                'cor' => 'from-lte-purple to-lte-cyan',
            ])

            @include('organograma.partials._coluna', [
                'coluna' => $colunas['apoio'],
                'classe' => 'xl:flex-[2]',
                'cor' => 'from-lte-cyan to-lte-blue',
                'grid' => 'md:grid-cols-2',
            ])
        </div>
    </div>
@endsection
