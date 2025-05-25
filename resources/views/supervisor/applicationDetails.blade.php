<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-shadow { box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08); }
        .btn-primary { background: #DC2626; transition: all 0.2s; }
        .btn-primary:hover { background: #B91C1C; transform: translateY(-1px); }
        .btn-secondary { background: #1F2937; transition: all 0.2s; }
        .btn-secondary:hover { background: #111827; transform: translateY(-1px); }
        .notification { 
            position: fixed; bottom: 1rem; right: 1rem; z-index: 50;
            transform: translateX(400px); opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .notification.show { transform: translateX(0); opacity: 1; }
        .fade-out { opacity: 0; transform: translateX(400px); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed w-64 h-full bg-gray-900 text-white overflow-y-auto">
        @include('include.sidebar', ['scholarshipID' => $scholarshipId])
    </aside>
    
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                        <p class="text-sm text-gray-600">Comprehensive review of submitted application materials</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="px-8 py-8">
            <div class="max-w-6xl mx-auto">
                <!-- Application Responses -->
                <section class="bg-white rounded-lg card-shadow mb-8">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Application Responses</h2>
                    </div>
                    <div class="px-8 py-6 space-y-6">
                        @foreach ($application->answers as $answer)
                            <div class="border-l-4 border-gray-900 pl-6 py-4">
                                <h3 class="font-medium text-gray-900 mb-3">{{ $answer->question->question_text }}</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $answer->answer_text }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Supporting Documentation -->
                <section class="bg-white rounded-lg card-shadow mb-8">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Supporting Documentation</h2>
                    </div>
                    <div class="px-8 py-6">
                        @forelse ($requiredDocuments as $requiredDoc)
                            <div class="border border-gray-200 rounded-lg mb-6 last:mb-0">
                                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-medium text-gray-900">{{ $requiredDoc->name }}</h3>
                                        <span class="px-3 py-1 text-xs font-medium text-gray-600 bg-white rounded-full border border-gray-200">
                                            {{ $requiredDoc->type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    @forelse ($requiredDoc->documents as $doc)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <a href="{{ route('download.document.view', ['path' => basename($doc->document_path)]) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-medium">
                                                    {{ $doc->document_name }}
                                                </a>
                                            </div>
                                            <a href="{{ route('download.document', ['path' => basename($doc->document_path)]) }}" download class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span>Download</span>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="text-center py-12">
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500">No document uploaded</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-lg">No required documents found for this application.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- Application Review -->
                <section class="bg-white rounded-lg card-shadow">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Application Review</h2>
                    </div>
                    <div class="px-8 py-6">
                        @php
                            $status = $formProgress->status ?? 'pending';
                        @endphp

                        @if ($status === 'pending')
                            <div class="flex space-x-4">
                                <form action="{{ route('application.approve', ['scholarshipId' => $scholarshipId, 'applicationID' => $application->applicationID]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary px-6 py-3 text-white rounded-lg font-medium flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Approve Application</span>
                                    </button>
                                </form>
                                <form action="{{ route('application.reject', ['scholarshipId' => $scholarshipId, 'applicationID' => $application->applicationID]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-secondary px-6 py-3 text-white rounded-lg font-medium flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span>Reject Application</span>
                                    </button>
                                </form>
                            </div>
                        @elseif ($status === 'accepted')
                            <div class="flex items-center px-6 py-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-green-800 font-semibold">Application Approved</p>
                            </div>
                        @elseif ($status === 'rejected')
                            <div class="flex items-center px-6 py-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <p class="text-red-800 font-semibold">Application Rejected</p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification bg-white border border-gray-200 rounded-lg card-shadow p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Action Completed</p>
                <p class="text-sm text-gray-600">Application status updated successfully</p>
            </div>
        </div>
    </div>

    <script>
        // Show notification if there's a success message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const notification = document.getElementById('notification');
                notification.classList.add('show');
                
                setTimeout(() => {
                    notification.classList.add('fade-out');
                }, 3000);
            });
        @endif
    </script>
</body>
</html>