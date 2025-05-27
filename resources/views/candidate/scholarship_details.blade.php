<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Scholarship Details - ScholarPath  System" />
    <title>Scholarship Details - ScholarPath  System</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/scholarship_details.css') }}" />
    </head>
    <body>
        <!-- Header -->
        <header>
        <div class="logo"><span>ScholarPath</span> </div>
        <nav>
            <a href="index.html">Home</a>
            <a href="scholarships.html">Scholarships</a>
            <a href="contact.html">Contact</a>
        </nav>
        </header>
    
        <!-- Main Content -->
        <div class="container">
        <div class="details-card">
            <h2 id="scholarship-title">{{ $scholarship->name }}</h2>
            <p id="scholarship-description">
                {{ $scholarship->description }}
            </p>
            <div class="details-section" id="scholarship-criteria">
            <h3>Eligibility Criteria</h3>
            <ul>
                @foreach ($scholarship->criteria as $criterion)
                    <li>{{ $criterion->criteria_text }}</li>
                @endforeach
            </ul>
            </div>
            <div class="details-section" id="scholarship-benefits">
            <h3>Benefits</h3>
            <ul>
                @foreach ($scholarship->benefits as $benefit)
                    <li>{{ $benefit->Benefit_text }}</li>
                @endforeach
            </ul>
            </div>
            <div class="details-section" id="scholarship-partners">
                <h3>Partner Organizations</h3>
                <ul>
                    @foreach ($scholarship->partners as $partner)
                        <li>{{ $partner->Partner_name }}</li>
                    @endforeach
                </ul>
            </div>

            @if ($hasApplied)
    <button id="apply-now-btn" class="apply-btn" disabled>You have already applied</button>
@else
    <a href="{{ route('apply', ['scholarship' => $scholarship->scholarshipID]) }}"
       id="apply-now-btn"
       class="apply-btn">Apply Now</a>
@endif

        </div>
        </div>

        <!-- Footer -->
        <footer>
        &copy; 2025 ScholarPath Scholarship. All rights reserved. | 
        <a href="mailto:info@ScholarPathscholarship.org">info@ScholarPathscholarship.org</a>
        </footer>

        <!-- JavaScript -->
        {{-- <script>
            // Select the "Apply Now" button
            const applyButton = document.getElementById('apply-now-btn');

            // Check if the "Apply Now" button exists on the page
            if (applyButton) {
                applyButton.addEventListener('click', function(event) {
                    // If the user is about to apply, show the alert
                    if (!{{ $hasApplied ? 'true' : 'false' }}) {
                        alert("You have already applied for this scholarship.");
                    }
                });
            }
        </script> --}}
    </body>
</html>
