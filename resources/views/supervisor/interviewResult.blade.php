<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Interview Scheduling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .notification { 
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1000; 
            transform: translateX(100%); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            opacity: 0; box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .notification.show { transform: translateX(0); opacity: 1; }
        .notification.hide { transform: translateX(100%); opacity: 0; }
        .card { background: white; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .btn-primary { 
            background: #111827; color: white; transition: all 0.2s ease;
            border: 1px solid #111827; font-weight: 500;
        }
        .btn-primary:hover { background: #1f2937; border-color: #1f2937; }
        .form-input { 
            border: 1px solid #d1d5db; background: white; transition: all 0.2s ease;
            font-size: 0.875rem;
        }
        .form-input:focus { 
            outline: none; border-color: #818cf8; 
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
        }
        .status-recommended { background: #dcfce7; color: #166534; }
        .status-not-recommended { background: #fee2e2; color: #991b1b; }
        .sidebar { 
            position: fixed; top: 0; bottom: 0; left: 0; width: 280px; z-index: 100;
            /* background: #111827; border-right: 1px solid #374151; */
        }
        .main-content { margin-left: 240px; min-height: 100vh; background: #f9fafb; }
        .overlay { 
            position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; 
            display: none; transition: opacity 0.3s ease;
        }
        .overlay.active { display: block; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
        .section-header { 
            border-bottom: 1px solid #e5e7eb; 
            background: linear-gradient(to right, #f8fafc, #ffffff);
        }
        .table-row:hover { background: #f8fafc; }
        .badge { 
            display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
            border-radius: 9999px; font-size: 0.75rem; font-weight: 500;
        }
        .performance-bad { background: #fef2f2; color: #991b1b; }
        .performance-good { background: #f0f9ff; color: #1e40af; }
        .performance-excellent { background: #f0fdf4; color: #166534; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </div>

    <div class="main-content">
        @if (isset($message))
            <div class="flex items-center justify-center min-h-screen p-6">
                <div class="max-w-md mx-auto text-center card rounded-lg p-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-50 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Stage Unavailable</h3>
                    <p class="text-gray-600">{{ $message }}</p>
                </div>
            </div>
        @else
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-2 tracking-tight">Interview Management</h1>
                    <p class="text-gray-600 text-lg">Scholarship Program #{{ $scholarshipID }}</p>
                </div>

                <div class="mb-6">
                    <button id="toggleForm" class="btn-primary px-6 py-2.5 rounded-md text-sm">
                        Schedule New Interview
                    </button>
                </div>

                <div class="card rounded-lg mb-6">
                    <div class="section-header px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900">Import Interview Results</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('interviewResult.importExcel', ['scholarshipID' => $scholarshipID]) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-4 items-end">
                            @csrf
                            <div class="flex-1 min-w-80">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Excel File</label>
                                <p class="text-xs text-gray-500 mb-2">Required columns: student_id, interview_date, performance_level, recommendation, notes</p>
                                <input type="file" name="file" accept=".xlsx,.xls" required class="form-input w-full py-2.5 px-3 rounded-md">
                                @error('file')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn-primary px-6 py-2.5 rounded-md text-sm">Import Data</button>
                        </form>
                    </div>
                </div>

                @if (session('warnings'))
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-amber-800 mb-2">Import Warnings</h4>
                        <ul class="text-sm text-amber-700 space-y-1">
                            @foreach (session('warnings') as $warn)
                                <li>• {{ $warn }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($eligible->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-yellow-800">No Eligible Candidates</h4>
                                <p class="text-sm text-yellow-700 mt-1">Candidates must pass the examination before scheduling interviews.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="intForm" class="hidden card rounded-lg mb-6">
                        <div class="section-header px-6 py-4">
                            <h3 class="text-lg font-medium text-gray-900">Schedule New Interview</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('interviewResult.store', ['scholarshipID' => $scholarshipID]) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                                        <select name="student_id" required class="form-input w-full py-2.5 px-3 rounded-md">
                                            <option value="">Select student...</option>
                                            @foreach ($eligible as $item)
                                                <option value="{{ $item->application->user->id }}">ID: {{ $item->application->user->id }} — {{ $item->application->user->fname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Interview Date</label>
                                        <input type="date" name="interview_date" required class="form-input w-full py-2.5 px-3 rounded-md" value="{{ now()->toDateString() }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Performance Level</label>
                                        <select name="performance_level" required class="form-input w-full py-2.5 px-3 rounded-md">
                                            <option value="">Select level...</option>
                                            <option value="bad">Poor</option>
                                            <option value="good">Good</option>
                                            <option value="excellent">Excellent</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Recommendation</label>
                                        <select name="recommendation" required class="form-input w-full py-2.5 px-3 rounded-md">
                                            <option value="">Select...</option>
                                            <option value="yes">Recommended</option>
                                            <option value="no">Not Recommended</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                        <textarea name="notes" rows="3" class="form-input w-full py-2.5 px-3 rounded-md" placeholder="Additional notes or comments..."></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn-primary px-6 py-2.5 rounded-md text-sm">Create Interview Record</button>
                            </form>
                        </div>
                    </div>
                @endif

                <div class="card rounded-lg overflow-hidden">
                    <div class="section-header px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900">Interview Records</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interview ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interview Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recommendation</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($interviews as $i)
                                    <tr class="table-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $i->interviewID }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i->application->user->fname }} {{ $i->application->user->lname }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i->interview_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="badge performance-{{ $i->performance_level }}">
                                                {{ $i->performance_level === 'bad' ? 'Poor' : ucfirst($i->performance_level) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="badge {{ $i->recommendation === 'yes' ? 'status-recommended' : 'status-not-recommended' }}">
                                                {{ $i->recommendation === 'yes' ? 'Recommended' : 'Not Recommended' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $i->notes ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="notification bg-white border border-gray-200 rounded-lg shadow-xl p-4 max-w-sm" id="notification">
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Operation Successful</h4>
                    <p class="text-xs text-gray-600 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.getElementById('toggleForm')?.addEventListener('click', () => {
            const form = document.getElementById('intForm');
            form?.classList.toggle('hidden');
        });

        const overlay = document.getElementById('overlay');
        const sidebar = document.getElementById('sidebar');
        
        overlay?.addEventListener('click', () => {
            sidebar?.classList.remove('open');
            overlay?.classList.remove('active');
        });

        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => notification.classList.add('show'), 200);
            setTimeout(() => {
                notification.classList.add('hide');
                setTimeout(() => notification.remove(), 400);
            }, 3000);
        }
    </script>
</body>
</html>