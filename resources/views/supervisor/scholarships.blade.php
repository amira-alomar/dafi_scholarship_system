<!-- Available Scholarships Listing -->
{{-- <head>
    <link rel="stylesheet" href="{{ asset('css/scholarship.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"/>
    {{-- @include('include.sidebar') --}}
{{-- </head>
<body>
   

<div class="layout">
@include('include.sidebar')
<div class="main-content">
<h2 style="text-align:center; color:#333; margin-bottom:1.5rem;">
    Manage Questions for : 
</h2>

@if ($scholarships->isEmpty())
<p class="no-scholarships">Currently, there are no available scholarships. Stay tuned for future opportunities!</p>
@else
    <div class="scholarship-grid">
        @foreach ($scholarships as $scholarship)
            <div class="scholarship-card">
                <h2>{{ $scholarship->name }}</h2> 
                <p>{{ $scholarship->description }}</p> 
                <a href="{{ route('supervisor.questions', ['scholarshipId' => $scholarship->scholarshipID]) }}">
                    Manage Questions
                </a>
            </div>
        @endforeach
    </div>
@endif
</div>
</div>
</body> --}} 