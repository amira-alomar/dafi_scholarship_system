<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Courses</title>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')
    <div class="container">
        <h2>Manage Student Courses</h2>
        
        @foreach($applications as $app)
    <div class="student">
        <h3>Student: {{ $app->user->fname.' '.$app->user->lname }}</h3>

        @if($app->user->courses->isEmpty())
            <p>Not registered in any course yet.</p>
        @else
            <ul class="course-list">
                @foreach($app->user->courses as $course)
                    <li class="course-item">
                        <span>
                            Code: {{ $course->code }} |
                            Course: {{ $course->course_name }} |
                            Grade: {{ $course->grade ?? 'N/A' }} |
                            Samester: {{ $course->semester ?? 'N/A' }} |
                            Instructor: {{ $course->instructor ?? 'N/A' }} |
                            Credits: {{ $course->credits ?? 'N/A' }}
                        </span>
                        <form action="{{ route('courses.destroy', $course->courseID) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Drop</button>
                        </form>
                        
                        
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach

    </div>
    </div>
</body>
</html>
