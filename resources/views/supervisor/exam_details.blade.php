<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .notification {
            animation: slideInRight 0.4s ease-out, fadeOut 0.3s ease-in 2.7s forwards;
            transform: translateX(100%);
        }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .card-hover:hover {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }

        .status-accepted {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }

        .status-rejected {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }

        .layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 leading-relaxed">
    <div class="layout">
        <aside class="w-64 bg-white border-r border-gray-200 shadow-sm">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </aside>

        <main class="flex-1 overflow-y-auto">
            <div class="max-w-5xl mx-auto px-8 py-8 space-y-8">
                <header class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 mb-2">Exam Assessment</h1>
                            <p class="text-gray-600">Comprehensive evaluation and decision management</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Candidate Profile</p>
                            <p class="text-lg font-medium text-gray-900">{{ $student->fname }} {{ $student->lname }}</p>
                        </div>
                    </div>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <section
                            class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover transition-all duration-200">
                            <div class="p-8">
                                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Exam Details
                                </h2>

                                @if ($exam)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-6">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-2">Candidate
                                                    Name</label>
                                                <p class="text-lg font-medium text-gray-900">{{ $student->fname }}
                                                    {{ $student->lname }}</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-2">Course</label>
                                                <p class="text-lg font-medium text-gray-900">{{ $exam->course ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-6">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-2">Score</label>
                                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                    {{ $exam->score ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                                                <span
                                                    class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                                                    {{ strtolower($exam->status) === 'passed'
                                                        ? 'bg-green-100 text-green-800 border border-green-200'
                                                        : (strtolower($exam->status) === 'failed'
                                                            ? 'bg-red-100 text-red-800 border border-red-200'
                                                            : 'bg-yellow-100 text-yellow-800 border border-yellow-200') }}">
                                                    {{ ucfirst($exam->status ?? 'N/A') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-500 mb-3">Exam Date</label>
                                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                <p class="text-gray-900 leading-relaxed">
                                                    {{ $exam->exam_date ?? 'No exam date provided.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Exam Record Found</h3>
                                        <p class="text-gray-600">Exam has not been scheduled or completed for this
                                            candidate.</p>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    <div class="space-y-6">
                      @if($exam)
                        <section
                            class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover transition-all duration-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Decision Actions
                                </h3>

                                @if ($stageProgress->status === 'pending')
                                    <div class="space-y-3">
                                        <form action="{{ route('exam.approve', ['studentID' => $student->id, 'scholarshipID' => $scholarshipID]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve Candidate
                                            </button>
                                        </form>

                                        <form action="{{ route('exam.reject', ['studentID' => $student->id, 'scholarshipID' => $scholarshipID]) }}" 
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject Candidate
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div
                                        class="p-4 rounded-lg border-2 {{ $stageProgress->status === 'accepted' ? 'status-accepted border-green-200' : 'status-rejected border-red-200' }}">
                                        <div class="flex items-center">
                                            @if ($stageProgress->status === 'accepted')
                                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-red-600 mr-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                            <div>
                                                <p
                                                    class="font-semibold {{ $stageProgress->status === 'accepted' ? 'text-green-800' : 'text-red-800' }}">
                                                    Decision Finalized
                                                </p>
                                                <p
                                                    class="text-sm {{ $stageProgress->status === 'accepted' ? 'text-green-700' : 'text-red-700' }}">
                                                    Candidate has been <strong>{{ $stageProgress->status }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @else
                                <div class="p-6 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-600">No decision has been made yet.</p>
                                </div>
                            @endif
                        </section>

                        <section class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Status
                                Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-600">Current Stage</span>
                                    <span class="text-sm font-medium text-gray-900">Exam</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-sm text-gray-600">Status</span>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                        {{ $stageProgress->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($stageProgress->status === 'accepted'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($stageProgress->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600">Last Updated</span>
                                    <span class="text-sm font-medium text-gray-900">{{ date('M j, Y') }}</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @if (session('success'))
        <div class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg notification z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-6 right-6 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg notification z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <script>
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(el => {
                el.style.animation = 'fadeOut 0.3s ease-in forwards';
                setTimeout(() => el.remove(), 300);
            });
        }, 5000);
    </script>
</body>

</html>