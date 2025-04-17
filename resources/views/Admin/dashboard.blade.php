<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
    />
    <title>Advanced Admin Dashboard - DAFI Scholarship</title>
    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/dash-admin.css') }}">
</head>
<body>

    @include('include.adminSideBar')
    
    <!-- Main Dashboard Content -->
    <div class="main-content">
    <div class="header">
        <h1>Welcome, Supervisor!</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="stats">
        <div class="stat-card">
        <h3>Total Students</h3>
        <p>1,250</p>
        </div>
        <div class="stat-card">
        <h3>Programs</h3>
        <p>45</p>
        </div>
        <div class="stat-card">
        <h3>Applications</h3>
        <p>5,678</p>
        </div>
        <div class="stat-card">
        <h3>Approved</h3>
        <p>2,430</p>
        </div>
    </div>

    <!-- Recent Applications Section -->
    <div class="recent-applications">
        <h3>Recent Applications</h3>
        <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Program</th>
            <th>Date Applied</th>
            <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>001</td>
            <td>John Doe</td>
            <td>STEM</td>
            <td>2025-01-15</td>
            <td>Approved</td>
            </tr>
            <tr>
            <td>002</td>
            <td>Jane Smith</td>
            <td>Arts</td>
            <td>2025-01-14</td>
            <td>Under Review</td>
            </tr>
            <tr>
            <td>003</td>
            <td>Ahmed Ali</td>
            <td>Business</td>
            <td>2025-01-13</td>
            <td>Pending</td>
            </tr>
            <tr>
            <td>004</td>
            <td>Maria Garcia</td>
            <td>STEM</td>
            <td>2025-01-12</td>
            <td>Rejected</td>
            </tr>
        </tbody>
        </table>
    </div>

    <!-- Announcements Section -->
    <div class="announcements">
        <h3>Announcements</h3>
        <ul>
        <li>New scholarship opportunity added!</li>
        <li>System maintenance scheduled for 2025-02-28.</li>
        <li>Annual review meeting on 2025-03-05.</li>
        <li>Don’t miss the upcoming webinar on application best practices.</li>
        </ul>
    </div>
    </div>
</body>
</html>
