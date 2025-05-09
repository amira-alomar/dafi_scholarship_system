<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Eligible Students for Exam Stage ({{ $currentStage->name }})</h2>
        <p><strong>Based on acceptance in stage:</strong> {{ $previousStage->name }}</p>
    
        @if($students->isEmpty())
            <p>No students found.</p>
        @else
            <ul>
                @foreach($students as $application)
                    <li>{{ $application->user->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>