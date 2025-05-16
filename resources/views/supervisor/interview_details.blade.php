<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer base {
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
            }
        }

        @layer components {
            .btn-primary {
                @apply bg-[var(--primary)] text-[var(--primary-foreground)] px-4 py-2 rounded-[var(--radius)] hover:opacity-90 transition-opacity;
            }

            .btn-success {
                @apply bg-green-600 text-white px-4 py-2 rounded-[var(--radius)] hover:opacity-90 transition-opacity;
            }

            .btn-danger {
                @apply bg-[var(--destructive)] text-white px-4 py-2 rounded-[var(--radius)] hover:opacity-90 transition-opacity;
            }

            .card {
                @apply bg-[var(--card)] text-[var(--card-foreground)] p-6 rounded-lg shadow-sm border border-[var(--border)];
            }

            .info-label {
                @apply text-[var(--muted-foreground)] text-sm font-medium;
            }

            .info-value {
                @apply text-[var(--foreground)] font-medium;
            }
        }
    </style>
</head>

<body class="bg-[var(--background)] min-h-screen font-sans">
    <!-- Top Navigation Bar -->
    <nav class="bg-[var(--secondary)] text-[var(--secondary-foreground)] px-6 py-4 shadow-sm">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-semibold">Interview Management</h1>
            {{-- <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 bg-[var(--primary)] hover:bg-opacity-90 text-white px-4 py-2 rounded-[var(--radius)] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back to Dashboard
            </a> --}}
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="card mb-8">
            <h2 class="text-2xl font-bold text-[var(--foreground)] mb-2">Interview Details</h2>
            <h3 class="text-xl font-semibold text-[var(--accent)] mb-6">{{ $student->fname . ' ' . $student->lname }}
            </h3>

            @if (!$interview)
                <div class="bg-[var(--muted)] text-[var(--muted-foreground)] p-4 rounded-[var(--radius)]">
                    No interview scheduled for this student.
                </div>
            @else
                <div class="space-y-4">
                    <div>
                        <p class="info-label">Interview Date</p>
                        <p class="info-value">{{ $interview->interview_date }}</p>
                    </div>
                    <div>
                        <p class="info-label">Status</p>
                        <p class="info-value capitalize">{{ $interview->status }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="card">
            <h3 class="text-lg font-semibold text-[var(--foreground)] mb-4">Interview Actions</h3>

            @if ($stageProgress->status === 'pending')
                <div class="flex flex-wrap gap-4">
                    {{-- Accept --}}
                    <form action="{{ route('interview.accept', ['studentID' => $student->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-success flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0
                             011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Accept
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form action="{{ route('interview.reject', ['studentID' => $student->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-danger flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0
                             111.414 1.414L11.414 10l4.293 4.293a1 1 0
                             01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0
                             01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Reject
                        </button>
                    </form>
                </div>
            @else
                <div
                    class="p-4 rounded-[var(--radius)] 
        @if ($stageProgress->status === 'accepted') bg-green-100 text-green-800 
        @else bg-red-100 text-red-800 @endif">
                    Interview has been <strong>{{ $stageProgress->status }}</strong>.
                </div>
            @endif

        </div>
    </main>
</body>

</html>
