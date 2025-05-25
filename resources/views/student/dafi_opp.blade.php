<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAFI Opportunities</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dafi_opp.css') }}">
     <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
      <script defer src="{{ asset('js/dafi.js') }}"></script>
</head>
<body>
    <!-- Sidebar goes here -->
    <div class="flex">
        <div class="hidden md:block w-64 bg-gray-100 min-h-screen">
             <!-- Sidebar Navigation -->
      <div class="sidebar">
  <div class="sidebar-header items-center space-x-2">
    <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
    <h1 class="sidebar-title text-xl font-bold">ScholarPath</h1>
  </div>
  
  <div class="sidebar-user">
    <div class="user-avatar">
         <img src="{{ optional(auth()->user())->profile_picture  ? asset('storage/profile_images/' . optional(auth()->user())->profile_picture) : 'https://i.pravatar.cc/150?img=32' }}" alt="User avatar">
    </div>
    <div class="user-info">
      <h3 class="user-name">{{ optional(auth()->user())->fname ?? 'Guest' }}</h3>
      <p class="user-role"><span>{{ $major ?? 'Not Set' }} </span> Student</p>
     
    </div>
  </div>
  
  <nav class="sidebar-nav">
    <div class="nav-section">
      <h4 class="nav-section-title">Main</h4>
      <ul class="nav-list">
        <li class="nav-item">
          <a href="{{ url('/student/dashboard') }}" class="nav-link">
            <i class="bx bx-home-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{ url('/acadmic') }}" class="nav-link">
            <i class="bx bx-book-open"></i>
            <span>Academic Information</span>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{ url('/dafi_opp') }}" class="nav-link">
            <i class="bx bx-notepad"></i>
            <span> Opportunity</span>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{ url('/jobs') }}" class="nav-link">
           <i class="bx bx-task"></i>
            <span>Job Opportunity</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/courses') }}" class="nav-link">
            <i class="bx bx-book"></i>
            <span>My Courses</span>
          </a>
        </li>
           <li class="nav-item">
          <a href="{{ route('student.clubs') }}" class="nav-link">
            <i class="bx bx-wink-smile"></i>
            <span>Clubs</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('student.profile') }}" class="nav-link">
            <i class="bx bx-calendar"></i>
            <span>Profile</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
    </div>
        </div>

        <div class="flex-1">
            <!-- Hero Section -->
            <section class="hero">
                <div class="px-4 md:px-8 max-w-4xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">ScholarPath Opportunities</h1>
                    <p class="text-xl md:text-2xl mb-8">Empowering youth through training, volunteering, and events</p>
                    <a href="#opportunityCards" class="btn-primary px-6 py-3 rounded-full font-semibold text-lg inline-block">
    Explore Opportunities
</a>

                </div>
            </section>

            <!-- Main Content -->
            <main class="container mx-auto px-4 py-12">
                <!-- Filter Tabs -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold mb-6">Find Your Opportunity</h2>
                    <div class="tabs-container">
                        <div class="tabs space-x-1">
                            <button onclick="filterOpportunities('all')" class="tab tab-active px-6 py-3 font-medium transition-colors duration-200">All</button>
                            <button onclick="filterOpportunities('training')" class="tab px-6 py-3 font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Training</button>
                            <button onclick="filterOpportunities('volunteer')" class="tab px-6 py-3 font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Volunteering</button>
                            <button onclick="filterOpportunities('event')" class="tab px-6 py-3 font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Events</button>
                        </div>
                    </div>
                </div>

                <!-- Opportunity Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="opportunityCards">
                    <!-- Card 1 - Training -->
                      @foreach($opportunities as $opportunity)
                    <div class="card opportunity {{ strtolower($opportunity->type) }}">
                    @if($opportunity->photo)
                <img src="{{ route('opportunity.photo', basename($opportunity->photo)) }}" alt="Digital Marketing Workshop" class="card-image">
                @else
                —  
                 @endif
                        <div class="card-content">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold">{{ $opportunity->title }}</h3>
                                <span class="badge badge-{{ strtolower($opportunity->type) }}">{{ $opportunity->type }}</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $opportunity->description }}</p>
                            <div class="flex items-center text-gray-500 mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ $opportunity->date }}</span>
                            </div>
                            <div class="flex items-center text-gray-500 mb-6">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $opportunity->location }}</span>
                            </div>
                        </div>
                        <div class="card-button">
                              @csrf
                            <button onclick="openApplicationModal('{{ $opportunity->title }}', '{{ $opportunity->type }}')" class="btn-primary w-full py-2 rounded-lg font-medium">  {{ $opportunity->type == 'event' ? 'Register Now ' : 'Apply Now' }}</button>
                        </div>
                       
                    </div>
                     @endforeach
                  
                   
                </div>
            </main>

            <!-- Application Modal -->
            <div id="applicationModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <h2 class="text-2xl font-bold mb-6" id="modalTitle">Apply for Opportunity</h2>
                    <form id="applicationForm" method="POST" action="{{ route('applications.store') }}">
                            @csrf
                        <input type="hidden" id="opportunityType">
                        <div class="mb-4">
                            <label for="opportunityName" class="block text-gray-700 font-medium mb-2">Opportunity</label>
                            <input type="text" id="opportunityName" class="w-full px-4 py-2 border rounded-lg bg-gray-100"name="opportunity_title"  readonly>
                        </div>
                               
                              <div class="mb-4">
                            <label for="fullName" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" id="fullName" value="{{ auth()->user()->fname }} {{ auth()->user()->lname }}" 
                                class="w-full px-4 py-2 border rounded-lg bg-gray-100" name="name" readonly >
                        </div>
                        <input type="hidden" name="status" value="pending">

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" value="{{ auth()->user()->email }}" 
                                class="w-full px-4 py-2 border rounded-lg bg-gray-100" name="email" readonly>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeModal()" class="btn-secondary px-6 py-2 rounded-lg font-medium">Cancel</button>
                            <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-medium">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@if(session('success'))
  <div id="success-toast" class="toast toast-success">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div id="error-toast" class="toast toast-error">
    {{ session('error') }}
  </div>
@endif

@if(session('success') || session('error'))
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      ['success-toast','error-toast'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 4000);
      });
    });
  </script>
@endif

</body>
</html>