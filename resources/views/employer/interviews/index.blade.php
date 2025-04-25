@extends('layouts.employer')

@section('title', 'Interview Calendar')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <x-employer.sidebar />

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
        <div class="calendar-container flex-1">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    @php
                        $currentMonth = date('m');
                        $currentYear = date('Y');
                        $currentDay = date('d');

                        $firstDay = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
                        $daysInMonth = date('t', $firstDay);
                        $startDay = date('w', $firstDay);

                        $prevMonth = date('m', strtotime('-1 month', $firstDay));
                        $prevYear = date('Y', strtotime('-1 month', $firstDay));
                        $daysInPrevMonth = date('t', mktime(0, 0, 0, $prevMonth, 1, $prevYear));

                        $day = 1;
                        $nextMonthDay = 1;
                    @endphp

                    @for ($i = 0; $i < 6; $i++)
                        <tr>
                            @for ($j = 0; $j < 7; $j++)
                                @if (($i == 0 && $j < $startDay) || ($day > $daysInMonth))
                                    @if ($i == 0 && $j < $startDay)
                                        @php $prevMonthDate = $daysInPrevMonth - ($startDay - $j - 1); @endphp
                                        <td class="inactive-day">
                                            <div class="day-content">{{ $prevMonthDate }}</div>
                                        </td>
                                    @else
                                        <td class="inactive-day">
                                            <div class="day-content">{{ $nextMonthDay++ }}</div>
                                        </td>
                                    @endif
                                @else
                                    <td class="active-day {{ $day == $currentDay ? 'today' : '' }}"
                                        data-date="{{ $currentYear }}-{{ str_pad($currentMonth, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">
                                        <div class="day-content">{{ $day }}</div>
                                    </td>
                                    @php $day++; @endphp
                                @endif
                            @endfor
                        </tr>
                        @if ($day > $daysInMonth && $i < 5 && $nextMonthDay > 7)
                            @break
                        @endif
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<style>
    /* Calendar container - fills available space */
    .calendar-container {
        display: flex;
        flex-direction: column;
        overflow: auto;
    }

    /* Calendar table - fills entire space */
    .calendar-table {
        width: 100%;
        height: 100%;
        table-layout: fixed; /* Critical for equal width cells */
        border-collapse: collapse;
    }

    /* Table headers */
    .calendar-table th {
        padding: 12px 4px;
        text-align: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        height: 44px;
        overflow: hidden;
        width: calc(100% / 7); /* Force equal width */
        box-sizing: border-box;
        vertical-align: middle;
    }

    /* Calendar cells */
    .calendar-table td {
        border: 1px solid #e5e7eb;
        width: calc(100% / 7); /* Force equal width */
        position: relative; /* Required for absolute positioning within */
        padding: 8px 4px;
        vertical-align: top;
        height: calc((100vh - 73px - 44px) / 6); /* Fixed height calculation */
        box-sizing: border-box;
    }

    /* Day number styling */
    .day-content {
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Inactive days (prev/next month) */
    .inactive-day {
        background-color: #f9fafb;
    }

    .inactive-day .day-content {
        color: #9ca3af;
    }

    /* Active days (current month) */
    .active-day .day-content {
        color: #374151;
    }

    /* Today styling */
    .today {
        background-color: #eff6ff;
    }

    .today .day-content {
        color: #2563eb;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        const monthDisplay = document.getElementById('month-display');
        const calendarBody = document.getElementById('calendar-body');

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
                    const dayContent = document.createElement('div');
                    dayContent.className = 'day-content';

                    // Previous month, current month, or next month
                    if (i === 0 && j < startingDay) {
                        // Previous month
                        const prevDate = daysInPrevMonth - (startingDay - j - 1);
                        cell.className = 'inactive-day';

                        dayContent.textContent = prevDate;
                        cell.appendChild(dayContent);
                    } else if (date > daysInMonth) {
                        // Next month
                        cell.className = 'inactive-day';

                        dayContent.textContent = nextMonthDate++;
                        cell.appendChild(dayContent);
                    } else {
                        // Current month
                        const today = new Date();
                        const isToday = date === today.getDate() && month === today.getMonth() && year === today.getFullYear();

                        cell.className = `active-day ${isToday ? 'today' : ''}`;

                        // Format date as YYYY-MM-DD for data attribute
                        const formattedMonth = (month + 1).toString().padStart(2, '0');
                        const formattedDate = date.toString().padStart(2, '0');
                        const dateStr = `${year}-${formattedMonth}-${formattedDate}`;
                        cell.setAttribute('data-date', dateStr);

                        dayContent.textContent = date;
                        cell.appendChild(dayContent);

                        date++;
                    }

                    row.appendChild(cell);
                }

                calendarBody.appendChild(row);
            }
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

        // Handle window resize to maintain grid proportions
        window.addEventListener('resize', function() {
            // No need for manual adjustments with CSS table-layout: fixed
        });
    });
</script>
@endpush
