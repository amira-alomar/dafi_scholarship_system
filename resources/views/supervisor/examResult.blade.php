<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b; line-height: 1.5; min-height: 100vh;
        }
        
        .main { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: 280px; background: #111827; border-right: 2px solid #374151;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
        }
        
        .content {
            flex: 1; background: #ffffff; margin: 20px; border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08); overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .container { padding: 40px; }
        
        .page-header {
            border-bottom: 2px solid #e5e7eb; padding-bottom: 24px; margin-bottom: 40px;
            background: linear-gradient(to right, #f9fafb, #ffffff); margin: -40px -40px 40px -40px;
            padding: 32px 40px 24px 40px;
        }
        
        .page-title {
            font-family: 'Crimson Text', serif; font-size: 32px; font-weight: 700;
            color: #111827; margin-bottom: 8px; letter-spacing: -0.025em;
        }
        
        .page-subtitle {
            color: #6b7280; font-size: 16px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a); border: 1px solid #f59e0b;
            border-radius: 6px; padding: 20px; margin-bottom: 24px; border-left: 4px solid #f59e0b;
        }
        
        .alert-warning strong {
            color: #92400e; display: block; margin-bottom: 12px; font-weight: 700;
            font-size: 16px;
        }
        
        .alert-warning ul { color: #92400e; margin-left: 20px; }
        
        .control-section {
            display: flex; gap: 16px; margin-bottom: 32px; padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #818CF8, #6366f1); color: #ffffff;
            border: none; padding: 12px 24px; border-radius: 6px; font-weight: 600;
            cursor: pointer; transition: all 0.2s ease; font-size: 14px;
            box-shadow: 0 2px 8px rgba(129, 140, 248, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(129, 140, 248, 0.4);
        }
        
        .import-section, .form-section {
            background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 28px; margin-bottom: 32px; border-left: 4px solid #818CF8;
        }
        
        .section-title {
            font-family: 'Crimson Text', serif; font-size: 20px; font-weight: 600;
            color: #111827; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;
        }
        
        .form-group { margin-bottom: 20px; }
        
        .form-group label {
            display: block; font-weight: 600; color: #374151; margin-bottom: 8px;
            font-size: 14px; text-transform: uppercase; letter-spacing: 0.025em;
        }
        
        .form-group input, .form-group select {
            width: 100%; padding: 12px 16px; border: 1px solid #d1d5db;
            border-radius: 6px; font-size: 14px; transition: all 0.2s ease;
            background: #ffffff;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none; border-color: #818CF8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
        }
        
        .text-danger { color: #DC2626; font-size: 13px; margin-top: 6px; font-weight: 500; }
        
        .form-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        
        .data-table {
            background: #ffffff; border-radius: 8px; overflow: hidden;
            border: 1px solid #e5e7eb; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }
        
        .table-header {
            background: linear-gradient(135deg, #f9fafb, #f3f4f6); padding: 24px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .table-title {
            font-family: 'Crimson Text', serif; font-size: 22px; font-weight: 600;
            color: #111827;
        }
        
        table { width: 100%; border-collapse: collapse; }
        
        th {
            background: #f9fafb; padding: 16px 20px; text-align: left; font-weight: 700;
            color: #374151; font-size: 13px; border-bottom: 1px solid #e5e7eb;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        
        td {
            padding: 16px 20px; border-bottom: 1px solid #f1f5f9; color: #4b5563;
            font-size: 14px;
        }
        
        tbody tr:hover { background: #f9fafb; }
        
        .status-passed { color: #059669; font-weight: 700; }
        .status-failed { color: #DC2626; font-weight: 700; }
        
        .hidden { display: none; }
        
        .not-available {
            text-align: center; padding: 80px 40px; color: #6b7280;
            background: linear-gradient(135deg, #f9fafb, #ffffff);
        }
        
        .not-available i { font-size: 48px; color: #DC2626; margin-bottom: 20px; }
        
        .alert-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe); border: 1px solid #3b82f6;
            color: #1e40af; padding: 20px; border-radius: 6px; text-align: center;
            font-weight: 600; border-left: 4px solid #3b82f6;
        }
        
        .notification {
            position: fixed; bottom: 32px; right: 32px; background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff; padding: 16px 24px; border-radius: 8px;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3); display: flex; align-items: center;
            gap: 12px; font-weight: 600; z-index: 1000; transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); opacity: 0;
        }
        
        .notification.show { transform: translateX(0); opacity: 1; }
        .notification.hide { transform: translateX(400px); opacity: 0; }
        
        .notification-icon {
            background: rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px;
            height: 32px; display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700;
        }
    </style>
</head>

<body class="main">
    <aside class="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </aside>

    <section class="content">
        @if (isset($message))
            <div class="not-available">
                <i class="fas fa-exclamation-triangle"></i>
                <h3 style="font-size: 28px; font-weight: 700; margin-bottom: 12px;">Service Unavailable</h3>
                <p style="font-size: 16px;">{{ $message }}</p>
            </div>
        @else
            <div class="container">
                <div class="page-header">
                    <h1 class="page-title">Examination Results Management</h1>
                    <p class="page-subtitle">Scholarship Program: {{ $scholarshipID }}</p>
                </div>

                @if (session('warnings'))
                    <div class="alert-warning">
                        <strong>⚠ Administrative Review Required</strong>
                        <ul>
                            @foreach (session('warnings') as $warn)
                                <li>{{ $warn }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="control-section">
                    <button id="toggleForm" class="btn-primary">Add Individual Result</button>
                </div>

                <div class="import-section">
                    <h3 class="section-title">📊 Bulk Data Import</h3>
                    <form action="{{ route('examResult.importExcel', ['scholarshipID' => $scholarshipID]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file">Excel File Upload (student_id, course, score, status, exam_date)</label>
                            <input type="file" name="file" id="excel_file" accept=".xlsx,.xls" required>
                            @error('file')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn-primary">Import Excel Data</button>
                    </form>
                </div>

                @if ($eligibleApplications->isEmpty())
                    <div class="alert-info">
                        No eligible applications are currently available for this scholarship program.
                    </div>
                @else
                    <div id="examForm" class="form-section hidden">
                        <h3 class="section-title">✏️ Record Examination Result</h3>
                        <form action="{{ route('examResult.store', ['scholarshipID' => $scholarshipID]) }}" method="POST">
                            @csrf
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="student_id">Student Selection</label>
                                    <select name="student_id" id="student_id" required>
                                        <option value="" disabled selected>Select a student</option>
                                        @foreach ($eligibleApplications as $application)
                                            <option value="{{ $application->application->user->id }}">
                                                {{ $application->application->user->id . ' - ' . $application->application->user->fname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="course">Course Title</label>
                                    <input type="text" name="course" id="course" required>
                                    @error('course')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="score">Examination Score</label>
                                    <input type="number" name="score" id="score" step="0.01" min="0" max="100" required>
                                    @error('score')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Result Status</label>
                                    <select name="status" id="status" required>
                                        <option value="passed">Passed</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Examination Date</label>
                                    <input type="date" name="exam_date" id="exam_date" required>
                                    @error('exam_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">Submit Result</button>
                        </form>
                    </div>
                @endif

                <div class="data-table">
                    <div class="table-header">
                        <h3 class="table-title">Examination Results Registry</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Result ID</th>
                                <th>Student Name</th>
                                <th>Course</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Exam Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>{{ $exam->examID }}</td>
                                    <td>{{ $exam->application?->user?->fname . ' ' . $exam->application?->user?->lname }}</td>
                                    <td>{{ $exam->course }}</td>
                                    <td>{{ $exam->score }}%</td>
                                    <td class="{{ $exam->status === 'passed' ? 'status-passed' : 'status-failed' }}">
                                        {{ ucfirst($exam->status) }}
                                    </td>
                                    <td>{{ $exam->exam_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if (session('success'))
                <div id="notification" class="notification">
                    <div class="notification-icon">✓</div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('exam_date').value = new Date().toISOString().split('T')[0];
                    
                    const toggleBtn = document.getElementById('toggleForm');
                    const form = document.getElementById('examForm');
                    
                    toggleBtn.addEventListener('click', () => {
                        form.classList.toggle('hidden');
                        toggleBtn.textContent = form.classList.contains('hidden') ? 'Add Individual Result' : 'Hide Form';
                    });

                    const notification = document.getElementById('notification');
                    if (notification) {
                        setTimeout(() => notification.classList.add('show'), 100);
                        setTimeout(() => {
                            notification.classList.add('hide');
                            setTimeout(() => notification.remove(), 400);
                        }, 3000);
                    }
                });
            </script>
        @endif
    </section>
</body>
</html>