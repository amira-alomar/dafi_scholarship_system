<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Track Your Scholarship Application Status - DAFI Scholarship System" />
  <title>Track Application Status - DAFI Scholarship System</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/track.css') }}" />
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo"><span>DAFI</span> Scholarship</div>
    <nav>
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/scholarships') }}">Scholarships</a>
      <a href="{{ url('/contact') }}">Contact</a>
      <a href="{{ url('/apply') }}">Apply</a>
    </nav>
  </header>

  <!-- Main Content -->
  <div class="container">
    <!-- Application Selector -->
    <div class="application-selector">
      <label for="application-select"><strong>Select an Application:</strong></label>
      <form method="GET" action="{{ route('track_your_application') }}">
        <select name="selected_application" id="application-select" onchange="this.form.submit()">
          <option value="">-- Select an Application --</option>
          @foreach($applications as $application)
            <option value="{{ $application->applicationID }}" 
              {{ (request('selected_application') == $application->applicationID || (!request('selected_application') && $loop->first)) ? 'selected' : '' }}>
              Application #{{ $application->applicationID }} - {{ $application->scholarship->name ?? 'N/A' }}
            </option>
          @endforeach
        </select>
      </form>
    </div>

    @php
  $selectedApplication = request('selected_application') 
      ? $applications->where('applicationID', request('selected_application'))->first()
      : $applications->first();
@endphp

@if($selectedApplication)
  <div class="status-card">
    <h2>Track Your Application Status</h2>
    <ul class="status-list">
      @foreach($selectedApplication->applicationStages as $stage)
        <li>
          <strong>{{ $stage->name }}:</strong> 
          {{ $stage->status ?? 'Pending' }}
        </li>
      @endforeach
    </ul>
  </div>
  <div class="final-result">
    Final Result: <span id="final-status">{{ $selectedApplication->status ?? 'Pending' }}</span>
    <br />
  </div>
@else
  <p>No application found.</p>
@endif



  <!-- Footer -->
  <footer>
    &copy; 2025 DAFI Scholarship. All rights reserved. | 
    <a href="mailto:info@dafischolarship.org">info@dafischolarship.org</a>
  </footer>
</body>
</html>
