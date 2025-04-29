<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Academic Info</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/acadmic.css') }}">
    <script defer src="{{ asset('js/acadmic.js') }}"></script>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
        <li><a href="{{ url('/student/dashboard') }}"> Home</a></li>
    <li><a href="{{ url('/acadmic') }}"> Academic Info</a></li>
    <li><a href="{{ url('/dafi_opp') }}"> DAFI Opportunity</a></li>
    <li><a href="{{ url('/jobs') }}"> Job Opportunity</a></li>
    <li><a href="{{ url('/courses') }}"> Courses</a></li>
    <li><a href="{{ url('/profile') }}"> Profile</a></li>
        </ul>
    </div>

    <!-- Academic Info -->
    <h1>Academic Information</h1>

    <div class="section">
        <h2>Personal & Academic Details</h2>
        <p><i class="fas fa-user"></i> Name: <span>{{ optional(auth()->user())->fname ?? 'Guest' }}</span></p>
        <p><i class="fas fa-envelope"></i> Email: <span>{{ optional(auth()->user())->email ?? 'Not Available' }}</span></p>
        <p><i class="fas fa-university"></i> University: <span>{{ $university ?? 'Not Set' }}</span></p>
        <p><i class="fas fa-book"></i> Major: <span>{{ $major ?? 'Not Set' }}</span></p>
        <p><i class="fas fa-graduation-cap"></i> GPA: <span>{{ $gpa ?? 'Not Set' }}</span></p>
    </div>

    <!-- Trainings -->
    <div class="section">
        <h2>Training</h2>

        <form action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="Enter training name" required>
            <input type="file" name="certificate" required>
            <button type="submit">Add Training</button>
        </form>

        <ul>
            @foreach($trainings as $training)
                <li>
                    {{ $training->name }} - 
                    <!-- <a href="{{ asset('storage/'.$training->certificate) }}" target="_blank">View Certificate</a> -->
                    <a href="{{ asset('storage/'.$training->certificate) }}" target="_blank"> View Certificate</a>


                </li>
            @endforeach
        </ul>
    </div>

    <!-- Volunteering -->
    <div class="section">
        <h2>Volunteering</h2>

        <form action="{{ route('volunteerings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="activity_name" placeholder="Enter volunteering activity" required>
            <input type="number" name="total_hours" placeholder="Enter total hours" required>
            <input type="file" name="certificate" required>
            <button type="submit">Add Volunteering</button>
        </form>

        <ul>
            @foreach($volunteerings as $volunteering)
                <li>
                    {{ $volunteering->activity_name }} - {{ $volunteering->total_hours }} hours
                    @if ($volunteering->certificate_path)
                        - <a href="{{ asset('storage/'.$volunteering->certificate_path) }}" target="_blank">View Certificate</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Upload Section for Semester Grades -->
    <div class="section">
        <h2>Upload Documents</h2>
        <label>Upload Semester Grades:</label>
        <input type="file" id="upload-grades"><br><br>
        <button onclick="submitAcademicInfo()">Submit Updates</button>
    </div>

    <!-- Notifications -->
    <div class="section">
        <h2>Notifications & Reminders</h2>
        <ul id="notifications"></ul>
    </div>

</div>

</body>
</html>