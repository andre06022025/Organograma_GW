@php
    $grande = $grande ?? false;
    $fixo = $fixo ?? false;
    $areaCard = $areaForcada ?? ($colaborador->area ?: 'producao');
    $grupo = $colaborador->grupo;
@endphp

<div class="node-card {{ $colaborador->cor_nivel }} text-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer select-none
            focus:outline-none focus:ring-2 focus:ring-white/70
            {{ $grande ? 'p-3 gap-3' : 'p-2 gap-2' }} flex items-center"
     role="button"
     tabindex="0"
     onclick="openCardModal({{ $colaborador->id }})"
     onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardModal({{ $colaborador->id }});}"
     data-id="{{ $colaborador->id }}"
     data-nome="{{ $colaborador->nome_completo }}"
     data-cargo="{{ $colaborador->cargo }}"
     data-nivel="{{ $colaborador->nivel }}"
     data-label-nivel="{{ $colaborador->nivel_label }}"
     data-cor-nivel="{{ $colaborador->cor_nivel }}"
     data-sector="{{ $areaCard }}"
     data-setor="{{ $colaborador->setor }}"
     data-gestor="{{ $colaborador->gestor?->nome_completo }}"
     data-fixo="{{ $fixo ? 'true' : 'false' }}"
     data-grupo="{{ $grupo ? 'true' : 'false' }}"
     data-grupo-nome="{{ $grupo?->nome }}"
     data-grupo-numero="{{ $grupo?->numero }}">

    {{-- Avatar --}}
    <div class="{{ $grande ? 'w-10 h-10' : 'w-7 h-7' }} rounded-full bg-white/20 flex items-center justify-center shrink-0 overflow-hidden">
        @if($colaborador->foto_path)
            <img src="{{ $colaborador->foto_url }}" alt="{{ $colaborador->nome_completo }}"
                 class="w-full h-full object-cover">
        @else
            <svg class="{{ $grande ? 'w-6 h-6' : 'w-4 h-4' }} text-white/80" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
        @endif
    </div>

    {{-- Dados --}}
    <div class="min-w-0 flex-1">
        <span class="block font-bold uppercase tracking-wide opacity-80 truncate {{ $grande ? 'text-[10px]' : 'text-[8px]' }}">
            {{ $colaborador->nivel_label }}
        </span>
        <p class="font-bold leading-tight truncate {{ $grande ? 'text-base' : 'text-[11px]' }}">
            {{ $colaborador->nome_completo }}
        </p>
        <p class="opacity-80 truncate {{ $grande ? 'text-[11px]' : 'text-[9px]' }}">
            {{ $colaborador->cargo }}
        </p>
        @if($grande && $grupo)
            <p class="opacity-70 truncate text-[10px] mt-0.5">
                Grupo: {{ $grupo->nome }} ({{ $grupo->numero }})
            </p>
        @endif
    </div>

    @if(!empty($badge))
        <span class="shrink-0 text-[8px] font-bold uppercase bg-black/20 px-1.5 py-0.5 rounded">
            {{ $badge }}
        </span>
    @endif
</div>
