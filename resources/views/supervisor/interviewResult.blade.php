<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Interview Scheduling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animations and transitions */
        .slide-down {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast-enter {
            animation: toastEnter 0.3s ease-out;
        }

        @keyframes toastEnter {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 280px;
            overflow-y: auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            z-index: 100;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            transform: translateX(-280px);
        }

        html,
        body {
            height: 100%;
            margin: 0;
            background-color: #f8fafc;
        }

        body {
            display: flex;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            width: calc(100% - 280px);
            padding: 2rem;
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        .main-content-expanded {
            margin-left: 0;
            width: 100%;
        }

        .hidden {
            display: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .form-input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .table-row:hover {
            background-color: #f1f5f9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hamburger {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 110;
            background: white;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-280px);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .hamburger {
                display: block;
            }

            .sidebar-open {
                transform: translateX(0);
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 99;
                display: none;
            }

            .mobile-overlay.active {
                display: block;
            }
        }

        .toast {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 1000;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <!-- Mobile hamburger menu -->
    <div class="hamburger" id="hamburger">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </div>

    <!-- Mobile overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div class="sidebar" id="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </div>

    <div class="main-content" id="mainContent">
        @if (isset($message))
            <div class="card p-12 text-center max-w-2xl mx-auto">
                <div class="w-16 h-16 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Stage Unavailable</h3>
                <p class="text-gray-600 text-lg">{{ $message }}</p>
            </div>
        @else
            <!-- Success Toast -->
            @if (session('success'))
                <div class="toast toast-enter" id="msg">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="max-w-7xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Interview Management</h1>
                    <p class="text-xl text-gray-600">Scholarship Program #{{ $scholarshipID }}</p>
                </div>

                <!-- Add Interview Button -->
                <div class="mb-8">
                    <button id="toggleForm"
                        class="btn-primary px-8 py-4 text-lg font-semibold inline-flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Schedule New Interview</span>
                    </button>
                </div>
                <hr class="my-6">

                {{-- Excel Import Form for Interviews --}}
                <form action="{{ route('interviewResult.importExcel', ['scholarshipID' => $scholarshipID]) }}"
                    method="POST" enctype="multipart/form-data" class="mb-6">
                    @csrf
                    <label for="excel_file" class="font-semibold">
                        📑 Upload Excel (student_id, interview_date, performance_level, recommendation, notes):
                    </label>
                    <input type="file" name="file" id="excel_file" accept=".xlsx,.xls" required
                        class="block mt-1">
                    @error('file')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn-primary mt-2">
                        Import Interviews from Excel
                    </button>
                </form>

                {{-- Show Success --}}
                @if (session('success'))
                    <div class="alert-success mb-4">
                        <span>✓</span> {{ session('success') }}
                    </div>
                @endif

                {{-- Show Warnings --}}
                @if (session('warnings'))
                    <div class="alert-warning mb-8 p-4 bg-yellow-100 text-yellow-800 rounded">
                        <strong>Warnings:</strong>
                        <ul class="list-disc ml-6">
                            @foreach (session('warnings') as $warn)
                                <li>{{ $warn }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- No Eligible Candidates Warning -->
                @if ($eligible->isEmpty())
                    <div class="card p-8 mb-8 bg-gradient-to-r from-yellow-50 to-orange-50 border-yellow-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-yellow-800">No Eligible Candidates</h3>
                                <p class="text-yellow-700 mt-1">Candidates must pass the examination before scheduling
                                    interviews.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Interview Form -->
                    <div id="intForm" class="hidden slide-down mb-8">
                        <div class="card p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center space-x-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m0 0V9a2 2 0 01-2 2H10a2 2 0 01-2-2V7m0 0a3 3 0 00-3 3v10a1 1 0 001 1h8a1 1 0 001-1V10a3 3 0 00-3-3z">
                                    </path>
                                </svg>
                                <span>Schedule Interview</span>
                            </h3>

                            <form action="{{ route('interviewResult.store', ['scholarshipID' => $scholarshipID]) }}"
                                method="POST" class="space-y-6">
                                @csrf
                                <div class="grid gap-6 md:grid-cols-3">
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 mb-3 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            <span>Student</span>
                                        </label>
                                        <select name="student_id" required class="form-input w-full">
                                            <option value="">Choose a student...</option>
                                            @foreach ($eligible as $item)
                                                <option value="{{ $item->application->user->id }}">
                                                    ID: {{ $item->application->user->id }} —
                                                    {{ $item->application->user->fname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 mb-3 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m0 0V9a2 2 0 01-2 2H10a2 2 0 01-2-2V7m0 0a3 3 0 00-3 3v10a1 1 0 001 1h8a1 1 0 001-1V10a3 3 0 00-3-3z">
                                                </path>
                                            </svg>
                                            <span>Interview Date</span>
                                        </label>
                                        <input type="date" name="interview_date" required
                                            class="form-input w-full" value="{{ now()->toDateString() }}" />
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 mb-3 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Performance Level</span>
                                        </label>
                                        <select name="performance_level" required class="form-input w-full">
                                            <option value="">Choose level...</option>
                                            <option value="bad">Bad</option>
                                            <option value="good">Good</option>
                                            <option value="excellent">Excellent</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 mb-3 flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Recommendation</span>
                                        </label>
                                        <select name="recommendation" required class="form-input w-full">
                                            <option value="">Choose...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            Notes
                                        </label>
                                        <textarea name="notes" rows="4" class="form-input w-full" placeholder="Add any notes..."></textarea>
                                    </div>

                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="btn-primary px-8 py-3 inline-flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Create Interview</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Interview Table -->
                <div class="card overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Scheduled Interviews</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Interview ID
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Student Name
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Interview Date
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Performance Level
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Recommendation
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($interviews as $i)
                                    <tr class="table-row transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $i->interviewID }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $i->application->user->fname }} {{ $i->application->user->lname }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $i->interview_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ucfirst($i->performance_level) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($i->recommendation === 'yes')
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Yes</span>
                                            @else
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $i->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif
    </div>

    <script>
        // Toggle form with smooth animation
        document.getElementById('toggleForm').addEventListener('click', () => {
            const form = document.getElementById('intForm');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.classList.add('slide-down');
            } else {
                form.classList.add('hidden');
            }
        });

        // Auto-hide success message with fade animation
        const msgElement = document.getElementById('msg');
        if (msgElement) {
            setTimeout(() => {
                msgElement.classList.add('fade-out');
                setTimeout(() => msgElement.remove(), 500);
            }, 4500);
        }

        // Mobile sidebar functionality
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const mobileOverlay = document.getElementById('mobileOverlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-open');
            mobileOverlay.classList.toggle('active');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-open');
            mobileOverlay.classList.remove('active');
        });

        // Desktop sidebar toggle for larger screens
        if (window.innerWidth > 768) {
            hamburger.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('main-content-expanded');
            });
        }
    </script>
</body>

</html>
