@php
    $node = $node ?? [];
    $children = $node['children'] ?? [];
    $cor = $node['cor_nivel'] ?? 'bg-lte-purple';
@endphp

<div class="tree-node">
    <div class="tree-card {{ $cor }} text-white text-center px-2 py-1 min-w-[100px] max-w-[140px]"
         role="button"
         tabindex="0"
         onclick="openCardModal({{ $node['id'] }})"
         onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardModal({{ $node['id'] }});}"
         data-id="{{ $node['id'] }}"
         data-nome="{{ $node['nome'] }}"
         data-cargo="{{ $node['cargo'] }}"
         data-nivel="{{ $node['nivel'] }}"
         data-label-nivel="{{ $node['label_nivel'] }}"
         data-cor-nivel="{{ $cor }}"
         data-sector="{{ $node['area'] ?? 'producao' }}"
         data-setor="{{ $node['setor'] }}"
         data-gestor=""
         data-grupo="{{ $node['grupo'] ? 'true' : 'false' }}"
         data-grupo-nome="{{ $node['grupo']['nome'] ?? '' }}"
         data-grupo-numero="{{ $node['grupo']['numero'] ?? '' }}">

        <div class="flex items-center justify-center mb-0.5">
            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center overflow-hidden">
                @if(!empty($node['tem_foto']))
                    <img src="{{ $node['foto_url'] }}" alt="{{ $node['nome'] }}" class="w-full h-full object-cover">
                @else
                    {{-- Bootstrap Icons: person-fill (placeholder) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white/90" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                @endif
            </div>
        </div>

        <p class="font-bold text-[10px] leading-tight">{{ $node['nome'] }}</p>
        <p class="text-[8px] opacity-90 leading-tight">{{ $node['cargo'] }}</p>
        @if(!empty($node['regiao']))
            <p class="text-[7px] opacity-80 leading-tight mt-0.5">{{ $node['regiao'] }}</p>
        @endif
    </div>

    @if(count($children))
        <div class="tree-children">
            @foreach($children as $filho)
                <div class="tree-child" data-id="{{ $filho['id'] }}" data-draggable="true">
                    @include('organograma2.partials._tree', ['node' => $filho])
                </div>
            @endforeach
        </div>
    @endif
</div>
