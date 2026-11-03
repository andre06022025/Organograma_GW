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
    $nivelTexto = $colaborador?->nivel_card_texto ?? ($nivelTexto ?? null);
    $regiaoTexto = $regiaoTexto ?? ($colaborador?->regiao);
@endphp

@if($barra)
    <div class="{{ $cor }} text-white text-center font-bold uppercase text-[clamp(9px,0.7vw,13px)] px-1 py-1 leading-tight flex items-center justify-center min-h-[clamp(24px,1.9vw,36px)]
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
        {{ $texto ?? $rotulo }}
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
            <span class="block text-[clamp(8.5px,0.6vw,11px)] font-bold uppercase leading-tight">{{ $rotulo }}</span>
        </div>
    @else
        <div class="node-card node-cell {{ $cor }} text-white text-center px-1 py-1 leading-tight flex flex-col items-center justify-center min-h-[clamp(52px,4.4vw,84px)] cursor-pointer select-none"
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

            <span class="block text-[clamp(7.5px,0.56vw,10px)] leading-none opacity-95">{{ $nivelTexto }}</span>
            <span class="block text-[clamp(10px,0.72vw,13px)] font-bold uppercase leading-tight mt-0.5">{{ $rotulo }}</span>
            @if($regiaoTexto)
                <span class="block text-[clamp(7px,0.52vw,9.5px)] leading-tight opacity-90 mt-0.5">{{ $regiaoTexto }}</span>
            @endif
        </div>
    @endif
@endif
