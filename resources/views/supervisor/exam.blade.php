<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Invitation</title>
  <link rel="stylesheet" href="{{ asset('css/exam.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.sidebar')
        <div class="container">
          <h2>Exam Invitation</h2>
      
          @foreach ($scholarshipIDs as $scholarshipID)
              <h3>Scholarship {{ $scholarshipID }}</h3>
      
              @php
                  // Get students for this scholarship
                  $studentsForScholarship = $students->filter(function ($student) use ($scholarshipID) {
                      return $student->idScholarship  == $scholarshipID;
                  });
              @endphp
      
      @forelse ($studentsForScholarship as $student)
    <a href="{{ route('exam.details', ['studentID' => $student->user->id]) }}" class="invitation-item">
      <form action="{{ route('exam.sendInvitation', ['applicationID' => $student->applicationID]) }}" method="POST" >
        @csrf
        <button type="submit" class="send-btn">
            Send Invitation
        </button>
    </form>
    
        <div class="info">
            <strong>Student:</strong> {{ $student->user->fname .' '. $student->user->lname }}<br>
            <strong>Email:</strong> {{ $student->user->email }}<br>
            <strong>Status:</strong> Not Sent
        </div>
    </a>
@empty
    <p>No eligible students found for this scholarship.</p>
@endforelse

  
          @endforeach
      
      
  
      
    
    <!-- Invitation sent, awaiting response -->
    {{-- <div class="invitation-item">
      <div class="info">
        <strong>Student:</strong> Bob Williams<br>
        <strong>Email:</strong> bob@example.com<br>
        <strong>Status:</strong> Pending
      </div>
      <div class="actions">
        <button class="accept-btn">Accept</button>
        <button class="reject-btn">Reject</button>
      </div>
    </div>
    
    <!-- Invitation accepted -->
    <div class="invitation-item">
      <div class="info">
        <strong>Student:</strong> Charlie Smith<br>
        <strong>Email:</strong> charlie@example.com<br>
        <strong>Status:</strong> Accepted
      </div>
    </div>
    
    <!-- Invitation rejected -->
    <div class="invitation-item">
      <div class="info">
        <strong>Student:</strong> David Brown<br>
        <strong>Email:</strong> david@example.com<br>
        <strong>Status:</strong> Rejected
      </div>
    </div> --}}
  </div>
</div>
</body>
</html>
