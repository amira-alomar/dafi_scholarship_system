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
      <a href="{{ route('candidate.dashboard') }}">Home</a>
      <a href="{{ route('profile.show') }}">Profile</a>
      <a href="{{ route('logout') }}">Logout</a>
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
{{--  --}}
@if($selectedApplication)
  <div class="status-card">
    <h2>Track Your Application Status</h2>
    <ul class="status-list">
      @foreach($selectedApplication->applicationStages as $stage)
        @php
          $pivot = $stage->pivot;
          $name = strtolower($stage->name); // just in case names come capitalized
        @endphp

        <li>
          <strong>{{ ucfirst($name) }}:</strong>

          @if($name === 'exam')
            @if($selectedApplication->exam && $selectedApplication->exam->status)
              {{ $selectedApplication->exam->status }} - Score: {{ $selectedApplication->exam->score }}
            @else
              Pending
            @endif

          @elseif($name === 'form')
            @if($selectedApplication->applicationForm && $selectedApplication->applicationForm->status)
              {{ $selectedApplication->applicationForm->status }}
            @else
              Pending
            @endif

          @elseif($name === 'interview') {{-- intentionally misspelled to match your data --}}
            @if($selectedApplication->interview && $selectedApplication->interview->status)
              {{ $selectedApplication->interview->status }}
            @else
              Pending
            @endif

          @else
            {{ $pivot->main_status ?? 'Pending' }}
          @endif

          <br>
          <span style="margin-left: 20px;"><em>Result:</em> {{ $pivot->status ?? 'Pending' }}</span>
        </li>
      @endforeach
    </ul>
  </div>

  <div class="final-result">
    Final Result: <span id="final-status">{{ $selectedApplication->status ?? 'Pending' }}</span>
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
