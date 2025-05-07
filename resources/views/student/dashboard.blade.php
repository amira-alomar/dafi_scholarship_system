<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/DashboardAcceptedStudents.css') }}">
    <script defer src="test.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

     <!-- Sidebar Navigation -->
     <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
    <li><a href="{{ url('/student/dashboard') }}"> Home</a></li>
    <li><a href="{{ url('/acadmic') }}"> Academic Info</a></li>
    <li><a href="{{ url('/dafi_opp') }}"> DAFI Opportunity</a></li>
    <li><a href="{{ url('/jobs') }}"> Job Opportunity</a></li>
    <li><a href="{{ url('/courses') }}"> Courses</a></li>
    <li><a href="{{ route('student.profile') }}"> Profile</a></li>
</ul>

    </div>

<div class="container">
    <!-- Main Content -->
    <div class="main-content">
        <div class="top-nav">
          
            <!-- Notification Bell -->
            <div class="notification">
                <span class="bell-icon">🔔</span>
                <span class="badge">3</span> <!-- Notification Count -->
            </div>
        
            <!-- Profile Section -->
            <div class="profile-menu">
                <img src="image/pexels-ekrulila-2292837.jpg" alt="Profile" class="profile-pic">
              
            </div>
        </div>
        
        
        

        <!-- Summary Cards -->
        <div class="cards">
            <div class="card">
                <h3>📊 GPA</h3>
                <p>3.75</p>
            </div>
            <div class="card">
                <h3>📚 Courses</h3>
                <p>5 Enrolled</p>
            </div>
            <div class="card">
                <h3>🤝 Volunteering</h3>
                <p>45 Hours</p>
            </div>
            <div class="card">
                <h3>🎓 Training</h3>
                <p>2 Completed</p>
            </div>
        </div>

        <!-- GPA Progress Chart -->
        <!-- <div class="chart-container">
            <canvas id="gpaChart"></canvas>
        </div> -->

        <!-- Recent Activities -->
        

            <h2>Recent Activities</h2>
            <div class="opportunity-list">
            <div class="opportunity-card" data-category="training">
                <img src="image/pexels-yankrukov-8197534.jpg" alt="Training Image">
                <h3>Web Development Training</h3>
                <p>Learn HTML, CSS, JavaScript, and more in this intensive bootcamp.</p>
                <span class="category training">Completed</span>
                
            </div>
            <div class="opportunity-card" data-category="training">
                <img src="image/pexels-yankrukov-8197534.jpg" alt="Training Image">
                <h3>Web Development Training</h3>
                <p>Learn HTML, CSS, JavaScript, and more in this intensive bootcamp.</p>
                <span class="category training">Completed</span>
                
            </div>
            <div class="opportunity-card" data-category="training">
                <img src="image/pexels-yankrukov-8197534.jpg" alt="Training Image">
                <h3>Web Development Training</h3>
                <p>Learn HTML, CSS, JavaScript, and more in this intensive bootcamp.</p>
                <span class="category trainingn">In Progress</span>
                
            </div>
            
            </div>
            <!-- <ul id="activity-list">
                <li>📚 Enrolled in "AI & Machine Learning"</li>
                <li>🤝 Volunteered for "Community Clean-up"</li>
                <li>🎓 Completed "Cybersecurity Training"</li>
            </ul> -->
        </div>
    </div>
</div>
</body>
</html>