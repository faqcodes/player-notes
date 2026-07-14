@php
    $btn = 'inline-flex h-9 min-w-9 items-center justify-center gap-1 rounded-md border border-border bg-background px-3 text-sm font-medium text-foreground shadow-xs transition-colors hover:bg-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/50';
    $active = 'inline-flex h-9 min-w-9 items-center justify-center rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground shadow-xs';
    $disabled = 'inline-flex h-9 min-w-9 items-center justify-center gap-1 rounded-md border border-border bg-muted px-3 text-sm font-medium text-muted-foreground opacity-60 cursor-not-allowed';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación" class="mt-4 flex items-center justify-between gap-4">
        <p class="hidden text-sm text-muted-foreground sm:block">
            Mostrando <span class="font-medium text-foreground">{{ $paginator->firstItem() }}</span>
            a <span class="font-medium text-foreground">{{ $paginator->lastItem() }}</span>
            de <span class="font-medium text-foreground">{{ $paginator->total() }}</span> resultados
        </p>

        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="{{ $disabled }}" aria-disabled="true"><span aria-hidden="true">&larr;</span> Anterior</span>
            @else
                <button type="button" class="{{ $btn }}" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev">
                    <span aria-hidden="true">&larr;</span> Anterior
                </button>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="{{ $disabled }}">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="{{ $active }}" aria-current="page">{{ $page }}</span>
                        @else
                            <button type="button" class="{{ $btn }}" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button type="button" class="{{ $btn }}" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">
                    Siguiente <span aria-hidden="true">&rarr;</span>
                </button>
            @else
                <span class="{{ $disabled }}" aria-disabled="true">Siguiente <span aria-hidden="true">&rarr;</span></span>
            @endif
        </div>
    </nav>
@endif
