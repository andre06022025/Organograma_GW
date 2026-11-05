@php
    $colaborador = $colaborador ?? null;
    $barra = $barra ?? false;
    $corForcada = $corForcada ?? null;
    $cor = $corForcada ?? ($colaborador?->cor_classe ?? ($cor ?? 'bg-lte-purple'));
    $style = $style ?? '';
    $fixo = $fixo ?? false;
    $areaForcada = $areaForcada ?? null;
    $texto = $texto ?? null;
    $rotulo = $colaborador?->rotulo_card ?? ($rotulo ?? '');
    $nivelTexto = $colaborador?->cargo ?? ($nivelTexto ?? null);
    $regiaoTexto = $regiaoTexto ?? ($colaborador?->regiao);

    // Posição salva via drag-and-drop (quando existir) sobrepõe a posição padrão.
    $posicaoStyle = $style;
    if ($colaborador && empty($compacto) && !$barra && $colaborador->card_coluna) {
        $posicaoStyle = preg_replace('/grid-column\s*:\s*[^;]+;?/i', '', $posicaoStyle);
        $posicaoStyle = preg_replace('/grid-row\s*:\s*[^;]+;?/i', '', $posicaoStyle);
        $posicaoStyle = trim($posicaoStyle);
        $posicaoStyle .= ' grid-column: ' . $colaborador->card_coluna . ' / span ' . ($colaborador->card_colspan ?: 1) . ';';
        $posicaoStyle .= ' grid-row: ' . $colaborador->card_linha . ';';
        $posicaoStyle = trim($posicaoStyle);
    }

    // Largura atual do card (colspan).
    $colspanAtual = 1;
    if ($colaborador && empty($compacto) && !$barra) {
        if ($colaborador->card_colspan) {
            $colspanAtual = (int) $colaborador->card_colspan;
        } elseif (preg_match('/span\s+(\d+)/i', (string) $style, $m)) {
            $colspanAtual = (int) $m[1];
        }
    }
@endphp

@if($barra)
    <div class="{{ $cor }} text-white text-center font-bold uppercase text-[clamp(9px,0.7vw,13px)] px-1 py-1 leading-tight flex items-center justify-center gap-1.5 min-h-[clamp(24px,1.9vw,36px)]
                {{ $colaborador ? 'node-card cursor-pointer select-none' : '' }}"
         @if($style) style="{{ $style }}" @endif
         @if($colaborador)
             role="button"
             tabindex="0"
             onclick="openCardModal({{ $colaborador->id }})"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardModal({{ $colaborador->id }});}"
             @include('organograma.partials._attrs', [
                 'colaborador' => $colaborador,
                 'cor' => $cor,
                 'fixo' => $fixo,
                 'areaForcada' => $areaForcada,
             ])
         @endif>
        @if($colaborador)
            @include('organograma.partials._avatar', ['colaborador' => $colaborador, 'size' => 'bar'])
        @endif
        <span>{{ $texto ?? $rotulo }}</span>
    </div>
@elseif($colaborador)
    @if(!empty($compacto))
        <div class="node-card node-cell {{ $cor }} text-white text-center px-1 py-1 leading-tight min-h-[clamp(22px,1.7vw,32px)] cursor-pointer select-none"
             @if($style) style="{{ $style }}" @endif
             role="button"
             tabindex="0"
             onclick="openCardModal({{ $colaborador->id }})"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardModal({{ $colaborador->id }});}"
             @include('organograma.partials._attrs', [
                 'colaborador' => $colaborador,
                 'cor' => $cor,
                 'fixo' => $fixo,
                 'areaForcada' => $areaForcada,
             ])>
            <div class="flex items-center justify-center gap-1 w-full min-w-0">
                @include('organograma.partials._avatar', ['colaborador' => $colaborador, 'size' => 'xs'])
                <span class="block text-[clamp(8.5px,0.6vw,11px)] font-bold uppercase leading-tight truncate">{{ $rotulo }}</span>
            </div>
        </div>
    @else
        <div class="node-card node-cell {{ $cor }} text-white text-center px-1 py-1 leading-tight flex flex-col items-center justify-center min-h-[clamp(52px,4.4vw,84px)] cursor-pointer select-none"
             data-draggable="true"
             @if($posicaoStyle) style="{{ $posicaoStyle }}" @endif
             role="button"
             tabindex="0"
             onclick="openCardModal({{ $colaborador->id }})"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openCardModal({{ $colaborador->id }});}"
             @include('organograma.partials._attrs', [
                 'colaborador' => $colaborador,
                 'cor' => $cor,
                 'fixo' => $fixo,
                 'areaForcada' => $areaForcada,
             ])>

            <span class="block text-[clamp(7.5px,0.56vw,10px)] leading-none opacity-95">{{ $nivelTexto }}</span>

            <div class="flex items-center justify-center gap-1 w-full min-w-0 mt-0.5">
                @include('organograma.partials._avatar', ['colaborador' => $colaborador, 'size' => 'sm'])
                <span class="card-name block text-[clamp(10px,0.72vw,13px)] font-bold uppercase leading-tight break-words">{{ $rotulo }}</span>
            </div>

            @if($regiaoTexto)
                <span class="block text-[clamp(7px,0.52vw,9.5px)] leading-tight opacity-90 mt-0.5">{{ $regiaoTexto }}</span>
            @endif

            <div class="card-width-control hidden items-center justify-center gap-1 mt-1 text-[9px]">
                <button type="button" onclick="event.stopPropagation(); changeCardSpan(this, -1)"
                        class="px-1 bg-white/25 rounded leading-none" title="Diminuir largura">−</button>
                <span class="card-span-value font-bold">{{ $colspanAtual }}</span>
                <button type="button" onclick="event.stopPropagation(); changeCardSpan(this, 1)"
                        class="px-1 bg-white/25 rounded leading-none" title="Aumentar largura">+</button>
            </div>

            <div class="card-drag-handle hidden items-center justify-center gap-1 mt-0.5 text-[8px] opacity-80 cursor-grab"
                 draggable="true" title="Arraste para mover o card">
                <i class="fas fa-grip-vertical"></i> arrastar
            </div>
        </div>
    @endif
@endif
