<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8 space-y-6">
            @if (!$examClosed)
                <div class="max-w-3xl mx-auto bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg">
                    <p class="font-medium">Sorry, the Interview stage can’t start yet—there are still pending applicants
                        in Exam.</p>
                </div>
            @else
                @if (isset($message))
                    <div class="max-w-3xl mx-auto bg-white rounded-lg p-8 text-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto mb-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M5.05 13a7 7 0 119.9-9.9" />
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">Not Available</h3>
                        <p class="text-gray-600">{{ $message }}</p>
                    </div>
                @else
                    <div class="max-w-7xl mx-auto">
                        <!-- Header -->
                        <div
                            class="bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">Interview Invitation</h1>
                                <p class="text-gray-600 mt-1">Scholarship ID: <span
                                        class="font-medium text-indigo-600">{{ $scholarshipID }}</span></p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                @if (session('success'))
                                    <div class="inline-block bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-2 rounded fade-in"
                                        role="alert">
                                        <p>{{ session('success') }}</p>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="inline-block bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-2 rounded fade-in"
                                        role="alert">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Interview Cards -->
                        <div class="space-y-6">
                            @forelse ($eligibleApplications as $progress)
                                <form action="{{ route('supervisor.endInterviewStage', $scholarshipID) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        End Interview Stage (Reject All Pending)
                                    </button>
                                </form>
                                <div
                                    class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow p-6 flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                                    <!-- Info -->
                                    <div class="flex-1">
                                        <h2 class="text-xl font-semibold text-gray-800">
                                            {{ $progress->application->user->fname }}
                                            {{ $progress->application->user->lname }}</h2>
                                        <p class="text-gray-600 mt-1"><span class="font-medium">Email:</span>
                                            {{ $progress->application->user->email }}</p>
                                        <div class="mt-2">
                                            <span
                                                class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $progress->application->stageProgress->first() ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $progress->application->stageProgress->first()->status ?? 'Not Scheduled' }}
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        @if ($progress->application->stageProgress->isNotEmpty())
                                            <button disabled
                                                class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Scheduled</button>
                                        @else
                                            <div x-data="{ open: false }">
                                                <button @click="open = true"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Schedule</button>
                                                <!-- Modal -->
                                                <div x-show="open"
                                                    class="fixed inset-0 flex items-center justify-center modal-overlay fade-in">
                                                    <div
                                                        class="bg-white rounded-lg modal-container p-6 w-full max-w-md mx-auto shadow-lg">
                                                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Schedule
                                                            Interview</h3>
                                                        <form
                                                            action="{{ route('interview.schedule', ['applicationID' => $progress->application->applicationID]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="mb-4">
                                                                <label class="block text-gray-700 mb-1">Interview Date &
                                                                    Time</label>
                                                                <input type="datetime-local" name="interview_date"
                                                                    required
                                                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="block text-gray-700 mb-1">Location</label>
                                                                <input type="text" name="interview_location" required
                                                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="block text-gray-700 mb-1">Details
                                                                    <small>(optional)</small></label>
                                                                <textarea name="interview_details" rows="3"
                                                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                                                                    placeholder="Anything extra…"></textarea>
                                                            </div>
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button" @click="open = false"
                                                                    class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 transition">Cancel</button>
                                                                <button type="submit"
                                                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Send
                                                                    & Email</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <a href="{{ route('interview.details', ['studentID' => $progress->application->idUser]) }}"
                                            class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition text-center">Details</a>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white rounded-lg shadow p-6 text-center">
                                    <p class="text-gray-600">No eligible students found for interviews.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            @endif
        </main>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Auto-dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(el => el.remove());
        }, 3000);
    </script>
</body>

</html>
