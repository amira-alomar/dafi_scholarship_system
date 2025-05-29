<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Scholarships Dashboard - DAFI Scholarship  System" />
    <title>Scholarships Dashboard - DAFI Scholarship </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
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
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: var(--foreground);
            min-height: 100vh;
        }

        /* Enhanced card animations */
        .card-base {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scholarship-card {
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .scholarship-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .scholarship-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .scholarship-card:hover::before {
            left: 100%;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            animation: countUp 0.8s ease-out forwards;
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        /* Status badges with enhanced styling */
        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            box-shadow: 0 2px 4px rgba(251, 191, 36, 0.2);
        }

        .status-approved {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .status-rejected {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }

        /* Enhanced button styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #dc2626);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(224, 82, 82, 0.3);
        }

        /* Navigation enhancements */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Table row hover effects */
        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            transform: translateX(4px);
            background: linear-gradient(90deg, var(--muted), rgba(255, 255, 255, 0.8));
        }

        /* Welcome banner gradient */
        .welcome-banner {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(224, 82, 82, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        /* Loading animation for stats */
        .loading-shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Mobile menu toggle animation */
        @media (max-width: 640px) {
            .mobile-menu-toggle {
                display: block;
            }
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced empty state */
        .empty-state {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            position: relative;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(22, 163, 184, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                opacity: 0.8;
                transform: translate(-50%, -50%) scale(1.1);
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Enhanced Modern Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center group">
                        <span
                            class="text-xl font-bold text-[var(--primary)] transition-all duration-300 group-hover:scale-110">DAFI </span>
                        <span
                            class="text-xl font-bold text-[var(--secondary)] ml-1 transition-all duration-300 group-hover:scale-110">Scholarship</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-2">
                    <a href="{{ route('candidate.dashboard') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Dashboard</a>
                    <a href="{{ route('track_your_application') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Track
                        Application</a>
                    <a href="{{ route('profile.show') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Profile</a>
                    <a href="{{ route('logout') }}"
                        class="btn-primary px-4 py-2 rounded-lg text-sm font-medium text-white hover:bg-[var(--destructive)] transition-all duration-300 relative overflow-hidden">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Enhanced Welcome Banner -->
        <div class="welcome-banner card-base rounded-2xl shadow-xl p-8 mb-12 fade-in-up relative z-10">
            <div class="relative z-10">
                <h1 class="text-4xl font-bold text-[var(--secondary)] mb-3 leading-tight">
                    Welcome back,
                    <span
                        class="text-[var(--primary)] bg-gradient-to-r from-[var(--primary)] to-red-600 bg-clip-text text-transparent">{{ $user->fname }}</span>!
                </h1>
                <p class="text-lg text-[var(--muted-foreground)] font-medium">Explore your opportunities and manage your
                    applications in one beautifully organized place.</p>
            </div>
        </div>

        <!-- Enhanced Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="stat-card card-base rounded-2xl shadow-lg p-8 fade-in-up stagger-1 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--muted-foreground)] uppercase tracking-widest mb-2">
                            Available Scholarships</h3>
                        <p class="stat-number text-4xl font-bold text-[var(--primary)] leading-none">
                            {{ $scholarshipCount }}</p>
                    </div>
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[var(--primary)]/10 to-[var(--primary)]/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[var(--primary)]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="stat-card card-base rounded-2xl shadow-lg p-8 fade-in-up stagger-2 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--muted-foreground)] uppercase tracking-widest mb-2">
                            Submitted Applications</h3>
                        <p class="stat-number text-4xl font-bold text-[var(--accent)] leading-none">
                            {{ $applicationCount }}</p>
                    </div>
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[var(--accent)]/10 to-[var(--accent)]/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[var(--accent)]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="stat-card card-base rounded-2xl shadow-lg p-8 fade-in-up stagger-3 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--muted-foreground)] uppercase tracking-widest mb-2">
                            Upcoming Deadlines</h3>
                        <p class="stat-number text-4xl font-bold text-[var(--secondary)] leading-none">02</p>
                    </div>
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[var(--secondary)]/10 to-[var(--secondary)]/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[var(--secondary)]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @include('candidate.mentorAi')

        <!-- Enhanced Available Scholarships -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[var(--secondary)] mb-4">Available Scholarships</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-[var(--primary)] to-red-600 mx-auto rounded-full"></div>
            </div>

            @if ($scholarships->isEmpty())
                <div class="empty-state card-base rounded-2xl shadow-lg p-16 text-center relative">
                    <div class="relative z-10">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-[var(--accent)]/20 to-[var(--accent)]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-[var(--accent)]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[var(--secondary)] mb-2">No Scholarships Available</h3>
                        <p class="text-[var(--muted-foreground)] text-lg">Currently, there are no available
                            scholarships. Stay tuned for exciting future opportunities!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($scholarships as $scholarship)
                        <div
                            class="scholarship-card card-base rounded-2xl shadow-lg overflow-hidden transition-transform hover:scale-105 duration-300 p-0 bg-white">
                            <!-- 1. Image on top -->
                            <div class="w-full h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $scholarship->picture) }}" alt="Scholarship Image"
                                    class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-110" />
                            </div>

                            <div class="p-6 flex flex-col items-start gap-4">
                                <!-- 2. Name centered -->
                                <h3
                                    class="w-full text-center text-2xl font-extrabold text-[var(--primary)] group-hover:text-[var(--secondary)] transition-colors duration-300 leading-tight">
                                    {{ $scholarship->name }}
                                </h3>

                                <!-- 3. Description -->
                                <p class="text-[var(--muted-foreground)] text-sm leading-relaxed line-clamp-3">
                                    {{ $scholarship->description }}
                                </p>

                                <!-- 4. Actions & Icon aligned -->
                                <div class="w-full flex items-center justify-between mt-2">
                                    <a href="{{ route('scholarship_details', ['id' => $scholarship->scholarshipID]) }}"
                                        class="btn-primary inline-flex items-center px-5 py-2 text-white rounded-full font-medium hover:bg-[var(--destructive)] transition-all duration-300">
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-[var(--primary)]/20 to-[var(--primary)]/40 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-[var(--primary)]" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253
                                                    m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13
                                                    C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Enhanced My Applications -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[var(--secondary)]">My Applications</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[var(--accent)] to-blue-600 rounded-full"></div>
            </div>
            <div class="card-base rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[var(--border)]">
                        <thead class="bg-gradient-to-r from-[var(--muted)] to-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-8 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">
                                    Application ID</th>
                                <th scope="col"
                                    class="px-8 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">
                                    Scholarship</th>
                                <th scope="col"
                                    class="px-8 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-8 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">
                                    Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[var(--border)]">
                            @foreach ($applicationUsers as $application)
                                <tr class="table-row hover:bg-[var(--muted)] transition-all duration-300">
                                    <td
                                        class="px-8 py-6 whitespace-nowrap text-sm font-semibold text-[var(--secondary)]">
                                        #{{ $application->applicationID }}</td>
                                    <td
                                        class="px-8 py-6 whitespace-nowrap text-sm font-medium text-[var(--foreground)]">
                                        {{ $application->scholarship->name }}</td>
                                    <td class="px-8 py-6 whitespace-nowrap text-sm">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full status-{{ strtolower($application->status) }}">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-8 py-6 whitespace-nowrap text-sm text-[var(--muted-foreground)] font-medium">
                                        {{ $application->submission_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Enhanced Recent Announcements -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[var(--secondary)]">Recent Announcements</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[var(--primary)] to-red-600 rounded-full"></div>
            </div>
            <div class="space-y-6">
                <div class="card-base rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-[var(--primary)]/10 to-[var(--primary)]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[var(--primary)]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[var(--foreground)] leading-relaxed">
                                <strong class="text-[var(--primary)] font-semibold">New Deadline Extension:</strong>
                                Application deadline for STEM Scholarship extended to 2025-04-01.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-base rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-[var(--accent)]/10 to-[var(--accent)]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[var(--accent)]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[var(--foreground)] leading-relaxed">
                                <strong class="text-[var(--primary)] font-semibold">Workshop Invitation:</strong>
                                Join our webinar on effective scholarship applications on 2025-03-20.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Enhanced Footer -->
    <footer class="bg-white/95 backdrop-blur-md py-8 border-t border-white/20 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm text-[var(--muted-foreground)] font-medium">
                &copy; 2025 DAFI Scholarship . All rights reserved. |
                <a href="mailto:info@DAFIcholarship.org"
                    class="text-[var(--primary)] hover:text-[var(--destructive)] transition-colors duration-300 font-semibold hover:underline">info@DAFIscholarship.org</a>
            </p>
        </div>
    </footer>
</body>

</html>
