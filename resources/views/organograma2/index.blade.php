@extends('layouts.app')

@section('title', 'Organograma 2 - General Water')

@section('css')
<style>
    .tree {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
    }

    .tree-node {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tree-card {
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        cursor: pointer;
    }

    .tree-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18);
    }

    .dark .tree-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35);
    }

    .tree-children {
        display: flex;
        justify-content: center;
        gap: 1.25rem;
        position: relative;
        padding-top: 2.25rem;
        margin-top: 0.25rem;
    }

    /* Linha vertical que desce do card pai até a barra horizontal */
    .tree-children::before {
        content: '';
        position: absolute;
        top: -1.25rem;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 1.25rem;
        background: #94a3b8;
    }

    /* Barra horizontal que conecta os filhos */
    .tree-children::after {
        content: '';
        position: absolute;
        top: 1rem;
        left: 1.25rem;
        right: 1.25rem;
        height: 2px;
        background: #94a3b8;
    }

    .dark .tree-children::before,
    .dark .tree-children::after,
    .dark .tree-child::before {
        background: #64748b;
    }

    /* Linha vertical que desce da barra até o card filho */
    .tree-child {
        position: relative;
        padding-top: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tree-child::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 1.5rem;
        background: #94a3b8;
    }

    /* Quando há apenas um filho, esconde a barra horizontal */
    .tree-children:has(> .tree-child:only-child)::after {
        display: none;
    }

    .tree-children:has(> .tree-child:only-child)::before {
        height: 2.5rem;
    }

    .tree-children:has(> .tree-child:only-child) > .tree-child::before {
        height: 2.5rem;
    }
</style>
@endsection

@section('organograma-content')
    <div class="w-full min-w-[1200px] flex flex-col items-center gap-6">

        @if(empty($arvore))
            <p class="text-[11px] text-slate-500 dark:text-slate-400 py-6">
                Nenhum colaborador cadastrado.
            </p>
        @else
            @foreach($arvore as $raiz)
                @include('organograma2.partials._tree', ['node' => $raiz])
            @endforeach
        @endif
    </div>
@endsection
