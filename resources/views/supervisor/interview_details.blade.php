<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Details</title>
    <link rel="stylesheet" href="{{ asset('css/interview_details.css') }}">
</head>
<body>
    <div class="container">
        <h2>Interview Details for {{ $student->fname . ' ' . $student->lname }}</h2>

        @if(!$interview)
            <p>No interview scheduled for this student.</p>
        @else
            <div class="interview-info">
                <p><strong>Interview Date:</strong> {{ $interview->interview_date }}</p>
                <p><strong>Status:</strong> {{ ucfirst($interview->status) }}</p>
            </div>
        @endif

        <div class="decision-buttons" style="margin-top:20px;">
            @if($interview && $interview->status == 'scheduled')
                <form action="{{ route('interview.complete', ['studentID' => $student->id]) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-success">Mark Completed</button>
                </form>
                <form action="{{ route('interview.cancel', ['studentID' => $student->id]) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel Interview</button>
                </form>
            @elseif(!$interview)
                <p>Please schedule an interview first.</p>
            @else
                <p class="text-{{ $interview->status == 'completed' ? 'success' : 'danger' }}">
                    Interview has been {{ $interview->status }}.
                </p>
            @endif
        </div>
    </div>
</body>
</html>