<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            background-color: var(--background);
            font-family: var(--font-sans);
            display: flex;
            overflow: hidden;
        }

        .application-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
    </style>
</head>

<body>
    <!-- Sidebar (flex child #1) -->
    @include('include.sidebar', ['scholarshipID' => $scholarshipId])

    <!-- Main Content (flex child #2) -->
    <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-[var(--foreground)]">Student Applications</h1>
            <div class="text-sm text-[var(--muted-foreground)]">
                <i class="fas fa-info-circle mr-1"></i> {{ count($applications) }} applications found
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($applications as $app)
                <div
                    class="application-card bg-[var(--card)] rounded-lg shadow-sm p-6 border border-[var(--border)] transition">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <a href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipId, 'applicationID' => $app->applicationID]) }}"
                                class="text-lg font-semibold text-[var(--accent)] hover:text-[var(--primary)] transition">
                                {{ $app->user->fname . ' ' . $app->user->lname ?? 'Unknown' }}
                            </a>
                            <p class="text-sm text-[var(--muted-foreground)] mt-1">
                                <i class="fas fa-award mr-1"></i> {{ $app->scholarship->name ?? 'No Scholarship' }}
                            </p>
                        </div>
                    </div>
            @endforeach
        </div>

        @if (count($applications) === 0)
            <div class="py-12 text-center">
                <div class="bg-[var(--card)] rounded-lg shadow-sm p-8 max-w-md mx-auto">
                    <i class="fas fa-folder-open text-4xl text-[var(--muted-foreground)] mb-4"></i>
                    <h3 class="text-lg font-medium text-[var(--foreground)] mb-2">No applications found</h3>
                    <p class="text-sm text-[var(--muted-foreground)]">There are currently no student applications to
                        display.</p>
                </div>
            </div>
        @endif
    </main>
</body>

</html>