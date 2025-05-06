<head>
    <link rel="stylesheet" href="{{ asset('css/exam_details.css') }}">
</head>
<div class="container">

    <h2>Exam Details for {{ $student->fname .' '.$student->lname }}</h2>

    @if(!$exam)
        <p>No exam found for this student.</p>
    @else
        <div class="exam-info">
            <p><strong>Course:</strong> {{ $exam->course }}</p>
            <p><strong>Score:</strong> {{ $exam->score ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($exam->status) ?? 'N/A' }}</p>
            <p><strong>Exam Date:</strong> {{ $exam->exam_date }}</p>
        </div>
    @endif

    <div class="decision-buttons" style="margin-top: 20px;">
        @if($stageProgress->status == 'pending')
        <form action="{{ route('exam.approve', ['studentID' => $student->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Approve</button>
            </form>
            <form action="{{ route('exam.reject', ['studentID' => $student->id]) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
        @elseif($stageProgress->status == 'accepted')
            <p class="text-success"><strong>Student has been approved.</strong></p>
        @elseif($stageProgress->status == 'rejected')
            <p class="text-danger"><strong>Student has been rejected.</strong></p>
        @endif
    </div>

</div>
