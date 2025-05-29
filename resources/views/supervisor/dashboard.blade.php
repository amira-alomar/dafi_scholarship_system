<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome – Scholarship Supervisor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --background: #F9FAFB;
            /* light-bg */
            --foreground: #111827;
            /* text-color */
            --card: #ffffff;
            --card-foreground: #111827;
            /* text-color */
            --primary: #4F46E5;
            /* primary-color */
            --primary-foreground: #ffffff;
            --secondary: #10B981;
            /* secondary-color */
            --secondary-foreground: #ffffff;
            --muted: #F3F4F6;
            /* قريب من light-bg */
            --muted-foreground: #6B7280;
            /* muted-text */
            --accent: #F59E0B;
            /* accent-color */
            --accent-foreground: #ffffff;
            --destructive: #DC2626;
            /* darker red */
            --destructive-foreground: #ffffff;
            --border: #E5E7EB;
            /* light border */
            --input: #E5E7EB;
            --radius: 0.5rem;
            --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--foreground);
            font-family: var(--font-sans);
        }

        /* Ripple Effect */
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 600ms linear;
            background-color: rgba(255, 255, 255, 0.4);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: var(--radius);
        }

        /* Override Tailwind defaults with CSS variables */
        .bg-primary {
            background-color: var(--primary) !important;
        }

        .text-primary-foreground {
            color: var(--primary-foreground) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .text-secondary-foreground {
            color: var(--secondary-foreground) !important;
        }

        .bg-card {
            background-color: var(--card) !important;
        }

        .text-card-foreground {
            color: var(--card-foreground) !important;
        }

        .border-default {
            border-color: var(--border) !important;
        }

        .focus-ring {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.5);
            /* primary-colored glow */
            outline: none;
        }

        .new h2 {
            text-shadow: 0 0 8px rgba(79, 70, 229, 0.8);
            /* primary shadow */
        }
    </style>


</head>

<body class="h-full flex flex-col">

    <!-- Navbar -->
    <header class="sticky top-0 z-20 bg-card border-b border-default">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-graduation-cap text-3xl text-card-foreground"></i>
                <h1 class="text-2xl font-extrabold text-card-foreground">Dafi Scholarship</h1>
            </div>

            <div class="flex items-center space-x-6">
                <div class="relative">
                    <input type="text" placeholder="Search scholarships…"
                        class="pl-12 pr-4 py-2 w-72 border border-default rounded-full bg-muted text- muted-foreground placeholder:muted-foreground focus:ring-0 focus-ring transition" />
                    <i
                        class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-muted-foreground"></i>
                </div>
                <span class="font-medium text-secondary-foreground">Supervisor</span>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="new bg-gradient-to-r from-muted to-secondary py-24">
        <div class="max-w-3xl mx-auto text-center px-6">
            <h2 class="text-5xl font-extrabold text-secondary-foreground mb-4 drop-shadow-lg">Welcome, Supervisor!</h2>
            <p class="text-lg text-muted-foreground">Here are the scholarships you’re currently overseeing.</p>
        </div>
    </section>

    <!-- Scholarship Grid -->
    <main class="flex-grow max-w-7xl mx-auto px-6 py-10">
        @if ($scholarships->isEmpty())
            <div class="py-24 bg-card rounded-2xl shadow-lg text-center">
                <i class="fas fa-user-graduate text-destructive text-6xl mb-6"></i>
                <p class="text-lg text-muted-foreground">No scholarships assigned yet.</p>
            </div>
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($scholarships as $scholarship)
                    <div
                        class="relative bg-card rounded-2xl shadow-lg overflow-hidden group transform hover:-translate-y-2 transition">
                        <!-- Decorative blob -->
                        <div
                            class="absolute -top-16 -right-16 w-40 h-40 bg-primary opacity-20 rounded-full group-hover:opacity-30 transition">
                        </div>

                        <div class="p-8 relative z-10 flex flex-col h-full">
                            <h3 class="text-2xl font-semibold text-card-foreground mb-6">{{ $scholarship->name }}</h3>
                            <div class="flex items-center mb-8">
                                <div class="p-4 bg-muted rounded-full">
                                    <i class="fas fa-users text-secondary text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-muted-foreground">Students Registered</p>
                                    <p class="text-3xl font-bold text-secondary-foreground">
                                        {{ $scholarship->students_count }}</p>
                                </div>
                            </div>
                            <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarship->scholarshipID]) }}"
                                class="mt-auto inline-block w-full text-center py-3 font-medium rounded-full bg-primary text-primary-foreground relative overflow-hidden focus:ring-0 focus-ring transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        // Ripple effect on buttons
        document.querySelectorAll('a').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const circle = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                circle.style.width = circle.style.height = size + 'px';
                circle.style.left = e.clientX - rect.left - size / 2 + 'px';
                circle.style.top = e.clientY - rect.top - size / 2 + 'px';
                circle.classList.add('ripple');
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(circle);
                setTimeout(() => circle.remove(), 600);
            });
        });
    </script>

</body>

</html>
