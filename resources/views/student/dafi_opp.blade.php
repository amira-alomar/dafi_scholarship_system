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
</head>
<body>
    <!-- Sidebar goes here -->
    <div class="flex">
        <div class="hidden md:block w-64 bg-gray-100 min-h-screen">
             <!-- Sidebar Navigation -->
      <div class="sidebar">
  <div class="sidebar-header">
    <img src="logo.svg" alt="Logo" class="sidebar-logo">
    <h1 class="sidebar-title">DAFI Scholarship</h1>
  </div>
  
  <div class="sidebar-user">
    <div class="user-avatar">
        <img src="/images/default-avatar.png" alt="User Avatar">
    </div>
    <div class="user-info">
      <h3 class="user-name">{{ optional(auth()->user())->fname ?? 'Guest' }}</h3>
      <p class="user-role"><span>{{ $major ?? 'Not Set' }}</span> Student</p>
     
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
            <span>DAFI Opportunity</span>
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
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">DAFI Opportunities</h1>
                    <p class="text-xl md:text-2xl mb-8">Empowering youth through training, volunteering, and events</p>
                    <button class="btn-primary px-6 py-3 rounded-full font-semibold text-lg">Explore Opportunities</button>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card 1 - Training -->
                      @foreach($opportunities as $opportunity)
                    <div class="card opportunity {{ strtolower($opportunity->type) }}">
                        <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Digital Marketing Workshop" class="card-image">
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
                    
                        <input type="hidden" id="opportunityType">
                        <div class="mb-4">
                            <label for="opportunityName" class="block text-gray-700 font-medium mb-2">Opportunity</label>
                            <input type="text" id="opportunityName" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                        </div>
                               <form id="applicationForm" method="POST" action="{{ route('applications.store') }}">
                            @csrf
                        <div class="mb-4">
                            <label for="fullName" class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" id="fullName" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" class="w-full px-4 py-2 border rounded-lg" required>
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

    <script>
        // Filter opportunities by type
        function filterOpportunities(type) {
            // Update active tab
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('tab-active');
                tab.classList.add('text-gray-600', 'hover:text-gray-900');
            });
            event.target.classList.add('tab-active');
            event.target.classList.remove('text-gray-600', 'hover:text-gray-900');

            // Show/hide opportunities
            const opportunities = document.querySelectorAll('.opportunity');
            opportunities.forEach(opp => {
                if (type === 'all' || opp.classList.contains(type)) {
                    opp.style.display = 'block';
                } else {
                    opp.style.display = 'none';
                }
            });
        }

        // Open application modal
        function openApplicationModal(title, type) {
            const modal = document.getElementById('applicationModal');
            document.getElementById('modalTitle').textContent = type === 'volunteering' ? 'Apply for Opportunity' : 'Register for Opportunity';
            document.getElementById('opportunityName').value = title;
            document.getElementById('opportunityType').value = type;
            modal.style.display = 'block';
        }

        // Close modal
        function closeModal() {
            document.getElementById('applicationModal').style.display = 'none';
            document.getElementById('applicationForm').reset();
        }

        // Handle form submission
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const opportunityName = document.getElementById('opportunityName').value;
            const fullName = document.getElementById('fullName').value;
            const email = document.getElementById('email').value;
            const motivation = document.getElementById('motivation').value;
            const type = document.getElementById('opportunityType').value;
            
            // Here you would typically send the data to a server
            console.log({
                opportunityName,
                fullName,
                email,
                motivation,
                type
            });
            
            // Show success message
            alert(`Thank you for your application to "${opportunityName}"! We'll be in touch soon.`);
            
            // Close modal
            closeModal();
        });

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('applicationModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>