<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .modal-container {
            z-index: 50;
            transform: translate(-50%, -50%);
        }

        .fade-in {
            animation: fadeIn 0.2s ease-in-out;
        }

        /* exam.css */
        .content {
            flex: 1;
            overflow-y: auto;
            width: 100%;
        }

        .layout {
            display: flex;
            height: 100vh;
            /* Full height of viewport */
            overflow: hidden;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="layout">

        <div class="sidebar">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </div>
        @if (!$examClosed)
            <div class="alert alert-warning">
                Sorry, the Interview stage can’t start yet—there are still pending applicants in Exam.
            </div>
        @else
            <div class="content">
                @if (isset($message))
                    <div class="bg-light-gray rounded-lg p-8 text-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Not available</h3>
                        <p class="text-gray-600 mt-2">{{ $message }}</p>
                    </div>
                @else
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">Interview Invitation</h1>
                            <h2 class="text-lg font-medium text-gray-600">Scholarship {{ $scholarshipID }}</h2>
                        </div>

                        <!-- Success/Error Messages -->
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded fade-in"
                                role="alert">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded fade-in"
                                role="alert">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        <!-- Interview List -->
                        <div class="space-y-4">
                            @if (isset($message))
                                <div class="content">
                                    <div class="container mx-auto px-0 max-w-full">
                                        <div class="flex items-center justify-center h-screen w-full">
                                            <div class="bg-light-gray rounded-lg p-8 text-center shadow-lg">
                                                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                                                <h3 class="text-xl font-semibold text-gray-800">Not available</h3>
                                                <p class="text-gray-600 mt-2">{{ $message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @forelse ($eligibleApplications as $progress)
                                    <form action="{{ route('supervisor.endInterviewStage', $scholarshipID) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            End Interview Stage (Reject All Pending)
                                        </button>
                                    </form>

                                    <div
                                        class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
                                        <div class="p-6">
                                            <div
                                                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                                <!-- Student Info -->
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold text-gray-800">
                                                        {{ $progress->application->user->fname . ' ' . $progress->application->user->lname }}
                                                    </h3>
                                                    <p class="text-gray-600 mt-1">
                                                        <span class="font-medium">Email:</span>
                                                        {{ $progress->application->user->email }}
                                                    </p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $progress->application->stageProgress->first() ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                            {{ $progress->application->stageProgress->first()->status ?? 'Not Scheduled' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- Actions -->
                                                <div class="flex flex-col sm:flex-row gap-3">
                                                    @if ($progress->application->stageProgress->isNotEmpty())
                                                        <button
                                                            class="px-4 py-2 bg-gray-200 text-gray-600 rounded-md cursor-not-allowed"
                                                            disabled>
                                                            Scheduled
                                                        </button>
                                                    @else
                                                        <form
                                                            action="{{ route('interview.schedule', ['applicationID' => $progress->application->applicationID]) }}"
                                                            method="POST" class="flex">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-4 py-2 bg-[#e05252] hover:bg-[#c04a4a] text-white rounded-md transition-colors duration-200">
                                                                Schedule
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('interview.details', ['studentID' => $progress->application->idUser]) }}"
                                                        class="px-4 py-2 bg-[#16a3b8] hover:bg-[#138a9c] text-white rounded-md text-center transition-colors duration-200">
                                                        Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                                        <p class="text-gray-600">No eligible students found for interviews.</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                @endif
            </div>

    </div>
    @endif
    <script>
        // Auto-dismiss alerts after 3 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 300);
            });
        }, 3000);
    </script>
</body>

</html>
