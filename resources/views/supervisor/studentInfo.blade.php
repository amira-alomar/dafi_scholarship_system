<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Academic Information</title>
    <link rel="stylesheet" href="{{ asset('css/studentInfo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')
        <div class="container">
            <h2>Student Academic Information</h2>
            @foreach($applications as $app)
            <div class="student-info">
                <div class="student-header">
                    <h3>Student: {{ $app->user->fname .' '. $app->user->lname ?? 'Unknown' }}</h3>
                    <h3 class="scholarship-name">Scholarship: {{ $app->scholarship->name ?? 'N/A' }}</h3>
                </div>
                <p class="info"><strong>Major:</strong> {{ $app->user->studentInfo->major ?? 'N/A' }}</p>
                <p class="info"><strong>Year:</strong> {{ $app->user->studentInfo->year ?? 'N/A' }}</p>
                <p class="info"><strong>GPA:</strong> {{ $app->user->studentInfo->gpa ?? 'N/A' }}</p>
                <p class="info"><strong>University:</strong> {{ $app->user->studentInfo->University->name ?? 'N/A' }}</p>
                <p class="info"><strong>Training:</strong> {{ $app->user->studentInfo->number_of_training ?? 'N/A' }}</p>
                <p class="info"><strong>Volunteering:</strong> {{ $app->user->studentInfo->number_of_volunteering ?? 'N/A' }} hours</p>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
