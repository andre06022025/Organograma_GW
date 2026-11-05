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

    // Posição salva via painel de edição (quando existir) sobrepõe a posição padrão.
    $posicaoStyle = $style;
    if ($colaborador && empty($compacto) && $colaborador->card_coluna) {
        $posicaoStyle = preg_replace('/grid-column\s*:\s*[^;]+;?/i', '', $posicaoStyle);
        $posicaoStyle = preg_replace('/grid-row\s*:\s*[^;]+;?/i', '', $posicaoStyle);
        $posicaoStyle = trim($posicaoStyle);
        $posicaoStyle .= ' grid-column: ' . $colaborador->card_coluna . ' / span ' . ($colaborador->card_colspan ?: 1) . ';';
        $posicaoStyle .= ' grid-row: ' . $colaborador->card_linha . ' / span ' . ($colaborador->card_rowspan ?: 1) . ';';
        $posicaoStyle = trim($posicaoStyle);
    }

    // Alinhamento do conteúdo do card (horizontal/vertical).
    $align = $colaborador?->card_align ?: 'center';
    $valign = $colaborador?->card_valign ?: 'center';
    $alignMap = ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'];
    $valignMap = ['top' => 'flex-start', 'center' => 'center', 'bottom' => 'flex-end'];
    $textAlignMap = ['left' => 'left', 'center' => 'center', 'right' => 'right'];

    $alignCssBar = $colaborador
        ? ' justify-content: ' . $alignMap[$align] . '; align-items: ' . $valignMap[$valign] . '; text-align: ' . $textAlignMap[$align] . ' !important;'
        : '';
    $alignCssCard = $colaborador
        ? ' align-items: ' . $alignMap[$align] . '; justify-content: ' . $valignMap[$valign] . '; text-align: ' . $textAlignMap[$align] . ' !important;'
        : '';

    $barStyle = trim($posicaoStyle . $alignCssBar);
    $cardStyle = trim($posicaoStyle . $alignCssCard);
@endphp

@if($barra)
    <div class="{{ $cor }} text-white text-center font-bold uppercase text-[clamp(9px,0.7vw,13px)] px-1 py-1 leading-tight flex items-center justify-center gap-1.5 min-h-[clamp(24px,1.9vw,36px)]
                {{ $colaborador ? 'node-card node-cell cursor-pointer select-none' : '' }}"
         @if($barStyle) style="{{ $barStyle }}" @endif
         @if($colaborador)
             data-draggable="true"
             data-bar="true"
             role="button"
             tabindex="0"
             onclick="handleCardClick(this)"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();handleCardClick(this);}"
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
        <span class="card-name">{{ $colaborador?->card_texto ?? $texto ?? $rotulo }}</span>
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
             @if($cardStyle) style="{{ $cardStyle }}" @endif
             role="button"
             tabindex="0"
             onclick="handleCardClick(this)"
             onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();handleCardClick(this);}"
             @include('organograma.partials._attrs', [
                 'colaborador' => $colaborador,
                 'cor' => $cor,
                 'fixo' => $fixo,
                 'areaForcada' => $areaForcada,
             ])>

            <span class="block text-[clamp(7.5px,0.56vw,10px)] leading-none opacity-95">{{ $nivelTexto }}</span>

            <div class="card-name-row flex items-center justify-center gap-1 w-full min-w-0 mt-0.5"
                 style="justify-content: {{ $alignMap[$align] }};">
                @include('organograma.partials._avatar', ['colaborador' => $colaborador, 'size' => 'sm'])
                <span class="card-name block text-[clamp(10px,0.72vw,13px)] font-bold uppercase leading-tight break-words">{{ $rotulo }}</span>
            </div>

            @if($regiaoTexto)
                <span class="block text-[clamp(7px,0.52vw,9.5px)] leading-tight opacity-90 mt-0.5">{{ $regiaoTexto }}</span>
            @endif
        </div>
    @endif
@endif
