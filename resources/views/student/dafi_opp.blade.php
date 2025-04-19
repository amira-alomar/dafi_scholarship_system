<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFI Opportunities</title>
    <link rel="stylesheet" href="{{ asset('css/dafi_opp.css') }}">
    <script defer src="{{ asset('js/dafi.js') }}"></script>
</head>
<body>

        <div class="hero-section">
            <img src="{{ asset('image/pexels-ekrulila-2292837.jpg') }}" alt="DAFI Hero Image" class="hero-image">
            <div class="hero-content">
                <h1>DAFI Opportunities</h1>
                <p>Empowering refugees through education and opportunities.</p>
            </div>
        </div>
    <div class="container">
    @if(session('success'))
    <div class="alert alert-success" id="flash-message">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="flash-message">{{ session('error') }}</div>
@endif
<!-- Sidebar Navigation -->
<div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="home.html"> Home</a></li>
                <li><a href="acadmic.html"> Academic Info</a></li>
                <li><a href="dafi_Opp.html"> DAFI Opportunity</a></li>
                <li><a href="job_Opp.html"> Job Opportunity</a></li>
                <li><a href="courses.html"> Courses</a></li>
                <li><a href="profile.html"> Profile</a></li>
            </ul>
        </div>

        <h1>DAFI Opportunities</h1>

        <!-- Tabs for Filtering -->
        <div class="tabs">
            <button class="tab active" onclick="filterOpportunities('all')">All</button>
            <button class="tab" onclick="filterOpportunities('training')">Trainings</button>
            <button class="tab" onclick="filterOpportunities('volunteer')">Volunteering</button>
            <button class="tab" onclick="filterOpportunities('event')">Events</button>
        </div>

        <!-- Opportunity Cards -->
        <div class="opportunity-list">
        @foreach($opportunities as $opportunity)
            <div class="opportunity-card" data-category="{{ strtolower($opportunity->type) }}">
                <img src="{{ asset('image/pexels-ekrulila-2292837.jpg') }}" alt="Training Image">
                <h3>{{ $opportunity->title }}</h3>
                <p>{{ $opportunity->description }}</p>
                <p> Date : {{ $opportunity->date }}</p>
                <p> Location : {{ $opportunity->location }}</p>
                <span class="category {{ strtolower($opportunity->type) }}">{{ $opportunity->type }}</span>
                
                @csrf
                <button class="apply-btn" onclick="openApplyForm('{{ $opportunity->title }}')">
                {{ $opportunity->type == 'event' ? 'Register Now ' : 'Apply Now' }}
                </button>
              
                </div>
                @endforeach
        </div>
    </div>
  <!-- Application Form (Hidden by Default) -->
  <div class="apply-form-overlay" id="applyFormOverlay">
    <div class="apply-form">
        <h2>Apply for Opportunity</h2>
        <form id="applicationForm" method="POST" action="{{ route('applications.store') }}">
    @csrf

    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Your Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="opportunity">Opportunity Title:</label>
    <input type="text" id="opportunity" name="opportunity_title" readonly>

    <label for="motivation">Why do you want to apply?</label>
    <textarea id="motivation" name="motivation" required></textarea>

    <button type="submit">Submit Application</button>
    <button type="button" onclick="closeApplyForm()">Cancel</button>
</form>

    </div>
</div>
<script>
    window.addEventListener('scroll', function() {
      let heroImage = document.querySelector('.hero-image');
      let scrollPosition = window.pageYOffset;
      heroImage.style.transform = 'translateY(' + scrollPosition * 0.3 + 'px)';
    });
    </script>
</body>
</html>