@php
    $size = $size ?? 'sm';
    $tamanhos = [
        'xs' => [
            'caixa' => 'w-[12px] h-[12px]',
            'icone' => 'w-[8px] h-[8px]',
        ],
        'sm' => [
            'caixa' => 'w-[clamp(14px,1.15vw,20px)] h-[clamp(14px,1.15vw,20px)]',
            'icone' => 'w-[clamp(9px,0.75vw,13px)] h-[clamp(9px,0.75vw,13px)]',
        ],
        'bar' => [
            'caixa' => 'w-[clamp(14px,1.1vw,18px)] h-[clamp(14px,1.1vw,18px)]',
            'icone' => 'w-[clamp(9px,0.7vw,12px)] h-[clamp(9px,0.7vw,12px)]',
        ],
    ];
    $cfg = $tamanhos[$size] ?? $tamanhos['sm'];
@endphp

<button type="button"
        onclick="event.stopPropagation(); openPhotoModal(this)"
        onkeydown="if(event.key==='Enter'||event.key===' '){event.stopPropagation();}"
        data-id="{{ $colaborador->id }}"
        data-nome="{{ $colaborador->nome_completo }}"
        data-foto="{{ $colaborador->tem_foto ? $colaborador->foto_url : '' }}"
        title="Alterar foto de {{ $colaborador->nome_completo }}"
        class="shrink-0 {{ $cfg['caixa'] }} rounded-full overflow-hidden bg-white/25 flex items-center justify-center hover:ring-2 hover:ring-white/70 focus:outline-none focus:ring-2 focus:ring-white/70">
    @if($colaborador->tem_foto)
        <img src="{{ $colaborador->foto_url }}" alt="{{ $colaborador->nome_completo }}" class="w-full h-full object-cover">
    @else
        {{-- Bootstrap Icons: person-fill (placeholder) --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $cfg['icone'] }} text-white/90" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>
    @endif
</button>
