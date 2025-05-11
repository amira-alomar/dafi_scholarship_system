<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exam Results Submission</title>
    <link rel="stylesheet" href="{{ asset('css/examResult.css') }}">
</head>
<body>
    <!-- Enhanced Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            🎓 Scholarship Portal
        </div>
        <a href="{{ route('supervisor.dashboard') }}">
            <span>🏠</span> Back to Dashboard
        </a>
    </nav>

    <div class="container">
        <h2>Exam Result for Scholarship ID: {{ $scholarshipID }}</h2>

        @if(session('success'))
            <div class="alert-success">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('examResult.store', ['scholarshipID' => $scholarshipID]) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select name="student_id" id="student_id" required>
                    <option value="" disabled selected>Select a student</option>
                    @foreach ($eligibleApplications as $application)
                        <option value="{{ $application->application->user->id }}">
                            {{ $application->application->user->fname }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <div class="text-danger">
                        <span>⚠</span> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" name="course" id="course" required>
                @error('course')
                    <div class="text-danger">
                        <span>⚠</span> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="score">Score</label>
                <input type="number" name="score" id="score" step="0.01" min="0" max="100" required>
                @error('score')
                    <div class="text-danger">
                        <span>⚠</span> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="passed">Passed</option>
                    <option value="failed">Failed</option>
                </select>
                @error('status')
                    <div class="text-danger">
                        <span>⚠</span> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exam_date">Exam Date</label>
                <input type="date" name="exam_date" id="exam_date" required>
                @error('exam_date')
                    <div class="text-danger">
                        <span>⚠</span> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Add Exam Result</button>
        </form>
    </div>

    <script>
        // Simple animation for form submission feedback
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.alert-success');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    successMessage.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }
            
            // Set today's date as default for exam date
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            document.getElementById('exam_date').value = `${yyyy}-${mm}-${dd}`;
        });
    </script>
</body>
</html>