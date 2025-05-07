<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Opportunities Manager</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/jobAdmin.css') }}" />
</head>
<body>
  <!-- Header -->
  <div class="layout">
    @include('include.adminSideBar')
    <div class="container">
        <h2>Manage Jobs</h2>
  <!-- Main Content -->
  <main class="main">
    <div class="container">
      <!-- Jobs Grid -->
      <div class="jobs-grid">
        <!-- Example Job Card -->
        <a href="#" class="job-card">
          <div class="job-card-header">
            <h2 class="job-title">Senior Frontend Developer</h2>
            <span class="deadline-badge">12 days left</span>
          </div>
          <div class="job-company">
            <i class="ri-building-line"></i>
            <span>TechCorp Inc.</span>
          </div>
          <div class="job-location">
            <i class="ri-map-pin-line"></i>
            <span>San Francisco, CA</span>
          </div>
          <div class="job-description">
            <p>We're looking for a skilled Senior Frontend Developer proficient in React, TypeScript, and modern CSS frameworks to join our engineering team.</p>
          </div>
          <div class="job-footer">
            <div class="job-deadline">
              <i class="ri-calendar-line"></i>
              <span>Oct 30, 2023</span>
            </div>
            <div class="job-actions">
              <button class="btn-secondary">
                <i class="ri-edit-line"></i> Edit
              </button>
              <button class="btn-danger">
                <i class="ri-delete-bin-line"></i> Delete
              </button>
            </div>
          </div>
        </a>
        <!-- Repeat other job cards similarly -->
      </div>
    </div>
  </main>
  </div>
</body>
</html>
