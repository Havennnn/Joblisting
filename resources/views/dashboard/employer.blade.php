<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
        }
        .status-shortlisted { background-color: #059669; } /* green-600 equivalent */
        .status-failed { background-color: #dc2626; } /* red-600 equivalent */
        .status-pending_review { background-color: #d97706; } /* amber-600 equivalent */
        .status-hired { background-color: #2563eb; } /* blue-600 equivalent */
        .status-unknown { background-color: #4b5563; } /* gray-600 equivalent */
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-md fixed top-0 w-full z-50">
        <h1 class="text-2xl font-bold">
            {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->name : 'Dashboard' }}
        </h1>

          <!-- Logout Form -->
          <div>
        <a href="{{ route('employer.logout') }}"
        onclick="event.preventDefault(); confirmLogout();"
        class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition">Logout
    </a>
    <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" class="hidden">
    @csrf
    </form>

    <script>
    function confirmLogout() {
        if (confirm('Are you sure you want to log out?')) {
            document.getElementById('logout-form').submit();
        }
    }
    </script>
        </div>
    </nav>


    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-5 pt-20 fixed shadow-lg">
            <ul class="space-y-4">
                <li>
                    <a href="#" class="flex items-center space-x-3 px-5 py-3 rounded-lg bg-gray-800 hover:bg-blue-500 transition duration-300">
                        <span>🏠</span> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.applicants') }}" class="flex items-center space-x-3 px-5 py-3 rounded-lg hover:bg-blue-500 transition duration-300">
                        <span>📋</span> <span>Applicants</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.profile.index') }}" class="flex items-center space-x-3 px-5 py-3 rounded-lg hover:bg-blue-500 transition duration-300">
                        <span>👤</span> <span>Profile</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8 pt-20">
            <div class="grid grid-cols-4 gap-6 mb-6">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700">Total Applicants</h2>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalApplicants }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700">Shortlisted</h2>
                    <p class="text-2xl font-bold text-green-600">{{ $shortlistedApplicants }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700">Interviews Scheduled</h2>
                    <p class="text-2xl font-bold text-yellow-600">{{ $interviewsScheduled }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700">Pending Review</h2>
                    <p class="text-2xl font-bold text-red-600">{{ $pendingReview }}</p>
                </div>
            </div>
           <!-- Recent Applicants Table -->
<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-4">Recent Applicants</h2>

    <!-- Responsive Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-100 border-b text-gray-700 text-left">
                    <th class="py-3 px-6">First Name</th>
                    <th class="py-3 px-6">Last Name</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Interview Date</th>
                    <th class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentApplicants as $applicant)
                <tr class="border-b">
                    <td class="py-4 px-6">{{ $applicant->first_name ?? 'N/A' }}</td>
                    <td class="py-4 px-6">{{ $applicant->last_name ?? 'N/A' }}</td>
                    <td class="py-4 px-6">
                        <span class="status-badge {{ 'status-' . ($applicant->status ?? 'unknown') }}">
                            {{ ucfirst(str_replace('_', ' ', $applicant->status ?? 'Unknown')) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        {{ $applicant->interview_date ? \Carbon\Carbon::parse($applicant->interview_date)->format('Y-m-d') : 'Not Scheduled' }}
                    </td>
                    <td class="py-4 px-6">
                        <a href="{{ route('employer.applicants.view', $applicant->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- End Responsive Table Wrapper -->
</div>
</main>
</body>
</html>
