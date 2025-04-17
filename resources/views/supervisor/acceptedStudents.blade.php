<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accepted Students</title>
    <link rel="stylesheet" href="{{ asset('css/acceptedStudents.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')
  <div class="container">
    <h2>Accepted Students</h2>
    
    @foreach ($applications as $application)
    <p>Total Accepted Students: {{ count($applications) }}</p>

    <div class="student-card">
    <div class="student-info">
        <p><strong>Name:</strong> {{ $application->user->lname }}</p>
        <p><strong>Major:</strong> {{ $application->user->studentInfo->major }}</p>
        <p><strong>Year:</strong> {{ $application->user->studentInfo->year }}</p>
        <p><strong>GPA:</strong> {{ $application->user->studentInfo->gpa }}</p>
        <p><strong>number of training:</strong> {{ $application->user->studentInfo->number_of_training }}</p>
        <p><strong>Volunteering:</strong> {{ $application->user->studentInfo->number_of_volunteering }} hours</p>
    </div>
    <div class="badge">{{ $application->scholarship->name }}</div>
    </div>
    @endforeach
  </div>
</div>
</body>
</html>
