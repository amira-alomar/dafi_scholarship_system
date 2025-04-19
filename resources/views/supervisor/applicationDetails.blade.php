<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <link rel="stylesheet" href="{{ asset('css/applicationDetails.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

</head>
<body>
    <div class="layout">
        @include('include.sidebar')
        <div class="container">
            <h2>Application Details</h2>
        
            <!-- Application Answers -->
            <div class="application-answers">
                <h3>Application Answers</h3>
        
                @foreach($application->answers as $answer)
                    <p><strong>{{ $answer->question->question_text }}</strong></p>
                    <p>{{ $answer->answer_text }}</p>
                @endforeach
            </div>
        
            <!-- Uploaded Documents -->
            <div class="documents">
                <h3>Uploaded Documents</h3>
                <ul>
                    @foreach($application->documents as $document)
                        <li><a href="{{-- {{ asset('storage/'.$document->file_path) }} --}}" download>{{ $document->file_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        
            <!-- Admin Actions (Approve / Reject) -->
            <div class="admin-actions">
                <form action="{{ route('application.approve', ['applicationID' => $application->applicationID]) }}" method="POST" style="display:inline-block">
                    @csrf
                    <button type="submit" class="approve">Approve</button>
                </form>
                <form action="{{ route('application.reject', ['applicationID' => $application->applicationID]) }}" method="POST" style="display:inline-block">
                    @csrf
                    <button type="submit" class="reject">Reject</button>
                </form>
            </div>
        </div>
        
</div>
</body>
</html>
