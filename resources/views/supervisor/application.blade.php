<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            letter-spacing: -0.025em;
        }
        
        .application-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(156, 163, 175, 0.2);
        }
        
        .application-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #4f46e5;
        }
        
        .page-header {
            border-bottom: 1px solid rgba(156, 163, 175, 0.3);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .stats-badge {
            background: rgba(79, 70, 229, 0.1);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .action-button {
            transition: all 0.2s ease-in-out;
            font-weight: 500;
            letter-spacing: 0.025em;
        }
        
        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
        }
        
        .student-link {
            transition: color 0.2s ease-in-out;
            font-weight: 500;
        }
        
        .student-link:hover {
            color: #818CF8;
            text-decoration: underline;
            text-decoration-color: #818CF8;
            text-underline-offset: 3px;
        }
        
        .empty-state {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 1px solid rgba(156, 163, 175, 0.3);
        }
        
        .sidebar-space {
            width: 280px;
            flex-shrink: 0;
        }
        
        @media (max-width: 768px) {
            .sidebar-space {
                width: 0;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-900 min-h-screen flex">
    <!-- Sidebar Placeholder -->
    <div class="sidebar-space">
        @include('include.sidebar', ['scholarshipID' => $scholarshipId])
    </div>

    <!-- Main Content -->
    <main class="flex-1 min-h-screen">
        <!-- Page Header -->
        <header class="page-header px-8 py-6 mb-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 tracking-tight">
                            Student Applications
                        </h1>
                        <p class="text-gray-600 text-sm font-light">
                            Review and manage scholarship applications
                        </p>
                    </div>
                    <div class="stats-badge px-4 py-2 rounded-lg">
                        <div class="flex items-center gap-2 text-indigo-600">
                            <i class="fas fa-chart-bar text-sm"></i>
                            <span class="text-sm font-medium">{{ count($applications) }} Applications</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="px-8 pb-8">
            <div class="max-w-7xl mx-auto">
                <!-- Action Section -->
                <div class="mb-8">
                    <form action="{{ route('supervisor.endFormStage', $scholarshipId) }}" method="POST">
                        @csrf
                        <button type="submit" class="action-button bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center gap-2">
                            <i class="fas fa-times-circle text-sm"></i>
                            End "Form" Stage (Reject All Pending)
                        </button>
                    </form>
                </div>

                <!-- Applications List -->
                <div class="space-y-4">
                    @foreach ($applications as $app)
                        <div class="application-card bg-white rounded-lg p-6 border border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="mb-3">
                                        <a href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipId, 'applicationID' => $app->applicationID]) }}" 
                                           class="student-link text-xl text-gray-900 hover:text-indigo-600">
                                            {{ $app->user->fname . ' ' . $app->user->lname ?? 'Unknown Applicant' }}
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-graduation-cap text-sm"></i>
                                        <span class="text-sm font-light">
                                            {{ $app->scholarship->name ?? 'No Scholarship Assigned' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <a href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipId, 'applicationID' => $app->applicationID]) }}" 
                                       class="text-indigo-600 hover:text-gray-900 font-medium text-sm inline-flex items-center gap-2 transition-colors">
                                        View Details
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State -->
                @if (count($applications) === 0)
                    <div class="py-16 text-center">
                        <div class="empty-state rounded-xl p-12 max-w-md mx-auto">
                            <div class="mb-6">
                                <i class="fas fa-folder-open text-5xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-3">
                                No Applications Found
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed font-light">
                                There are currently no student applications to review. 
                                Applications will appear here once students begin submitting their forms.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>

</html>