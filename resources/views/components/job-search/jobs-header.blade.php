<div class="bg-white shadow-sm p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">{{ $title ?? 'Browse Jobs' }}</h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $startItem ?? 0 }} - {{ $endItem ?? 0 }} of {{ $total ?? 0 }} Jobs
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-600">Sort by:</span>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 pr-8 appearance-none cursor-pointer">
                <option>Most Relevant</option>
                <option>Newest</option>
                <option>Salary: High to Low</option>
                <option>Salary: Low to High</option>
            </select>
        </div>
    </div>
</div>
