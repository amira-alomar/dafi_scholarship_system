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
            <!-- Sidebar Navigation -->
     <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="home.html"> Home</a></li>
            <li><a href="acadmic.html"> Academic Info</a></li>
            <li><a href="dafi_Opp.html"> DAFI Opportunity</a></li>
            <li><a href="job_Opp.html"> Job Opportunity</a></li>
            <li><a href="courses.html"> Courses </a></li>
            <li><a href="profile.html"> Profile</a></li>
        </ul>
    </div>
    
        <h1>Academic Information</h1>

        <!-- Personal & Academic Details -->
        <div class="section">
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-red-500 mb-2">Personal & Academic Details</h2>
            <p><i class="fas fa-user"></i> Name: <span id="student-name">John Doe</span></p>
            <p><i class="fas fa-envelope"></i> Email: <span id="student-email">johndoe@example.com</span></p>
            <p><i class="fas fa-university"></i> University: <span id="student-university">XYZ University</span></p>
            <p><i class="fas fa-book"></i> Major: <span id="student-major">Computer Science</span></p>
            <p><i class="fas fa-graduation-cap"></i> GPA: <span id="student-gpa">3.75</span></p>
        </div>
        </div>
        <!-- Training Section -->
        <div class="section">
            <h2>Training</h2>
            <ul id="training-list"></ul>
            <input type="text" id="new-training" placeholder="Enter training name">
            <input type="file" id="training-certificate">
            <button onclick="addTraining()">Add Training</button>
        </div>

        <!-- Volunteering Section -->
        <div class="section">
            <h2>Volunteering</h2>
            <ul id="volunteering-list"></ul>
            <input type="text" id="new-volunteering" placeholder="Enter volunteering activity">
            <input type="number" id="volunteering-hours" placeholder="Enter total hours">
            <input type="file" id="volunteering-certificate">
            <button onclick="addVolunteering()">Add Volunteering</button>
          
        </div>

        <!-- Upload Section for Semester Grades -->
        <div class="section">
            <h2>Upload Documents</h2>
            <label>Upload Semester Grades:</label>
            <input type="file" id="upload-grades"><br><br>
            <button onclick="submitAcademicInfo()">Submit Updates</button>
        </div>
        <div class="section">
            <h2>Notifications & Reminders</h2>
            <ul id="notifications"></ul>
        </div>

    </div>

</body>
</html>