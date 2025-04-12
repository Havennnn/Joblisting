@props(['paginator'])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between my-4">
        <div class="flex-1 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Showing <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $paginator->total() }}</span> results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-l-md">
                            <span class="sr-only">Previous</span>
                            &lt;
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-link relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-[#2271b1] focus:border-[#2271b1]">
                            <span class="sr-only">Previous</span>
                            &lt;
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $links = $paginator->linkCollection()->filter(function ($link, $key) {
                            return !in_array($link['label'], ['&laquo; Previous', 'Next &raquo;', '&laquo;', '&raquo;']) &&
                                   !strpos($link['label'], '&laquo;') &&
                                   !strpos($link['label'], '&raquo;');
                        });
                    @endphp

                    @foreach ($links as $link)
                        @if ($link['url'] === null)
                            <span aria-disabled="true" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 cursor-default">
                                {{ $link['label'] }}
                            </span>
                        @elseif ($link['active'])
                            <span aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#2271b1] border border-[#2271b1] cursor-default">
                                {{ $link['label'] }}
                            </span>
                        @else
                            <a href="{{ $link['url'] }}" class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-[#2271b1] focus:border-[#2271b1]">
                                {{ $link['label'] }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-link relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-[#2271b1] focus:border-[#2271b1]">
                            <span class="sr-only">Next</span>
                            &gt;
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-r-md">
                            <span class="sr-only">Next</span>
                            &gt;
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
