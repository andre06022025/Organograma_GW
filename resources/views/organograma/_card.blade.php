@php
    $corNivel = $node['cor_nivel'] ?? 'bg-lte-blue';
    $corSuper = $node['cor_superintendencia'] ?? $corNivel;
    $foto = $node['foto_url'] ?? "https://ui-avatars.com/api/?name=" . urlencode($node['nome']) . "&background=" . str_replace('bg-', '', $corNivel) . "&color=fff&size=120";
    $nome = $node['nome'] ?? 'Sem nome';
    $cargo = $node['cargo'] ?? '';
    $setor = $node['setor'] ?? '';
    $labelNivel = $node['label_nivel'] ?? $node['nivel'] ?? '';
    $areaAtuacao = $node['area_atuacao'] ?? '';
    $id = $node['id'] ?? uniqid('node_');
    
    // Tamanhos por nível
    $avatarClass = $config['avatarClass'] ?? 'avatar-sm';
    $titleClass = $config['titleClass'] ?? 'text-xs';
    
    // Classes do card baseadas no nível
    $cardClasses = "node-card {$corNivel} text-white rounded shadow-sm p-2 flex items-start gap-2 min-w-0 {$config['cardClass']}";
    if ($level === 0) $cardClasses .= ' border-b-3 border-lte-orange-dark';
    if ($level === 1) $cardClasses .= ' border-l-3 ' . str_replace('bg-', 'border-', $corSuper);
@endphp

<div class="{{ $cardClasses }}"
     onclick="openCardModal({{ $id }})"
     data-id="{{ $id }}"
     data-nome="{{ $nome }}"
     data-cargo="{{ $cargo }}"
     data-setor="{{ $setor }}"
     data-nivel="{{ $node['nivel'] ?? '' }}"
     data-label-nivel="{{ $labelNivel }}"
     data-cor-nivel="{{ $corNivel }}"
     data-superintendencia="{{ $node['superintendencia'] ?? '' }}"
     data-area-atuacao="{{ $areaAtuacao }}"
     role="button"
     tabindex="0"
     aria-label="{{ $nome }} - {{ $cargo }}"
     onkeydown="if(event.key==='Enter'||event.key===' ') {event.preventDefault(); openCardModal({{ $id }})}">

    <!-- Avatar -->
    <img src="{{ $foto }}" 
         alt="{{ $nome }}" 
         class="{{ $avatarClass }} rounded-full border-2 border-white/80 object-cover flex-shrink-0 shadow-sm"
         loading="lazy"
         onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('{{ $nome }}')+'&background='+('{{ str_replace('bg-', '', $corNivel) }}')+'&color=fff&size=120'">

    <!-- Info -->
    <div class="flex-1 min-w-0 text-left">
        @if($labelNivel)
            <span class="badge badge-nivel bg-white/20 text-white text-[9px] font-bold px-1.5 py-0.2 rounded uppercase">
                {{ $labelNivel }}
            </span>
        @endif
        
        <h3 class="{{ $titleClass }} font-bold leading-tight truncate mb-0.5">{{ $nome }}</h3>
        
        @if($cargo)
            <p class="text-[10px] opacity-90 truncate">{{ $cargo }}</p>
        @endif
        
        @if($areaAtuacao)
            <p class="text-[9px] opacity-75 truncate">{{ $areaAtuacao }}</p>
        @endif
    </div>
    
    <!-- Indicador de filhos -->
    @if(!empty($node['children']))
        <i class="fas fa-chevron-down text-white/60 text-xs mt-1 flex-shrink-0" aria-hidden="true"></i>
    @endif
</div>