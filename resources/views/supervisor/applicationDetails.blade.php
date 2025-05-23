<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
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
        }

        body {
            background-color: var(--background);
            color: var(--foreground);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
        }

        .btn-accent {
            background-color: var(--accent);
            color: var(--accent-foreground);
        }

        .btn-destructive {
            background-color: var(--destructive);
            color: var(--destructive-foreground);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white overflow-y-auto flex-shrink-0">
        @include('include.sidebar', ['scholarshipID' => $scholarshipId])
    </aside>
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-gray-900">Application Portal</span>
                    </div>
                    {{-- <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium btn-secondary hover:opacity-90 transition">
                        Back to Dashboard
                    </a>
                </div> --}}
                </div>
            </div>
        </nav>
        <section class="flex-1 overflow-y-auto w-full px-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Main Container -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-900">Application Details</h2>
                    </div>

                    <!-- Application Content -->
                    <div class="divide-y divide-gray-200">
                        <!-- Application Answers Section -->
                        <div class="px-6 py-5">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Application Answers</h3>
                            <div class="space-y-6">
                                @foreach ($application->answers as $answer)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="font-medium text-gray-900">{{ $answer->question->question_text }}</p>
                                        <p class="mt-1 text-gray-700">{{ $answer->answer_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Uploaded Documents Section -->
                        <div class="px-6 py-5">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Uploaded Documents</h3>
                            <div class="space-y-6">
                                @forelse ($requiredDocuments as $requiredDoc)
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-3">
                                            <h4 class="font-medium text-gray-900">{{ $requiredDoc->name }}
                                                ({{ $requiredDoc->type }})
                                            </h4>
                                        </div>
                                        <div class="px-4 py-3">
                                            @forelse ($requiredDoc->documents as $doc)
                                                <div class="flex items-center justify-between py-2">
                                                    <div>
                                                        <a href="{{ route('download.document.view', ['path' => basename($doc->document_path)]) }}"
                                                            target="_blank"
                                                            class="text-blue-600 hover:text-blue-800 hover:underline">
                                                            {{ $doc->document_name }}
                                                        </a>
                                                    </div>
                                                    <a href="{{ route('download.document', ['path' => basename($doc->document_path)]) }}"
                                                        download
                                                        class="px-3 py-1 rounded text-sm btn-accent hover:opacity-90 transition">
                                                        Download
                                                    </a>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 italic">No document uploaded</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No required documents found for this application.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- supervisor/applicationDetails.blade.php --}}
                        <div class="px-6 py-5 bg-gray-50">
                            <div class="flex space-x-4">
                                @php
                                    // if there was no record, default to pending
                                    $status = $formProgress->status ?? 'pending';
                                @endphp

                                @if ($status === 'pending')
                                    <form
                                        action="{{ route('application.approve', [
                                            'scholarshipId' => $scholarshipId,
                                            'applicationID' => $application->applicationID,
                                        ]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary">Approve</button>
                                    </form>
                                    <form
                                        action="{{ route('application.reject', [
                                            'scholarshipId' => $scholarshipId,
                                            'applicationID' => $application->applicationID,
                                        ]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn-destructive">Reject</button>
                                    </form>
                                @elseif ($status === 'accepted')
                                    <p class="text-success">✓ Application Accepted</p>
                                @elseif ($status === 'rejected')
                                    <p class="text-danger">✗ Application Rejected</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
