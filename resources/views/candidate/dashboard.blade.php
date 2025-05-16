<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Scholarships Dashboard - DAFI Scholarship System" />
    <title>Scholarships Dashboard - DAFI Scholarship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
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
            --font-sans: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
        }
        
        .scholarship-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Modern Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-[var(--primary)]">DAFI</span>
                        <span class="text-xl font-bold text-[var(--secondary)] ml-1">Scholarship</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('candidate.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] transition-colors">Dashboard</a>
                    <a href="{{ route('track_your_application') }}" class="px-3 py-2 rounded-md text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] transition-colors">Track Application</a>
                    <a href="{{ route('profile.show') }}" class="px-3 py-2 rounded-md text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] transition-colors">Profile</a>
                    <a href="{{ route('logout') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-[var(--primary)] text-white hover:bg-[var(--destructive)] transition-colors">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Banner -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h1 class="text-3xl font-bold text-[var(--secondary)] mb-2">Welcome, <span class="text-[var(--primary)]">{{ $user->fname }}</span>!</h1>
            <p class="text-[var(--muted-foreground)]">Explore your opportunities and manage your applications in one place.</p>
        </div>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Available Scholarships</h3>
                <p class="mt-2 text-3xl font-bold text-[var(--primary)]">{{ $scholarshipCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Submitted Applications</h3>
                <p class="mt-2 text-3xl font-bold text-[var(--accent)]">{{ $applicationCount }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Upcoming Deadlines</h3>
                <p class="mt-2 text-3xl font-bold text-[var(--secondary)]">02</p>
            </div>
        </div>

        @include('candidate.mentorAi')

        <!-- Available Scholarships -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-[var(--secondary)] mb-6 text-center">Available Scholarships</h2>
            
            @if ($scholarships->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <p class="text-[var(--muted-foreground)]">Currently, there are no available scholarships. Stay tuned for future opportunities!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($scholarships as $scholarship)
                        <div class="scholarship-card bg-white rounded-xl shadow-sm p-6 transition-all duration-300 hover:shadow-md">
                            <h3 class="text-xl font-bold text-[var(--secondary)] mb-2">{{ $scholarship->name }}</h3>
                            <p class="text-[var(--muted-foreground)] mb-4 line-clamp-3">{{ $scholarship->description }}</p>
                            <a href="{{ route('scholarship_details', ['id' => $scholarship->scholarshipID]) }}" class="inline-flex items-center px-4 py-2 bg-[var(--primary)] text-white rounded-md hover:bg-[var(--destructive)] transition-colors">
                                View Details
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- My Applications -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-[var(--secondary)] mb-6">My Applications</h2>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[var(--border)]">
                        <thead class="bg-[var(--muted)]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Application ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Scholarship</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--muted-foreground)] uppercase tracking-wider">Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[var(--border)]">
                            @foreach($applicationUsers as $application)
                            <tr class="hover:bg-[var(--muted)] transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[var(--secondary)]">{{ $application->applicationID }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--foreground)]">{{ $application->scholarship->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-{{ strtolower($application->status) }}">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--muted-foreground)]">{{ $application->submission_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Recent Announcements -->
        <section>
            <h2 class="text-2xl font-bold text-[var(--secondary)] mb-6">Recent Announcements</h2>
            <div class="space-y-4">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-[var(--foreground)]">
                        <strong class="text-[var(--primary)]">New Deadline Extension:</strong> Application deadline for STEM Scholarship extended to 2025-04-01.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <p class="text-[var(--foreground)]">
                        <strong class="text-[var(--primary)]">Workshop Invitation:</strong> Join our webinar on effective scholarship applications on 2025-03-20.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-6 border-t border-[var(--border)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-[var(--muted-foreground)]">
                &copy; 2025 DAFI Scholarship. All rights reserved. | 
                <a href="mailto:info@dafischolarship.org" class="text-[var(--primary)] hover:text-[var(--destructive)] transition-colors">info@dafischolarship.org</a>
            </p>
        </div>
    </footer>
</body>
</html>