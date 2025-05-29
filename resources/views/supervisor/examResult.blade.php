<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Crimson+Text:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #f9fafb;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: #1f2937;
            border-right: 1px solid #374151;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
        }

        .content {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            bottom: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow-y: auto;
        }

        .container { padding: 40px; }

        .page-header {
            border-bottom: 1px solid #e5e7eb;
            background: #f3f4f6;
            padding: 24px 40px;
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .control-section {
            margin-bottom: 16px;
        }

        .btn-primary {
            background: #111827;
            color: #ffffff;
            border: 1px solid #111827;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #1f2937;
            border-color: #1f2937;
        }

        /* Form grid: three columns */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-section,
        .import-section {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 24px;
            padding: 16px;
        }

        .section-title {
            background: #f3f4f6;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 500;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            margin: -16px -16px 16px;
        }

        .form-group label {
            color: #374151;
            font-size: 12px;
            margin-bottom: 4px;
            display: block;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129,140,248,0.1);
        }

        /* Import form inline */
        .import-section form {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
        }

        .import-section .form-group {
            flex: 1;
            min-width: 220px;
            margin-bottom: 0;
        }

        .import-section button {
            margin-bottom: 8px;
        }

        .data-table {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-header {
            background: #f3f4f6;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 12px;
            font-weight: 500;
            color: #6b7280;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 12px 16px;
            font-size: 14px;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .status-passed {
            background: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            display: inline-block;
        }

        .status-failed {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            display: inline-block;
        }

        .notification {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 16px;
            border-radius: 8px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        .notification.hide {
            opacity: 0;
            transform: translateX(100%);
        }

        .notification-icon {
            background: #dcfce7;
            color: #166534;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
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
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-amber-800 mb-2">Import Warnings</h4>
                        <ul class="text-sm text-amber-700 space-y-1">
                            @foreach (session('warnings') as $warn)
                                <li>• {{ $warn }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="control-section">
                    <button id="toggleForm" class="btn-primary">Add Exam Result</button>
                </div>

                @if ($eligibleApplications->isEmpty())
                    <div class="alert-info">
                        No eligible applications are currently available for this scholarship program.
                    </div>
                @else
                    <div id="examForm" class="form-section hidden">
                        <h3 class="section-title"> Record Examination Result</h3>
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
                                    @error('student_id')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="course">Course Title</label>
                                    <input type="text" name="course" id="course" required>
                                    @error('course')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="score">Examination Score</label>
                                    <input type="number" name="score" id="score" step="0.01" min="0" max="100" required>
                                    @error('score')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Result Status</label>
                                    <select name="status" id="status" required>
                                        <option value="passed">Passed</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                    @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="exam_date">Examination Date</label>
                                    <input type="date" name="exam_date" id="exam_date" required>
                                    @error('exam_date')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">Submit Result</button>
                        </form>
                    </div>
                @endif

                <div class="import-section">
                    <h3 class="section-title">Bulk Data Import</h3>
                    <form action="{{ route('examResult.importExcel', ['scholarshipID' => $scholarshipID]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file">Excel File Upload</label>
                            <input type="file" name="file" id="excel_file" accept=".xlsx,.xls" required>
                            @error('file')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn-primary">Import  Data</button>
                    </form>
                </div>

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
                                    <td class="{{ $exam->status === 'passed' ? 'status-passed' : 'status-failed' }}">{{ ucfirst($exam->status) }}</td>
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