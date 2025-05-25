<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interview Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style type="text/tailwindcss">
    @layer base {
      :root {
        --bg: #f9fafb;
        --fg: #1e293b;
        --card: #ffffff;
        --primary: #ef4444;
        --primary-hover: #dc2626;
        --success: #10b981;
        --danger: #ef4444;
        --border: #e2e8f0;
        --radius: 0.75rem;
      }
      body { @apply bg-[var(--bg)] text-[var(--fg)]; }
    }
    @layer components {
      .btn { @apply inline-flex items-center gap-2 px-4 py-2 font-semibold rounded-[var(--radius)] transition; }
      .btn-primary { @apply btn bg-[var(--primary)] text-white hover:bg-[var(--primary-hover)]; }
      .btn-success { @apply btn bg-[var(--success)] text-white hover:opacity-90; }
      .btn-danger { @apply btn bg-[var(--danger)] text-white hover:opacity-90; }
      .card { @apply bg-[var(--card)] p-6 rounded-[var(--radius)] shadow; }
      .label { @apply block text-sm font-medium text-gray-600 mb-1; }
      .value { @apply text-lg font-semibold; }
      .input { @apply w-full border border-[var(--border)] rounded-[var(--radius)] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent; }
    }
    .layout {
            display: flex;
            height: 100vh;
            /* Full height of viewport */
            overflow: hidden;
        }
  </style>
</head>

<body class="min-h-screen font-sans">
   <div class="layout">

        <div class="sidebar">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </div>

  <!-- Main Content -->
  <main class="w-full mt-8 space-y-8 px-6">


    <!-- Interview Info Card -->
    <section class="card">
  <h2 class="text-2xl font-bold mb-4">Interview Details</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <p class="label">Candidate</p>
      <p class="value">{{ $student->fname }} {{ $student->lname }}</p>
    </div>

    @if($interview)
      <div>
        <p class="label">Interview Date</p>
        <p class="value">{{ date('F j, Y', strtotime($interview->interview_date)) }}</p>
      </div>

      <div>
        <p class="label">Performance Level</p>
        <p class="value">{{ ucfirst($interview->performance_level) }}</p>
      </div>

      <div>
        <p class="label">Recommendation</p>
        <p class="value">{{ ucfirst($interview->recommendation) }}</p>
      </div>

      <div class="md:col-span-2">
        <p class="label">Notes</p>
        <p class="value">{{ $interview->notes ?? '—' }}</p>
      </div>
       <!-- Actions Card -->
    <section class="card">
      <h3 class="text-xl font-semibold mb-4">Immediate Actions</h3>
      @if($stageProgress->status === 'pending')
        <div class="flex flex-wrap gap-4">
          <form action="{{ route('interview.accept', ['studentID' => $student->id]) }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" class="btn-success w-full justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Accept
            </button>
          </form>
          <form action="{{ route('interview.reject', ['studentID' => $student->id]) }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" class="btn-danger w-full justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Reject
            </button>
          </form>
        </div>
      @else
        <div class="p-4 rounded-[var(--radius)] 
          {{ $stageProgress->status === 'accepted' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
          <p class="font-medium text-lg">Interview has been <span class="font-bold">{{ $stageProgress->status }}</span>.</p>
        </div>
      @endif
    </section>
    @else
      <div class="md:col-span-2">
        <p class="text-gray-500 italic">No interview scheduled for this student.</p>
      </div>
    @endif
  </div>
</section>


   

   

  </main>
  </div>
</body>

</html>