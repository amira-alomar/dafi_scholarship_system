<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications</title>
    <link rel="stylesheet" href="{{ asset('css/application.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')
        <div class="container">
            <h2>Student Applications</h2>
            @foreach($applications as $app)
                <div class="application">
                    <a href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipId,'applicationID' => $app->applicationID]) }}">
                        {{ $app->user->fname." ".$app->user->lname ?? 'Unknown' }} - {{ $app->scholarship->name ?? 'No Scholarship' }}
                    </a>
                    <div class="buttons">
                        @if ($app->applicationForm->status === 'submitted')
                        <form action="{{ route('application.approve', ['scholarshipId' => $scholarshipId, 'applicationID' => $app->applicationID]) }}" method="POST">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                        <form action="{{ route('application.reject', ['scholarshipId' => $scholarshipId, 'applicationID' => $app->applicationID]) }}" method="POST">
                            @csrf
                            <button type="submit">Reject</button>
                        </form>
                        @elseif ($app->applicationForm->status === 'approved')
                            <button class="approve" disabled>Accepted</button>
                        @elseif ($app->applicationForm->status === 'rejected')
                            <button class="reject" disabled>Rejected</button>
                        @endif
                    </div>
                    
                </div>
            @endforeach
        </div>
        
</div>
</body>
</html>
