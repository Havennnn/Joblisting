<div class="bg-white rounded-lg border border-gray-200">
    <div class="border-b border-gray-200 p-4">
        <h3 class="text-lg font-medium text-gray-900">Your Job Listings</h3>
    </div>

    @if(count($JobPosts) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicants</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unread</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($JobPosts as $JobPost)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $JobPost->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $JobPost->industry }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $tagColor = match($JobPost->tags) {
                                        'Urgent' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                        'Featured' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tagColor['bg'] }} {{ $tagColor['text'] }}">
                                    {{ $JobPost->tags ?? 'Regular' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $JobPost->applicants_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $JobPost->unread_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium space-x-2">
                                <a href="{{ route('employer.JobPost.show', $JobPost->id) }}" class="text-neksjob-blue hover:text-neksjob-blue-dark">View</a>
                                <a href="{{ route('employer.JobPost.edit', $JobPost->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('employer.JobPost.destroy', $JobPost->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this job post?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!-- Reuse your empty state here if needed -->
        <x-employer.job-empty-state :completionPercentage="$completionPercentage" />
    @endif
</div>
