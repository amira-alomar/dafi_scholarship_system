<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Management Platform | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --background: #f5f5f5;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --primary: #e05252;
            --primary-foreground: #f8fafc;
            --secondary: #313e53;
            --secondary-foreground: #f8fafc;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #16a3b8;
            --accent-foreground: #f8fafc;
            --destructive: #ef4444;
            --destructive-foreground: #f8fafc;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --radius: 0.5rem;
            --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
        }


        .card {
            background-color: var(--card);
            color: var(--card-foreground);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
        }

        .btn-accent {
            background-color: var(--accent);
            color: var(--accent-foreground);
        }

        .btn-destructive {
            background-color: var(--destructive);
            color: var(--destructive-foreground);
        }

        .border-color {
            border-color: var(--border);
        }

        .text-muted {
            color: var(--muted-foreground);
        }

        .bg-muted {
            background-color: var(--muted);
        }

        .active-nav-item {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .active-nav-item:hover {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .sidebar-item:hover:not(.active-nav-item) {
            background-color: var(--muted);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--card);
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: var(--radius);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item {
            color: var(--foreground);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-item:hover {
            background-color: var(--muted);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 100;
                height: 100vh;
            }

            .sidebar-collapsed {
                transform: translateX(-100%);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--muted);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Animation for notifications */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .notification {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">

    @include('include.adminSideBar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white border-b border-color">
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-semibold">Dashboard Overview</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="p-2 rounded-full hover:bg-muted">
                            <i class="fas fa-bell text-muted"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-2">
                            <span class="hidden md:inline">Admin User</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-content right-0 mt-2">
                            <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
                            <a href="#" class="dropdown-item"><i class="fas fa-cog mr-2"></i> Settings</a>
                            <div class="border-t border-color"></div>
                            <a href="#" class="dropdown-item text-red-500"><i
                                    class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Sidebar -->

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-muted">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-muted">Total Scholarships</p>
                            <h3 class="text-2xl font-bold">{{ $scholarshipsCount }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-award text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-muted">Job Oppurtinites</p>
                            <h3 class="text-2xl font-bold">{{ $jobsCount }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-muted">Partner Universities</p>
                            <h3 class="text-2xl font-bold">{{ $universitiesCount }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-university text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-muted">Registered Users</p>
                            <h3 class="text-2xl font-bold">{{ $usersCount }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Applications Chart -->
                <div class="card p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Applications Overview</h2>
                        <form method="GET" class="inline-block">
                            <select name="period" onchange="this.form.submit()"
                                class="bg-muted text-sm p-2 rounded border-color">
                                <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 days</option>
                                <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 days</option>
                                <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 days</option>
                                <option value="365"{{ $period == 365 ? 'selected' : '' }}>This year</option>
                            </select>
                        </form>
                    </div>
                    <div class="h-64">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    // pull in the PHP arrays
                    const labels = @json($labels);
                    const usersData = @json($usersData);
                    const schsData = @json($schsData);

                    const ctx = document.getElementById('applicationsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                    label: 'New Users',
                                    data: usersData,
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true
                                },
                                {
                                    label: 'New Scholarships',
                                    data: schsData,
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>


                <!-- Recent Activity -->
                <div class="card p-6">
                    <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>

                    <div class="space-y-4">
                        @foreach ($activities as $activity)
                            <div class="flex items-start">
                                <div
                                    class="p-2 {{ match ($activity['type']) {
                                        'user' => 'bg-blue-100 text-blue-600',
                                        'scholarship' => 'bg-green-100 text-green-600',
                                        'job' => 'bg-yellow-100 text-yellow-600',
                                        'club' => 'bg-purple-100 text-purple-600',
                                        'partner' => 'bg-pink-100 text-pink-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    } }} rounded-full mr-3">
                                    <i
                                        class="fas {{ match ($activity['type']) {
                                            'user' => 'fa-user-plus',
                                            'scholarship' => 'fa-graduation-cap',
                                            'job' => 'fa-briefcase',
                                            'club' => 'fa-users',
                                            'partner' => 'fa-handshake',
                                            default => 'fa-info-circle',
                                        } }} text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $activity['label'] }}</p>
                                    <p class="text-xs text-muted">
                                        {{ $activity['name'] }} - {{ $activity['time']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="btn-secondary w-full mt-4 py-2">View All Activity</button>
                </div>

            </div>

            <!-- Recent Applications and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Scholarships -->
                <div class="card p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Recent Scholarships</h2>
                        <a href="{{ route('scholarships.index') }}" class="btn-primary px-4 py-2 text-sm">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-color">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted">Name</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted">Funding Org</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted">Start Date</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-muted">End Date</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-muted">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentScholarships->take(5) as $sch)
                                    <tr class="border-b border-color hover:bg-muted">
                                        <td class="py-3 px-4">{{ $sch->name }}</td>
                                        <td class="py-3 px-4">{{ $sch->funding_organization }}</td>
                                        <td class="py-3 px-4">{{ $sch->start_date->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">
                                            {{ $sch->end_date ? $sch->end_date->format('M d, Y') : '—' }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="{{ route('scholarships.index') }}"
                                                class="text-blue-500 hover:text-blue-700 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="card p-6">
                    <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('scholarships.index') }}"
                            class="w-full btn-primary py-3 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus mr-3"></i>
                            <span>Add New Scholarship</span>
                        </a>
                        <a href="{{ route('admins.manage') }}"
                            class="w-full btn-secondary py-3 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus mr-3"></i>
                            <span>Add New Supervisor</span>
                        </a>
                        <a href="{{ route('admin.uni') }}"
                            class="w-full btn-secondary py-3 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus mr-3"></i>
                            <span>Add University</span>
                        </a>

                    </div>



                </div>
            </div>
        </main>
    </div>

    <!-- Notification -->
    <div class="fixed bottom-4 right-4 w-72 card p-4 shadow-lg notification hidden">
        <div class="flex items-start">
            <div class="p-2 bg-green-100 text-green-600 rounded-full mr-3">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <h4 class="font-medium">Application Approved</h4>
                <p class="text-sm text-muted">Scholarship #2451 has been approved successfully.</p>
            </div>
            <button class="ml-auto text-muted hover:text-foreground" onclick="hideNotification()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
        });

        // Show notification (demo)
        setTimeout(function() {
            document.querySelector('.notification').classList.remove('hidden');
        }, 2000);

        function hideNotification() {
            document.querySelector('.notification').classList.add('hidden');
        }

        // // Chart initialization
        // const ctx = document.getElementById('applicationsChart').getContext('2d');
        // const applicationsChart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        //         datasets: [{
        //                 label: 'Applications',
        //                 data: [120, 190, 170, 220, 250, 210, 180],
        //                 backgroundColor: 'rgba(22, 163, 184, 0.1)',
        //                 borderColor: 'rgba(22, 163, 184, 1)',
        //                 borderWidth: 2,
        //                 tension: 0.3,
        //                 fill: true
        //             },
        //             {
        //                 label: 'Approved',
        //                 data: [40, 60, 80, 90, 100, 85, 70],
        //                 backgroundColor: 'rgba(16, 185, 129, 0.1)',
        //                 borderColor: 'rgba(16, 185, 129, 1)',
        //                 borderWidth: 2,
        //                 tension: 0.3,
        //                 fill: true
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             }
        //         },
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // Active nav item
        const navItems = document.querySelectorAll('.sidebar-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(i => i.classList.remove('active-nav-item'));
                this.classList.add('active-nav-item');
            });
        });

        // Mobile menu toggle (for smaller screens)
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>
