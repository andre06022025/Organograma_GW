@php
    $areaForcada = $areaForcada ?? null;
    $badge = $badge ?? null;
@endphp

<div class="js-filtravel grupo-box bg-white/70 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-700 rounded-lg p-2 shadow-sm">
    <div class="flex items-center justify-between gap-1 mb-1.5">
        <h3 class="text-[10px] font-bold uppercase tracking-wide text-slate-600 dark:text-slate-300 truncate">
            {{ $titulo }}
        </h3>
        <div class="flex items-center gap-1 shrink-0">
            @if($badge)
                <span class="text-[8px] font-semibold px-1.5 py-0.5 rounded bg-lte-cyan/15 text-lte-cyan">
                    {{ $badge }}
                </span>
            @endif
            <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                {{ $membros->count() }}
            </span>
        </div>
    </div>

    <div class="space-y-1.5">
        @foreach($membros as $colaborador)
            @include('organograma.partials._card', [
                'colaborador' => $colaborador,
                'areaForcada' => $areaForcada,
            ])
        @endforeach
    </div>
</div>
