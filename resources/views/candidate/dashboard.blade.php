<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="Scholarships Dashboard - DAFI Scholarship System"
    />
    <title>Scholarships Dashboard - DAFI Scholarship</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/dash-candidate.css') }}" />
    </head>
    <body>
        <!-- Header -->
        <header>
        <div class="logo"><span>DAFI</span> Scholarship</div>
        <nav>
            <a href="{{ route('candidate.dashboard') }}">Home</a>
            <a href="{{ route('track_your_application') }}">Track Your Application</a>
            <a href="{{ route('profile.show') }}">Profile</a>
            <a href="{{ route('logout') }}">Logout</a>
        </nav>
        </header>
    

        <!-- Main Container -->
        <div class="container">
        <!-- Welcome Banner with username in red -->
        <div class="welcome-banner">
            <h1>Welcome, <span>{{ $user->fname }}</span>!</h1>
            <p>Explore your opportunities and manage your applications in one place.</p>
        </div>

        <!-- Dashboard Overview Section -->
        <div class="dashboard-overview">
            <div class="dashboard-card">
            <h3>Available Scholarships</h3>
            <p>{{ $scholarshipCount }}</p>
            </div>
            <div class="dashboard-card">
            <h3>Submitted Applications</h3>
            <p>{{ $applicationCount }}</p>
            </div>
            <div class="dashboard-card">
            <h3>Upcoming Deadlines</h3>
            <p>02</p>
            </div>
        </div>

        <!-- Available Scholarships Listing -->
        <h2 style="text-align:center; color:#333; margin-bottom:1.5rem;">
            Available Scholarships
        </h2>

        @if ($scholarships->isEmpty())
        <p class="no-scholarships">Currently, there are no available scholarships. Stay tuned for future opportunities!</p>
        @else
            <div class="scholarship-grid">
                @foreach ($scholarships as $scholarship)
                    <div class="scholarship-card">
                        <h2>{{ $scholarship->name }}</h2> 
                        <p>{{ $scholarship->description }}</p> 
                        <a href="{{ route('scholarship_details', ['id' => $scholarship->scholarshipID]) }}">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- My Applications Section -->
        <div class="applications-section">
            <h2>My Applications</h2>
            <table class="applications-table">
            <thead>
                <tr>
                <th>Application ID</th>
                <th>Scholarship</th>
                <th>Status</th>
                <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($applicationUsers as $application)
                <tr>
                <td>{{ $application->applicationID }}</td>
                <td>{{ $application->scholarship->name }}</td>
                <td>{{ $application->status }}</td>
                <td>{{ $application->submission_date }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
 
        <!-- Recent Announcements Section -->
        <div class="announcements-section">
            <h2>Recent Announcements</h2>
            <div class="announcement">
            <p>
                <strong>New Deadline Extension:</strong> Application deadline for STEM
                Scholarship extended to 2025-04-01.
            </p>
            </div>
            <div class="announcement">
            <p>
                <strong>Workshop Invitation:</strong> Join our webinar on effective
                scholarship applications on 2025-03-20.
            </p>
            </div>
        </div>
        </div>

        <!-- Footer -->
        <footer>
        &copy; 2025 DAFI Scholarship. All rights reserved. |
        <a href="mailto:info@dafischolarship.org">info@dafischolarship.org</a>
        </footer>
    </body>
    </html>
