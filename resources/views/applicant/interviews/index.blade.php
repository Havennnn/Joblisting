@extends('layouts.applicant')

@section('title', 'Interview Calendar')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <x-applicant.sidebar />

    <!-- Main Calendar Content -->
    <div class="flex-1 flex flex-col bg-white">
        <!-- Calendar Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <button id="prev-month-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </button>
                <h2 id="month-display" class="text-xl font-semibold text-gray-900">{{ date('F Y') }}</h2>
                <button id="next-month-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <button id="today-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Today
            </button>
        </div>

        <!-- Calendar Table -->
        <div class="flex-1 overflow-auto">
            <table class="w-full h-full table-fixed border-collapse">
                <thead>
                    <tr>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Sunday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Monday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Tuesday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Wednesday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Thursday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Friday</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200">Saturday</th>
                    </tr>
                </thead>
                <tbody id="calendar-body" class="bg-white">
                    <!-- Calendar cells will be populated here via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Interview Details Modal -->
<div id="interview-details-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900">Interview Details</h3>
            <div id="interview-details" class="mt-4 space-y-4">
                <!-- Interview details will be populated here -->
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="close-details" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        const monthDisplay = document.getElementById('month-display');
        const calendarBody = document.getElementById('calendar-body');
        const interviewDetailsModal = document.getElementById('interview-details-modal');
        const interviewDetails = document.getElementById('interview-details');
        const closeDetailsBtn = document.getElementById('close-details');

        // Function to generate the calendar
        function generateCalendar(month, year) {
            // Clear the calendar
            calendarBody.innerHTML = '';

            // Update month display
            const monthName = new Date(year, month, 1).toLocaleString('default', { month: 'long' });
            monthDisplay.textContent = `${monthName} ${year}`;

            // Get first day of month
            const firstDay = new Date(year, month, 1);
            const startingDay = firstDay.getDay();

            // Get number of days in month
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Get days in previous month
            const prevMonth = month === 0 ? 11 : month - 1;
            const prevMonthYear = month === 0 ? year - 1 : year;
            const daysInPrevMonth = new Date(prevMonthYear, prevMonth + 1, 0).getDate();

            // Variables to build the calendar
            let date = 1;
            let nextMonthDate = 1;

            // Create calendar rows
            for (let i = 0; i < 6; i++) {
                // Break if we've gone beyond the month and there's no need for another row
                if (i > 0 && date > daysInMonth && nextMonthDate > 7) break;

                const row = document.createElement('tr');

                // Create cells for each day of the week
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    cell.className = 'p-2 h-32 border border-gray-200';
                    const dayContent = document.createElement('div');
                    dayContent.className = 'text-sm font-medium text-gray-900';

                    // Previous month, current month, or next month
                    if (i === 0 && j < startingDay) {
                        // Previous month
                        const prevDate = daysInPrevMonth - (startingDay - j - 1);
                        cell.className += ' bg-gray-50';
                        dayContent.className = 'text-sm text-gray-400';
                        dayContent.textContent = prevDate;
                    } else if (date > daysInMonth) {
                        // Next month
                        cell.className += ' bg-gray-50';
                        dayContent.className = 'text-sm text-gray-400';
                        dayContent.textContent = nextMonthDate++;
                    } else {
                        // Current month
                        const today = new Date();
                        const isToday = date === today.getDate() && month === today.getMonth() && year === today.getFullYear();

                        if (isToday) {
                            cell.className += ' bg-blue-50';
                        }

                        // Format date as YYYY-MM-DD for data attribute
                        const formattedMonth = (month + 1).toString().padStart(2, '0');
                        const formattedDate = date.toString().padStart(2, '0');
                        const dateStr = `${year}-${formattedMonth}-${formattedDate}`;
                        cell.setAttribute('data-date', dateStr);

                        dayContent.textContent = date;
                        date++;
                    }

                    cell.appendChild(dayContent);
                    row.appendChild(cell);
                }

                calendarBody.appendChild(row);
            }

            // Load interviews for the current month
            loadInterviews(month, year);
        }

        // Function to load interviews
        async function loadInterviews(month, year) {
            try {
                const response = await fetch(`/applicant/interviews/api/interviews?month=${month + 1}&year=${year}`);
                const interviews = await response.json();

                // Clear existing interview events
                document.querySelectorAll('.interview-event').forEach(el => el.remove());

                // Add interviews to calendar
                interviews.forEach(interview => {
                    const date = new Date(interview.interview_date);
                    const cell = document.querySelector(`[data-date="${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}"]`);

                    if (cell) {
                        const event = document.createElement('div');
                        event.className = 'interview-event mt-1 p-2 text-xs rounded cursor-pointer hover:bg-opacity-90';

                        // Set background color based on status
                        if (interview.status === 'accepted') {
                            event.className += ' bg-green-100 text-green-800 hover:bg-green-200';
                        } else if (interview.status === 'pending') {
                            event.className += ' bg-yellow-100 text-yellow-800 hover:bg-yellow-200';
                        } else {
                            event.className += ' bg-gray-100 text-gray-800 hover:bg-gray-200';
                        }

                        event.innerHTML = `
                            <div class="font-medium">${interview.job.title}</div>
                            <div class="text-xs">${interview.interview_time}</div>
                            ${interview.meeting_link ? `<a href="${interview.meeting_link}" target="_blank" class="block mt-1 text-xs text-blue-600 hover:text-blue-800">Join Meeting</a>` : ''}
                        `;
                        event.addEventListener('click', () => showInterviewDetails(interview));
                        cell.appendChild(event);
                    }
                });
            } catch (error) {
                console.error('Error loading interviews:', error);
            }
        }

        // Function to show interview details
        function showInterviewDetails(interview) {
            interviewDetails.innerHTML = `
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Job Position</h4>
                        <p class="mt-1 text-sm text-gray-900">${interview.job.title}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Company</h4>
                        <p class="mt-1 text-sm text-gray-900">${interview.job.company}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Date & Time</h4>
                        <p class="mt-1 text-sm text-gray-900">${new Date(interview.interview_date).toLocaleDateString()} at ${interview.interview_time}</p>
                    </div>
                    ${interview.meeting_link ? `
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Meeting Link</h4>
                            <a href="${interview.meeting_link}" target="_blank" class="mt-1 text-sm text-blue-600 hover:text-blue-800">${interview.meeting_link}</a>
                        </div>
                    ` : ''}
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Interviewer</h4>
                        <p class="mt-1 text-sm text-gray-900">${interview.employer.name}</p>
                        <p class="mt-1 text-sm text-gray-600">${interview.employer.email}</p>
                    </div>
                </div>
            `;
            interviewDetailsModal.classList.remove('hidden');
        }

        // Initialize calendar
        generateCalendar(currentMonth, currentYear);

        // Previous month button
        document.getElementById('prev-month-btn').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        // Next month button
        document.getElementById('next-month-btn').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });

        // Today button
        document.getElementById('today-btn').addEventListener('click', function() {
            const today = new Date();
            currentMonth = today.getMonth();
            currentYear = today.getFullYear();
            generateCalendar(currentMonth, currentYear);
        });

        // Close details modal
        closeDetailsBtn.addEventListener('click', function() {
            interviewDetailsModal.classList.add('hidden');
        });
    });
</script>
@endpush
