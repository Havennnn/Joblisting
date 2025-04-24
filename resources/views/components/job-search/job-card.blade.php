<div class="bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden border-l-4 border-blue-600">
    <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    @if($job->company && $job->company->logo_path)
                        <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="Company Logo" class="h-14 w-14 object-cover border border-gray-200">
                    @elseif($job->employer && $job->employer->company_logo_path)
                        <img src="{{ asset('storage/' . $job->employer->company_logo_path) }}" alt="Company Logo" class="h-14 w-14 object-cover border border-gray-200">
                    @else
                        <div class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                        <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                    </h3>
                    <p class="text-gray-700 text-sm mt-1">
                        @if($job->company)
                            {{ $job->company->name }}
                        @else
                            {{ $job->employer->company_name ?? 'Company Name Not Available' }}
                        @endif
                    </p>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $job->location }}
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            ₱{{ number_format($job->salary, 0) }}
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $job->work_experience_level }} Experience
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $job->type }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row sm:flex-col justify-between sm:items-end sm:text-right">
                <span class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-red-100 text-red-800' : ($job->tags == 'Featured' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                    {{ $job->tags ?? 'New' }}
                </span>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-end">
        <a href="{{ route('jobs.show', $job->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            View Details →
        </a>
    </div>
</div>
