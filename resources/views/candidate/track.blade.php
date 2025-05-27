<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Track Your Scholarship Application Status - ScholarPath Scholarship System" />
    <title>Track Application Status - ScholarPath Scholarship System</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .status-indicator {
            position: relative;
            padding-left: 1.5rem;
        }

        .status-indicator::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 9999px;
            background-color: var(--muted-foreground);
        }

        .status-indicator.completed::before {
            background-color: var(--accent);
        }

        .status-indicator.rejected::before {
            background-color: var(--destructive);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Modern Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-primary">ScholarPath Scholarship</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <a href="{{ route('candidate.dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-secondary hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('profile.show') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-secondary hover:bg-gray-50">Profile</a>
                    <a href="{{ route('logout') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-gray-50">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Back to Dashboard Button -->
            <div class="mb-6">
                <a href="{{ route('candidate.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Application Selector -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h1 class="text-2xl font-semibold text-secondary mb-6">Track Application Status</h1>

                <div class="mb-6">
                    <label for="application-select" class="block text-sm font-medium text-secondary mb-2">Select an
                        Application</label>
                    <form method="GET" action="{{ route('track_your_application') }}">
                        <select name="selected_application" id="application-select" onchange="this.form.submit()"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                            <option value="">-- Select an Application --</option>
                            @foreach ($applications as $application)
                                <option value="{{ $application->applicationID }}"
                                    {{ request('selected_application') == $application->applicationID || (!request('selected_application') && $loop->first) ? 'selected' : '' }}>
                                    Application #{{ $application->applicationID }} -
                                    {{ $application->scholarship->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @php
                    $selectedApplication = request('selected_application')
                        ? $applications->where('applicationID', request('selected_application'))->first()
                        : $applications->first();
                @endphp

                @if ($selectedApplication)
                    <!-- Status Timeline -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-medium text-secondary">Application Progress</h2>

                        <div class="border-l-2 border-gray-200 pl-6 space-y-6">
                            @foreach ($selectedApplication->applicationStages as $stage)
                                @php
                                    $pivot = $stage->pivot;
                                    $name = strtolower($stage->name);
                                    $statusClass = '';
                                    $statusText = '';

                                    if ($name === 'exam') {
                                        if ($selectedApplication->exam && $selectedApplication->exam->status) {
                                            $statusText = $selectedApplication->exam->status;
                                            if ($selectedApplication->exam->score) {
                                                $statusText .= " - Score: {$selectedApplication->exam->score}";
                                            }
                                            $statusClass =
                                                strtolower($selectedApplication->exam->status) === 'completed'
                                                    ? 'completed'
                                                    : 'rejected';
                                        } else {
                                            $statusText = 'Pending';
                                        }
                                    } elseif ($name === 'form') {
                                        if (
                                            $selectedApplication->applicationForm &&
                                            $selectedApplication->applicationForm->status
                                        ) {
                                            $statusText = $selectedApplication->applicationForm->status;
                                            $statusClass =
                                                strtolower($selectedApplication->applicationForm->status) ===
                                                'completed'
                                                    ? 'completed'
                                                    : 'rejected';
                                        } else {
                                            $statusText = 'Pending';
                                        }
                                    } elseif ($name === 'interview') {
                                        if (
                                            $selectedApplication->interview &&
                                            $selectedApplication->interview->status
                                        ) {
                                            $statusText = $selectedApplication->interview->status;
                                            $statusClass =
                                                strtolower($selectedApplication->interview->status) === 'completed'
                                                    ? 'completed'
                                                    : 'rejected';
                                        } else {
                                            $statusText = 'Pending';
                                        }
                                    } else {
                                        $statusText = $pivot->main_status ?? 'Pending';
                                        $statusClass = isset($pivot->main_status)
                                            ? (strtolower($pivot->main_status) === 'completed'
                                                ? 'completed'
                                                : 'rejected')
                                            : '';
                                    }
                                @endphp

                                <div class="status-indicator {{ $statusClass }}">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-secondary">{{ ucfirst($name) }}</span>
                                        <span
                                            class="text-sm {{ $statusClass === 'completed' ? 'text-accent' : ($statusClass === 'rejected' ? 'text-destructive' : 'text-muted-foreground') }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    @if ($pivot->status ?? false)
                                        <div class="text-sm text-muted-foreground mt-1">Result: {{ $pivot->status }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Final Result -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <span class="font-medium text-secondary mr-4">Final Result:</span>
                            @php
                                $finalStatus = strtolower($selectedApplication->status ?? 'pending');
                                $statusColor =
                                    $finalStatus === 'approved'
                                        ? 'bg-green-100 text-green-800'
                                        : ($finalStatus === 'rejected'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-gray-100 text-gray-800');
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}"
                                id="final-status">
                                {{ $selectedApplication->status ?? 'Pending' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-muted-foreground">No application found.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-4 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-muted-foreground">
            &copy; 2025 ScholarPath . All rights reserved. |
            <a href="mailto:info@ScholarPathscholarship.org"
                class="text-primary hover:text-secondary">info@ScholarPathscholarship.org</a>
        </div>
    </footer>
</body>
</html>
