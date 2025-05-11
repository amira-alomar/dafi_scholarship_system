<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Invitation</title>
    <link rel="stylesheet" href="{{ asset('css/interview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')

        <div class="container">
            <h2>Interview Invitation</h2>
            <h3>Scholarship {{ $scholarshipID }}</h3>

            @forelse ($eligibleApplications as $progress)
                <div class="invitation-item">
                    @if ($progress->application->stageProgress->isNotEmpty())
                        <button class="send-btn" disabled>Scheduled</button>
                    @else
                        <form action="{{ route('interview.schedule', ['studentID' => $progress->application->idUser]) }}" method="POST">
                            @csrf
                            <input type="date" name="interview_date" required>
                            <button type="submit" class="send-btn">Schedule Interview</button>
                        </form>
                    @endif
                    <a href="{{ route('interview.details', ['studentID' => $progress->application->idUser]) }}" class="btn btn-info">See Interview Details</a>

                    <div class="info">
                        <strong>Student:</strong> {{ $progress->application->user->fname . ' ' . $progress->application->user->lname }}<br>
                        <strong>Email:</strong> {{ $progress->application->user->email }}<br>
                        <strong>Status:</strong> {{ $progress->application->stageProgress->first()->status ?? 'Not Scheduled' }}
                    </div>
                </div>
            @empty
                <p>No eligible students found for interviews.</p>
            @endforelse

        </div>
    </div>
</body>
</html>
