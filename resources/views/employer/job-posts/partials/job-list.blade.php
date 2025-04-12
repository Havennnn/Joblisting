@if(count($JobPosts) > 0)
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Applicants</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unread</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($JobPosts as $JobPost)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div>
                        <div class="text-sm font-medium text-gray-900 max-w-[350px] truncate" title="{{ $JobPost->title }}">
                            {{ $JobPost->title }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $JobPost->industry }}</div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($JobPost->tags == 'Urgent')
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-semibold border-red-400 text-red-600 bg-red-300">
                            Urgent
                        </span>
                    @elseif($JobPost->tags == 'Featured')
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium border-blue-400 bg-blue-100 text-blue-800">
                            Featured
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium border-gray-400 bg-gray-100 text-gray-800">
                            Regular
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    {{ $JobPost->application_count ?? 0 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    {{ $JobPost->unread_application_count ?? 0 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center justify-center relative">
                        <!-- 3-dot button -->
                        <button type="button" id="menu-button-{{ $JobPost->id }}" class="inline-flex items-center justify-center w-10 h-10 text-gray-500 hover:text-gray-700 focus:outline-none text-2xl">
                            ⋮
                        </button>
                
                        <!-- Dropdown menu -->
                        <div id="dropdown-menu-{{ $JobPost->id }}" class="hidden absolute right-0 mt-2 w-32 origin-top-right rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1 text-sm" role="menu">
                                <a href="{{ route('employer.JobPost.show', $JobPost->id) }}" class="block px-4 py-2 text-neksjob-blue hover:bg-gray-100">View</a>
                                <a href="{{ route('employer.JobPost.edit', $JobPost->id) }}" class="block px-4 py-2 text-indigo-600 hover:bg-gray-100">Edit</a>
                                <form action="{{ route('employer.JobPost.destroy', $JobPost->id) }}" method="POST" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this job post?')" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="p-4">
    <div class="ajax-pagination">
        @if ($JobPosts->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between my-4">
                <div class="flex-1 flex flex-col items-center">
                    <div>
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-medium">{{ $JobPosts->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $JobPosts->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $JobPosts->total() }}</span> results
                        </p>
                    </div>

                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            {{-- Previous Page Link --}}
                            @if ($JobPosts->onFirstPage())
                                <span aria-disabled="true" aria-label="Previous" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-not-allowed rounded-l-md">
                                    <span class="sr-only">Previous</span>
                                    &lt;
                                </span>
                            @else
                                <a href="{{ $JobPosts->previousPageUrl() }}" rel="prev" class="pagination-link relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-neksjob-blue focus:border-neksjob-pink">
                                    <span class="sr-only">Previous</span>
                                    &lt;
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $links = $JobPosts->linkCollection()->filter(function ($link, $key) {
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
                                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neksjob-blue border border-neksjob-blue cursor-default">
                                        {{ $link['label'] }}
                                    </span>
                                @else
                                    <a href="{{ $link['url'] }}" class="pagination-link relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-neksjob-blue focus:border-neksjob-pink">
                                        {{ $link['label'] }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($JobPosts->hasMorePages())
                                <a href="{{ $JobPosts->nextPageUrl() }}" rel="next" class="pagination-link relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-neksjob-blue focus:border-neksjob-pink">
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
    </div>
</div>
@else

<div class="text-center py-10">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
    </svg>
    <h3 class="mt-2 text-sm font-medium text-gray-900">No job posts yet</h3>
    <p class="mt-1 text-sm text-gray-500">Get started by creating a new job post.</p>
    <div class="mt-6">
        @if(isset($completionPercentage) && $completionPercentage >= 70)
        <a href="{{ route('employer.JobPost.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Post New Job
        </a>
        @else
        <a href="{{ route('employer.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 6V4c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V8c.55 0 1-.45 1-1s-.45-1-1-1zm-2 2H4V4h6v4zm6 1v7c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2v-3h2v3h7V9h2z" clip-rule="evenodd" />
            </svg>
            Complete Profile First
        </a>
        @endif
    </div>
</div>
@endif

<script>
    document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
      const id = button.id.replace('menu-button-', '');
      const menu = document.getElementById(`dropdown-menu-${id}`);
  
      button.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.toggle('hidden');
      });
  
      window.addEventListener('click', (e) => {
        if (!button.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.add('hidden');
        }
      });
    });
  </script>
  
