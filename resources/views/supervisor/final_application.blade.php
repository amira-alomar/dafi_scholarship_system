<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Applications Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/finalapp.css') }}">
</head>

<body>
     @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    <div class="container">
        <div class="header">
            <h1>Final Applications Results (Scholarship #{{ $scholarshipID }})</h1>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($applications as $application)
            <div class="application-card">
                <h2 class="application-title">{{ $application->user->fname }}</h2>

                <ul class="progress-list">
                    @foreach ($application->stageProgress as $progress)
                        <li class="progress-item">
                            <div>
                                <span class="progress-stage">{{ $progress->stage->name }}</span>
                                <span
                                    class="progress-status status-{{ strtolower($progress->status) }}">{{ ucfirst($progress->status) }}</span>
                            </div>

                            @php
                                $stageName = strtolower($progress->stage->name);
                            @endphp

                            @if ($stageName === 'form')
                                <a class="details-link"
                                    href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipID, 'applicationID' => $application->applicationID]) }}">
                                    View Details
                                </a>
                            @elseif($stageName === 'exam')
                                <a class="details-link"
                                    href="{{ route('exam.details', ['studentID' => $application->user->id]) }}">
                                    View Details
                                </a>
                            @elseif($stageName === 'interview')
                                <a class="details-link"
                                    href="{{ route('interview.details', ['studentID' => $application->user->id]) }}">
                                    View Details
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if ($application->notes)
                    <div class="notes-section">
                        <div class="notes-title">Notes:</div>
                        <p class="notes-content">{{ $application->notes }}</p>
                    </div>
                @else
                    <form action="{{ route('supervisor.addNote', ['scholarshipID' => $scholarshipID]) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $application->applicationID }}">

                        <button type="button" class="add-notes-btn"
                            onclick="toggleNotesField('{{ $application->applicationID }}')">
                            Add Notes
                        </button>

                        <div id="notes-field-{{ $application->applicationID }}" class="notes-form">
                            <textarea name="notes" class="notes-textarea" placeholder="Enter your notes here..."></textarea>
                            <button type="submit" class="save-note-btn">Save Note</button>
                        </div>
                    </form>
                @endif

                @if ($application->status == 'pending')
                    <div class="action-buttons flex gap-4">
                        <form
                            action="{{ route('finalApplication.approve', ['applicationID' => $application->applicationID]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="accept-btn">Accept</button>
                        </form>

                        <form
                            action="{{ route('finalApplication.reject', ['applicationID' => $application->applicationID]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    </div>
                @else
                    <div class="final-result">
                        Final Result:
                        <span class="status-{{ strtolower($application->status) }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <script>
        function toggleNotesField(applicationId) {
            const notesField = document.getElementById(`notes-field-${applicationId}`);
            notesField.style.display = notesField.style.display === 'none' ? 'block' : 'none';
        }

        // Add animation to success message
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    successMessage.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>

</html>
