@php
    // Configurações por nível
    $levelConfig = [
        0 => ['containerClass' => 'w-full max-w-6xl', 'cardClass' => 'w-72', 'avatarClass' => 'avatar-xl', 'titleClass' => 'text-sm', 'gap' => 'gap-6'],
        1 => ['containerClass' => 'grid grid-cols-2 gap-3', 'cardClass' => '', 'avatarClass' => 'avatar-md', 'titleClass' => 'text-xs', 'gap' => 'gap-3'],
        2 => ['containerClass' => 'grid grid-cols-2 gap-2', 'cardClass' => '', 'avatarClass' => 'avatar-sm', 'titleClass' => 'text-[10px]', 'gap' => 'gap-2'],
        3 => ['containerClass' => 'grid grid-cols-3 gap-1.5', 'cardClass' => '', 'avatarClass' => 'avatar-sm', 'titleClass' => 'text-[9px]', 'gap' => 'gap-1.5'],
        4 => ['containerClass' => 'grid grid-cols-4 gap-1', 'cardClass' => '', 'avatarClass' => 'avatar-sm', 'titleClass' => 'text-[9px]', 'gap' => 'gap-1'],
        5 => ['containerClass' => 'grid grid-cols-3 gap-1', 'cardClass' => '', 'avatarClass' => 'avatar-sm', 'titleClass' => 'text-[8px]', 'gap' => 'gap-1'],
    ];
    
    $config = $levelConfig[$level] ?? $levelConfig[5];
    // Garantir que $nodes seja Collection
    $nodesCollection = $nodes instanceof \Illuminate\Support\Collection ? $nodes : collect($nodes);
@endphp

@if(!$nodesCollection->isEmpty())
    @if($level === 0)
        <!-- NÍVEL 0: DIREÇÃO - Centralizado -->
        <div class="{{ $config['containerClass'] }} flex justify-center mb-4">
            @foreach($nodesCollection as $node)
                @include('organograma._card', ['node' => $node, 'config' => $config, 'level' => $level])
            @endforeach
        </div>
        
        <!-- Linha conector vertical -->
        <div class="w-px h-4 bg-gray-400 mx-auto mb-4"></div>
    @elseif($level === 1)
        <!-- NÍVEL 1: SUPERINTENDÊNCIAS - 2 colunas -->
        <div class="{{ $config['containerClass'] }} w-full max-w-6xl mb-4">
            @foreach($nodesCollection as $node)
                @include('organograma._card', ['node' => $node, 'config' => $config, 'level' => $level])
            @endforeach
        </div>
        
        <!-- Linha conector vertical -->
        <div class="w-px h-3 bg-gray-400 mx-auto mb-3"></div>
    @else
        <!-- NÍVEIS 2+: Grid responsivo -->
        <div class="{{ $config['containerClass'] }} w-full mb-3">
            @foreach($nodesCollection as $node)
                @include('organograma._card', ['node' => $node, 'config' => $config, 'level' => $level])
            @endforeach
        </div>
    @endif
    
    <!-- Renderizar filhos recursivamente -->
    @foreach($nodesCollection as $node)
        @if(!empty($node['children']))
            <div class="w-full mt-2">
                @include('organograma._tree', ['nodes' => collect($node['children']), 'level' => $level + 1])
            </div>
        @endif
    @endforeach
@endif