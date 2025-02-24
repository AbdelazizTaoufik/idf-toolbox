@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-4 space-x-2">
        {{-- Vorherige Seite --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-3 py-1 text-white bg-red-700 hover:bg-red-800 rounded transition duration-300">
                ←
            </a>
        @endif

        {{-- Seitenzahlen --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 text-white bg-red-900 rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-3 py-1 text-white bg-red-700 hover:bg-red-800 rounded transition duration-300">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Nächste Seite --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-3 py-1 text-white bg-red-700 hover:bg-red-800 rounded transition duration-300">
                →
            </a>
        @else
            <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">→</span>
        @endif
    </nav>
@endif
