<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apply for Scholarship - ScholarPath  System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/apply.css') }}" />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo"><span>ScholarPath</span> 
        </div>
        <nav>
            <a href="{{ route('candidate.dashboard') }}">Home</a>
            <a href="">Scholarships</a>
            <a href="">Contact</a>
        </nav>
    </header>
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <!-- Main Content - Application Form -->
    <div class="container">
        <h2 class="form-title">Scholarship Application Form</h2>
    
        <h2 class="scholarship-title">{{ $scholarship->name }}</h2> 
    
        @if ($scholarship->questions->isEmpty())
        <p>No questions available for this scholarship.</p>
    @else
        <form action="{{ route('scholarship.apply', $scholarship->scholarshipID) }}" method="POST" enctype="multipart/form-data">
            @csrf
    
            {{-- User Info --}}
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input readonly type="text" id="full_name" value="{{ Auth::user()->fname.' '.Auth::user()->lname }}" onclick="showEditMessage('full_name_message')"  class="form-control"/>
                <div id="full_name_message" class="edit-message"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input readonly type="email" id="email" value="{{ Auth::user()->email }}" onclick="showEditMessage('email_message')" class="form-control"/>
                <div id="email_message" class="edit-message"></div>
            </div>
            {{-- questions --}}
            @foreach ($scholarship->questions as $question)
                <div class="form-group">
                    <label for="question_{{ $question->questionID }}">{{ $question->question_text }}</label>
                    @if($question->question_type == 'text')
                        <input 
                            type="text" 
                            id="question_{{ $question->questionID }}" 
                            name="answers[{{ $question->questionID }}]" 
                            required 
                        />
                    @elseif($question->question_type == 'textarea')
                        <textarea 
                            id="question_{{ $question->questionID }}" 
                            name="answers[{{ $question->questionID }}]" 
                            required
                        ></textarea>
                    @endif
                </div>
            @endforeach
    
            {{-- documents --}}
            @foreach ($scholarship->requiredDocuments as $document)
                <div class="form-group">
                    <label for="document_{{ $document->id }}">{{ $document->name .'('.$document->type.')' }}</label>
                    <input 
                        type="file" 
                        id="document_{{ $document->id }}" 
                        name="documents[{{ $document->id }}]"
                        accept="{{ $document->type === 'pdf' ? 'application/pdf' : 'image/*' }}" 
                        required 
                    />
                </div>
            @endforeach
    
            {{-- submit button --}}
            @if ($hasApplied)
                <button type="submit" disabled>You have already Submitted</button>
            @else
                <button type="submit">Submit Application</button>
            @endif
        </form>
    @endif
    
    </div>
    <script>
        function showEditMessage(elementId) {
            document.getElementById(elementId).innerText = 'If you want to edit your information, please go to your profile page.';
        }
    </script>
</body>
</html>
