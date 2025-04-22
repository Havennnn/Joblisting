@props(['route' => 'jobs.search'])

<div class="w-full bg-white shadow-lg p-6 relative z-10">
    <form action="{{ route($route) }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="sm:w-3/4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input
                type="text"
                name="query"
                placeholder="Job Title or Company Name"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                value="{{ request('query') }}"
            >
        </div>

        <div class="sm:w-1/4 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <select
                name="location"
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-no-repeat transition-colors"
                style="background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"%236B7280\"><path fill-rule=\"evenodd\" d=\"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z\" clip-rule=\"evenodd\" /></svg>'); background-position: right 0.5rem center; background-size: 1.5em 1.5em;"
            >
                <option value="">All Locations</option>
                <option value="Metro Manila" {{ request('location') == 'Metro Manila' ? 'selected' : '' }}>Metro Manila</option>
                <option value="Quezon City" {{ request('location') == 'Quezon City' ? 'selected' : '' }}>Quezon City</option>
                <option value="Manila" {{ request('location') == 'Manila' ? 'selected' : '' }}>Manila</option>
                <option value="Makati" {{ request('location') == 'Makati' ? 'selected' : '' }}>Makati</option>
                <option value="Taguig" {{ request('location') == 'Taguig' ? 'selected' : '' }}>Taguig</option>
                <option value="Pasig" {{ request('location') == 'Pasig' ? 'selected' : '' }}>Pasig</option>
                <option value="Pasay" {{ request('location') == 'Pasay' ? 'selected' : '' }}>Pasay</option>
                <option value="Mandaluyong" {{ request('location') == 'Mandaluyong' ? 'selected' : '' }}>Mandaluyong</option>
                <option value="Cebu City" {{ request('location') == 'Cebu City' ? 'selected' : '' }}>Cebu City</option>
                <option value="Davao City" {{ request('location') == 'Davao City' ? 'selected' : '' }}>Davao City</option>
                <option value="Baguio City" {{ request('location') == 'Baguio City' ? 'selected' : '' }}>Baguio City</option>
                <option value="Iloilo City" {{ request('location') == 'Iloilo City' ? 'selected' : '' }}>Iloilo City</option>
                <option value="Cagayan de Oro" {{ request('location') == 'Cagayan de Oro' ? 'selected' : '' }}>Cagayan de Oro</option>
                <option value="Bacolod City" {{ request('location') == 'Bacolod City' ? 'selected' : '' }}>Bacolod City</option>
                <option value="Zamboanga City" {{ request('location') == 'Zamboanga City' ? 'selected' : '' }}>Zamboanga City</option>
                <option value="Batangas" {{ request('location') == 'Batangas' ? 'selected' : '' }}>Batangas</option>
                <option value="Pampanga" {{ request('location') == 'Pampanga' ? 'selected' : '' }}>Pampanga</option>
                <option value="Tagaytay" {{ request('location') == 'Tagaytay' ? 'selected' : '' }}>Tagaytay</option>
                <option value="Laguna" {{ request('location') == 'Laguna' ? 'selected' : '' }}>Laguna</option>
                <option value="Cavite" {{ request('location') == 'Cavite' ? 'selected' : '' }}>Cavite</option>
            </select>
        </div>

        <button type="submit" class="bg-[#2563EB] text-white px-8 py-3 hover:bg-blue-700 transition duration-200 whitespace-nowrap font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            Find Job
        </button>
    </form>
</div>
