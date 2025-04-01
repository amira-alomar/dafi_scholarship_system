    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Apply for Scholarship - DAFI Scholarship System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/apply.css') }}" />
    </head>
    <body>
    <!-- Header -->
    <header>
        <div class="logo"><span>DAFI</span> Scholarship</div>
        <nav>
        <a href="">Home</a>
        <a href="">Scholarships</a>
        <a href="">Contact</a>
        </nav>
    </header>

    <!-- Main Content - Application Form -->
    <div class="container">
        <h2 class="form-title">Scholarship Application Form</h2>
        <form action="" method="post">
        @csrf
        <!-- Dynamic Questions from Database -->
        <h2 class="scholarship-title">{{ $scholarship->name }}</h2> 
        @if ($scholarship->questions->isEmpty())
            <p>No questions available for this scholarship.</p>
        @else
            <form action="" method="post">
            @csrf
            @foreach ($scholarship->questions as $question)
            <div class="form-group">
                <label for="question_{{ $question->id }}">{{ $question->question_text }}</label>
                <textarea id="question_{{ $question->id }}" name="answers[{{ $question->id }}]" required></textarea>
            </div>
            @endforeach
            <button type="submit">Submit Application</button>
            </form>
        @endif
    </form>
    </body>
    </html>
