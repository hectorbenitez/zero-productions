{{-- Riff pagination: overrides Laravel's default Tailwind view (only the admin lists paginate) --}}
@if ($paginator->hasPages())
    @php
        $cell = 'inline-flex items-center justify-center min-w-[40px] h-10 px-3 border font-mono text-sm';
    @endphp
    <nav role="navigation" aria-label="Paginación" class="flex flex-wrap items-center justify-between gap-4">
        <p class="rf-code">
            @if ($paginator->firstItem())
                {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }}
            @else
                {{ $paginator->count() }} de {{ $paginator->total() }}
            @endif
        </p>

        <div class="flex flex-wrap items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="{{ $cell }} border-rule text-smoke opacity-40" aria-disabled="true" aria-label="Anterior"><x-rock-icon name="arrow-left" :size="16" /></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $cell }} border-rule-strong text-bone hover:border-bone" aria-label="Anterior"><x-rock-icon name="arrow-left" :size="16" /></a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="{{ $cell }} border-transparent text-smoke" aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="{{ $cell }} border-bone bg-steel text-bone" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="{{ $cell }} border-rule text-ash hover:border-bone hover:text-bone" aria-label="Página {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $cell }} border-rule-strong text-bone hover:border-bone" aria-label="Siguiente"><x-rock-icon name="arrow-right" :size="16" /></a>
            @else
                <span class="{{ $cell }} border-rule text-smoke opacity-40" aria-disabled="true" aria-label="Siguiente"><x-rock-icon name="arrow-right" :size="16" /></span>
            @endif
        </div>
    </nav>
@endif
