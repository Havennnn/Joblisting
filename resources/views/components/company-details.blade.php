<div class="bg-gray-50 p-6 mb-6 border border-gray-100">
    <div class="flex items-start">
        <div class="flex-shrink-0 mr-4">
            @if(isset($company) && $company && $company->logo_path)
                <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Company Logo" class="h-16 w-16 object-cover border border-gray-200">
            @elseif(isset($employer) && $employer && $employer->company_logo_path)
                <img src="{{ asset('storage/' . $employer->company_logo_path) }}" alt="Company Logo" class="h-16 w-16 object-cover border border-gray-200">
            @else
                <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>
        <div>
            <h3 class="text-lg font-medium text-gray-900">
                @if(isset($company) && $company)
                    {{ $company->name }}
                @elseif(isset($employer) && $employer)
                    {{ $employer->company_name ?? 'Company Name Not Available' }}
                @else
                    Company Name Not Available
                @endif
            </h3>
            <p class="mt-1 text-sm text-gray-600">
                @if(isset($company) && $company)
                    {{ $company->industry }}
                @elseif(isset($employer) && $employer)
                    {{ $employer->industry ?? 'Industry Not Available' }}
                @else
                    Industry Not Available
                @endif
            </p>
            <p class="mt-1 text-sm text-gray-600">
                @if(isset($company) && $company)
                    {{ $company->location }}
                @elseif(isset($employer) && $employer)
                    {{ $employer->location ?? 'Location Not Available' }}
                @else
                    Location Not Available
                @endif
            </p>
            @if(isset($company) && $company && $company->website)
                <a href="{{ $company->website }}" target="_blank" class="mt-2 text-sm text-blue-600 hover:text-blue-800 inline-flex items-center transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                    </svg>
                    Visit Website
                </a>
            @elseif(isset($employer) && $employer && $employer->website)
                <a href="{{ $employer->website }}" target="_blank" class="mt-2 text-sm text-blue-600 hover:text-blue-800 inline-flex items-center transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                    </svg>
                    Visit Website
                </a>
            @endif
        </div>
    </div>
</div>
