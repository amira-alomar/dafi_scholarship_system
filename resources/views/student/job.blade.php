<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="{{ asset('css/job.css') }}">
    <script defer src="{{ asset('js/Script.js') }}"></script>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Academic Info</a></li>
            <li><a href="#">DAFI Opportunity</a></li>
            <li><a href="#">Job Opportunity</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Profile</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Open Positions</h2>

        <div class="search-bar">
            <input type="text" id="skills" placeholder="Search jobs by skills...">
            <button onclick="searchJobs()"><i class="fas fa-search"></i> Search</button>
            <button onclick="saveSkill()"><i class="saveskill-btn"></i> Save Skill</button>
        </div>

        <div class="job-cards">
        @foreach($jobs as $job)
    <div class="job-card">
        <div class="job-card-header">
            <h3>{{ $job->title }}</h3>
            <p class="job-type">{{ $job->job_type ?? 'Not specified' }}</p>
        </div>
        <p class="location">{{ $job->location }}</p>
        <p class="description">{{ $job->description }}</p>
        <button class="view-details-btn">View Details</button>
        <button class="save-btn">⭐ Save</button>
    </div>
@endforeach

        </div>

        <div id="job-modal" class="modal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeModal()">&times;</button>
                <h3>Job Details</h3>
                <p id="job-detail-text"></p>
            </div>
        </div>
    </div>
</body>
</html>

