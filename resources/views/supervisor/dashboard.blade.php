<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome – Scholarship Supervisor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    /* ripple effect */
    @keyframes ripple {
      to { transform: scale(4); opacity: 0; }
    }
    .ripple {
      position: absolute;
      border-radius: 50%;
      transform: scale(0);
      animation: ripple 600ms linear;
      background-color: rgba(255,255,255,0.4);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

  <!-- Navbar -->
  <header class="bg-white shadow sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <i class="fas fa-graduation-cap text-2xl text-red-500"></i>
        <h1 class="text-2xl font-bold">ScholarshipHub</h1>
      </div>
      <div class="flex items-center space-x-4">
        <div class="relative">
          <input type="text" placeholder="Search scholarships…"
                 class="pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400"/>
          <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="flex items-center space-x-2">
          <span class="font-medium">Supervisor</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-red-50 to-red-100 py-16">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-4xl font-extrabold text-red-600 mb-4">Welcome Supervisor!</h2>
      <p class="text-lg text-gray-600">Here are the scholarships you’re currently overseeing.</p>
    </div>
  </section>

  <!-- Scholarship Grid -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    @if ($scholarships->isEmpty())
      <div class="text-center py-20 bg-white rounded-xl shadow">
        <i class="fas fa-user-graduate text-red-200 text-5xl mb-4"></i>
        <p class="text-gray-500 text-lg">No scholarships assigned yet.</p>
      </div>
    @else
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($scholarships as $scholarship)
          <div class="relative bg-white rounded-2xl shadow hover:shadow-lg transform hover:-translate-y-1 transition p-6 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-100 rounded-full"></div>
            <h3 class="text-xl font-semibold mb-4 z-10 relative">{{ $scholarship->name }}</h3>
            <div class="flex items-center space-x-4 z-10 relative mb-6">
              <div class="p-3 bg-red-50 rounded-full">
                <i class="fas fa-users text-red-500 text-xl"></i>
              </div>
              <div>
                <p class="text-sm text-gray-500">Students Registered</p>
                <p class="text-2xl font-bold">{{ $scholarship->students_count }}</p>
              </div>
            </div>
            <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarship->scholarshipID]) }}"
               class="relative inline-block w-full py-2 font-medium text-white bg-red-500 rounded-full overflow-hidden focus:outline-none">
              View Details
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <script>
    // Ripple effect on buttons
    document.querySelectorAll('a').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const circle = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        circle.style.width = circle.style.height = size + 'px';
        circle.style.left = e.clientX - rect.left - size/2 + 'px';
        circle.style.top = e.clientY - rect.top - size/2 + 'px';
        circle.classList.add('ripple');
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(circle);
        setTimeout(() => circle.remove(), 600);
      });
    });
  </script>

</body>
</html>
