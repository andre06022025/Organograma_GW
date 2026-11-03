@php
    $colaborador = $colaborador ?? null;
    $barra = $barra ?? false;
    $cor = $cor ?? 'bg-lte-purple';
    $style = $style ?? '';
    $fixo = $fixo ?? false;
    $areaForcada = $areaForcada ?? null;
    $texto = $texto ?? null;
    $rotulo = $rotulo ?? ($colaborador ? mb_strtoupper($colaborador->nome_completo) : '');
    $nivelTexto = $nivelTexto ?? ($colaborador?->nivel_curto);
    $regiaoTexto = $regiaoTexto ?? ($colaborador?->regiao);
@endphp

@if($barra)
    <div class="{{ $cor }} text-white text-center font-bold uppercase text-[10px] px-1 py-1 leading-tight flex items-center justify-center min-h-[24px]
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
        <div class="node-card node-cell {{ $cor }} text-white text-center px-1 py-1 leading-tight min-h-[22px] cursor-pointer select-none"
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
            <span class="block text-[9px] font-bold uppercase leading-tight">{{ $rotulo }}</span>
        </div>
    @else
        <div class="node-card node-cell {{ $cor }} text-white text-center px-1 py-1 leading-tight flex flex-col items-center justify-center min-h-[52px] cursor-pointer select-none"
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

            <span class="block text-[8px] leading-none opacity-95">{{ $nivelTexto }}</span>
            <span class="block text-[10px] font-bold uppercase leading-tight mt-0.5">{{ $rotulo }}</span>
            @if($regiaoTexto)
                <span class="block text-[7.5px] leading-tight opacity-90 mt-0.5">{{ $regiaoTexto }}</span>
            @endif
        </div>
    @endif
@endif
