<!-- resources/views/supervisor/examResult.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results Submission</title>
    <link rel="stylesheet" href="{{ asset('css/examResult.css') }}">
    <style>

    </style>
</head>

<body class="main">

    <aside class="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </aside>
    <section class="content">
        @if (isset($message))
            <div class="bg-light-gray rounded-lg p-8 text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800">Not available</h3>
                <p class="text-gray-600 mt-2">{{ $message }}</p>
            </div>
        @else
            <div class="container">
                <h2>Exam Result for Scholarship ID: {{ $scholarshipID }}</h2>

                @if (session('success'))
                    <div class="alert-success" id="success-message">
                        <span>✓</span> {{ session('success') }}
                    </div>
                @endif
                @if (session('warnings'))
                    <div class="alert-warning mt-4 p-4 bg-yellow-100 text-yellow-800 rounded">
                        <strong>Warnings:</strong>
                        <ul class="list-disc ml-6">
                            @foreach (session('warnings') as $warn)
                                <li>{{ $warn }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button id="toggleForm" class="btn-primary">Add Exam Result</button>
                <hr class="my-6">

                {{-- Excel Import Form --}}
                <form action="{{ route('examResult.importExcel', ['scholarshipID' => $scholarshipID]) }}" method="POST"
                    enctype="multipart/form-data" class="mb-6">
                    @csrf
                    <div class="form-group">
                        <label for="excel_file" class="font-semibold">📑 Upload Excel (student_id, course, score,
                            status, exam_date):</label>
                        <input type="file" name="file" id="excel_file" accept=".xlsx,.xls" required
                            class="block mt-1">
                        @error('file')
                            <div class="text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary mt-2">Import from Excel</button>
                </form>

                @if ($eligibleApplications->isEmpty())
                    <div class="alert-info">
                        no eligible applications for this scholarship.
                    </div>
                @else
                    <form id="examForm" class="hidden"
                        action="{{ route('examResult.store', ['scholarshipID' => $scholarshipID]) }}" method="POST">
                        @csrf
                        <!-- student select -->
                        <div class="form-group">
                            <label for="student_id">Select Student</label>
                            <select name="student_id" id="student_id" required>
                                <option value="" disabled selected>Select a student</option>
                                @foreach ($eligibleApplications as $application)
                                    <option value="{{ $application->application->user->id }}">
                                        {{ $application->application->user->id . '- ' . $application->application->user->fname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="text-danger"><span>⚠</span> {{ $message }}</div>
                            @enderror
                        </div>
                        <!-- باقي الحقول -->
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" name="course" id="course" required>
                            @error('course')
                                <div class="text-danger"><span>⚠</span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="score">Score</label>
                            <input type="number" name="score" id="score" step="0.01" min="0"
                                max="100" required>
                            @error('score')
                                <div class="text-danger"><span>⚠</span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" required>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                            </select>
                            @error('status')
                                <div class="text-danger"><span>⚠</span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exam_date">Exam Date</label>
                            <input type="date" name="exam_date" id="exam_date" required>
                            @error('exam_date')
                                <div class="text-danger"><span>⚠</span> {{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn-primary">Submit</button>
                    </form>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
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
                                <td>
                                    {{ $exam->application?->user?->fname . ' ' . $exam->application?->user?->lname }}
                                </td>
                                <td>{{ $exam->course }}</td>
                                <td>{{ $exam->score }}</td>
                                <td>{{ ucfirst($exam->status) }}</td>
                                <td>{{ $exam->exam_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('exam_date').value = new Date().toISOString().split('T')[0];

                    const toggleBtn = document.getElementById('toggleForm');
                    const form = document.getElementById('examForm');

                    toggleBtn.addEventListener('click', () => form.classList.toggle('hidden'));

                    const successMsg = document.getElementById('success-message');
                    if (successMsg) {
                        setTimeout(() => {
                            successMsg.remove();
                            form.classList.add('hidden');
                        }, 5000);
                    }
                });
            </script>
        @endif
    </section>
</body>

</html>
