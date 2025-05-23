<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Admin Dashboard - DAFI Scholarship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --dark-bg: #1F2937;
            --light-bg: #F9FAFB;
            --text-color: #111827;
            --muted-text: #6B7280;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .stat-card {
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--primary-color);
        }

        .stat-card:nth-child(2)::before {
            background-color: var(--secondary-color);
        }

        .stat-card:nth-child(3)::before {
            background-color: var(--accent-color);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            position: sticky;
            top: 0;
            background-color: white;
        }

        tr:hover td {
            background-color: #F3F4F6;
        }

        .status-approved {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-rejected {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .announcement-item {
            position: relative;
            padding-left: 1.5rem;
        }

        .announcement-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--primary-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeIn 0.5s ease forwards;
        }

        .animate-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animate-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animate-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .animate-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .animate-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .animate-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .animate-card:nth-child(7) {
            animation-delay: 0.7s;
        }

        .animate-card:nth-child(8) {
            animation-delay: 0.8s;
        }

        .animate-card:nth-child(9) {
            animation-delay: 0.9s;
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white p-6 overflow-y-auto">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </aside>
        <!-- Mobile sidebar toggle -->
        <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 bg-gray-900 text-white p-2 rounded-lg">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Main Content -->
        <main class="flex-1  p-6 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Welcome, Supervisor!</h1>
                    <p class="text-gray-600">Here's what's happening with your scholarship program</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 text-xl"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <!-- Supervisor Dashboard: Grouped & Ordered -->
            <div class="space-y-8">

                <section>
                    <h2 class="text-xl font-semibold mb-4">🔧 Pre‑Setup</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Questions must be defined before any admission step -->
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                            <a href="{{ route('supervisor.questions', ['scholarshipId' => $scholarshipID]) }}"
                                class="flex items-center justify-between text-gray-600 hover:text-indigo-600 transition">
                                <span>Manage Questions</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                            <p class="text-2xl font-bold mt-2">2,430</p>
                        </div>
                    </div>
                </section>

                <!-- 2. Admission Workflow -->
                <section>
                    <h2 class="text-xl font-semibold mb-4">🎓 Admission Steps</h2>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="flex flex-col sm:flex-row items-stretch">
                            <!-- Step 1 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('supervisor.application', ['scholarshipId' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">1</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">View
                                                Applications</h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="stepper-connector hidden sm:block"></div>

                            <!-- Step 2 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('examResult.create', ['scholarshipID' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">2</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">Exam
                                                Results</h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="stepper-connector hidden sm:block"></div>

                            <!-- Step 3 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('supervisor.exam', ['scholarshipID' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">3</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">Manage Exam
                                            </h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-gray-200"></div>

                        <div class="flex flex-col sm:flex-row items-stretch">
                            <!-- Step 4 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('interviewResult.create', ['scholarshipID' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">4</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">Interview
                                                Results</h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="stepper-connector hidden sm:block"></div>

                            <!-- Step 5 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('supervisor.interview', ['scholarshipID' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">5</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">Manage
                                                Interview</h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="stepper-connector hidden sm:block"></div>

                            <!-- Step 6 -->
                            <div class="flex-1 group hover:bg-gray-50 transition">
                                <a href="{{ route('supervisor.finalApplication', ['scholarshipID' => $scholarshipID]) }}"
                                    class="block p-6">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                                            <span class="text-indigo-600 font-medium">6</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-gray-600 group-hover:text-indigo-600 transition">Final
                                                Applications</h3>
                                            <p class="text-2xl font-bold mt-1">2,430</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 3. General Management -->
                <section>
                    <h2 class="text-xl font-semibold mb-4">📋 General Management</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                            <a href="{{ route('supervisor.manageUsers', ['scholarshipID' => $scholarshipID]) }}"
                                class="flex items-center justify-between text-gray-600 hover:text-indigo-600 transition">
                                <span>Manage Users</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                            <p class="text-2xl font-bold mt-2">1,250</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                            <a href="{{ route('supervisor.acceptedStudents', ['scholarshipID' => $scholarshipID]) }}"
                                class="flex items-center justify-between text-gray-600 hover:text-indigo-600 transition">
                                <span>Accepted Students</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                            <p class="text-2xl font-bold mt-2">5,678</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                            <a href="{{ route('supervisor.course', ['scholarshipID' => $scholarshipID]) }}"
                                class="flex items-center justify-between text-gray-600 hover:text-indigo-600 transition">
                                <span>View Courses</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                            <p class="text-2xl font-bold mt-2">2,430</p>
                        </div>
                    </div>
                </section>

            </div>
            <hr><br><br>
            <!-- Recent Applications Section -->
            <div class="bg-white rounded-lg shadow mb-8 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold">
                        Recent Applications for “{{ $scholarship->name }}”
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-500 text-sm">
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Student Name</th>
                                <th class="px-6 py-3">Scholarship</th>
                                <th class="px-6 py-3">Date Applied</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50">
                                    {{-- Application ID --}}
                                    <td class="px-6 py-4">{{ $app->applicationID }}</td>

                                    {{-- Student Name via relation --}}
                                    <td class="px-6 py-4 font-medium">
                                        {{ $app->user->fname . ' ' . $app->user->lname }}
                                    </td>

                                    {{-- Scholarship name --}}
                                    <td class="px-6 py-4">
                                        {{ $app->scholarship->name }}
                                    </td>

                                    {{-- Submission date --}}
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($app->submission_date)->format('Y-m-d') }}
                                    </td>

                                    {{-- Status with dynamic badge --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'approved' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'canceled' => 'bg-gray-100 text-gray-800',
                                            ];
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClasses[$app->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Announcements Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Application Status Overview</h3>
                        <canvas id="statusChart"></canvas>
                    </div>

                    <!-- Chart.js CDN -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const ctx = document.getElementById('statusChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Accepted', 'Rejected', 'Pending'],
                                datasets: [{
                                    data: [{{ $acceptedStudents }}, {{ $rejectedStudents }}, {{ $pendingStudents }}],
                                    backgroundColor: ['#10b981', '#ef4444', '#fbbf24'],
                                    borderColor: '#fff',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Scholarship Application Status'
                                    }
                                }
                            }
                        });
                    </script>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('interviewResult.create', ['scholarshipID' => $scholarshipID]) }}"
                            class="bg-indigo-50 text-indigo-600 p-4 rounded-lg flex flex-col items-center justify-center hover:bg-indigo-100 transition">
                            <i class="fas fa-plus-circle text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Add Interview Result</span>
                        </a>
                        <a href="{{ route('supervisor.finalApplication', ['scholarshipID' => $scholarshipID]) }}"
                            class="bg-green-50 text-green-600 p-4 rounded-lg flex flex-col items-center justify-center hover:bg-green-100 transition">
                            <i class="fas fa-user-plus text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Manage Applications</span>
                        </a>
                        <a href="{{ route('interviewResult.create', ['scholarshipID' => $scholarshipID]) }}"
                            class="bg-yellow-50 text-yellow-600 p-4 rounded-lg flex flex-col items-center justify-center hover:bg-yellow-100 transition">
                            <i class="fas fa-file-upload text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Upload Exam Result</span>
                        </a>
                        <a href="{{ route('supervisor.course', ['scholarshipID' => $scholarshipID]) }}"
                            class="bg-purple-50 text-purple-600 p-4 rounded-lg flex flex-col items-center justify-center hover:bg-purple-100 transition">
                            <i class="fas fa-chart-line text-2xl mb-2"></i>
                            <span class="text-sm font-medium">Manage Courses</span>
                        </a>
                    </div>
                </div>
            </div>
    </div>


    <!-- Mobile Sidebar -->
    {{-- <div id="mobileSidebar" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden">
        <div class="w-64 bg-gray-900 text-white min-h-screen p-6 transform -translate-x-full transition duration-300">
            <div class="flex items-center space-x-2 mb-10">
                <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
                <h1 class="text-xl font-bold">DAFI Scholarship</h1>
            </div>

            <nav>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-800">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-users"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-book"></i>
                            <span>Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-file-alt"></i>
                            <span>Applications</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-question-circle"></i>
                            <span>Questions</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Exams</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-comments"></i>
                            <span>Interviews</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto pt-10">
                <div class="flex items-center space-x-3 p-3 rounded-lg bg-gray-800">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Supervisor</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
    <script>
        // Toggle mobile sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');

        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.toggle('hidden');
            const sidebarContent = mobileSidebar.querySelector('div');
            sidebarContent.classList.toggle('translate-x-0');
            sidebarContent.classList.toggle('-translate-x-full');
        });

        // Close sidebar when clicking outside
        mobileSidebar.addEventListener('click', (e) => {
            if (e.target === mobileSidebar) {
                mobileSidebar.classList.add('hidden');
                const sidebarContent = mobileSidebar.querySelector('div');
                sidebarContent.classList.remove('translate-x-0');
                sidebarContent.classList.add('-translate-x-full');
            }
        });

        // Add ripple effect to stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Only add ripple if clicking on the card itself, not the link
                if (e.target === this) {
                    const link = this.querySelector('a');
                    if (link) {
                        link.click();
                    }
                }
            });
        });

        // Add hover effect to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>

</html>
