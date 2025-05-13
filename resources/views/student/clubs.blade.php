<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Clubs Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
      <link rel="stylesheet" href="{{ asset('css/clubs.css') }}">


</head>
<body class="min-h-screen">
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
      
    </div>
    <div class="user-info">
      <h3 class="user-name">{{ optional(auth()->user())->fname ?? 'Guest' }}</h3>
      <p class="user-role"><span>Computer Science </span> Student</p>
     
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

        <!-- Main content -->
        <div class="flex-1 p-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Student Clubs</h1>
                <p class="text-lg text-gray-600">Join a community that matches your interests</p>
                
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <input type="text" placeholder="Search clubs..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary)]">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] bg-white">
                        <option value="">All Categories</option>
                        <option value="academic">Academic</option>
                        <option value="arts">Arts</option>
                        <option value="sports">Sports</option>
                        <option value="community">Community Service</option>
                        <option value="cultural">Cultural</option>
                    </select>
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Club Card 1 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://via.placeholder.com/150/16a3b8/ffffff?text=Debate" alt="Debate Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">Debate Society</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Academic</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>45 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Debate Society', 'Academic', '45', 'https://via.placeholder.com/150/16a3b8/ffffff?text=Debate', 'The Debate Society provides a platform for students to develop public speaking and critical thinking skills. We host weekly meetings, inter-college competitions, and workshops with experienced debaters.', 'Wednesdays', 'Student Center')">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Club Card 2 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7L3raeBR_kWHJZmZR4qbWTU4pXcx4OySrmI-D4sUv1dffcXnvrzase1vW45Vf-W5eYMo&usqp=CAU" alt="Robotics Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">Robotics Club</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Academic</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>32 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Robotics Club', 'Academic', '32', '', 'Explore the world of robotics through hands-on projects, competitions, and workshops. No prior experience needed - we welcome all skill levels!')">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Club Card 3 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://via.placeholder.com/150/313e53/ffffff?text=Photography" alt="Photography Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">Photography Club</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Arts</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>28 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Photography Club', 'Arts', '28', 'https://via.placeholder.com/150/313e53/ffffff?text=Photography', 'Capture moments and learn photography techniques from basics to advanced. We organize photo walks, exhibitions, and guest lectures from professional photographers.', 'Mondays', 'Arts Building')">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Club Card 4 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://via.placeholder.com/150/16a3b8/ffffff?text=Chess" alt="Chess Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">Chess Club</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Sports</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>18 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Chess Club', 'Sports', '18', 'https://via.placeholder.com/150/16a3b8/ffffff?text=Chess', 'Whether you\\'re a beginner or an experienced player, join us to improve your chess skills, participate in tournaments, and meet fellow chess enthusiasts.', 'Tuesdays', 'Library Annex')">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Club Card 5 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://via.placeholder.com/150/e05252/ffffff?text=Volunteer" alt="Volunteer Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold"> Volunteers</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Community</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>62 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Community Volunteers', 'Community', '62', 'https://via.placeholder.com/150/e05252/ffffff?text=Volunteer', 'Make a difference in our local community through various service projects, fundraising events, and volunteer opportunities. We partner with local organizations to create meaningful impact.', 'Thursdays', 'Community Center')">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Club Card 6 -->
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]">
                    <div class="p-4 flex justify-center">
                        <img src="https://via.placeholder.com/150/313e53/ffffff?text=Dance" alt="Dance Club Logo" class="club-logo rounded-lg w-full">
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">Cultural Dance</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">Cultural</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span>37 members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium" onclick="openModal('Cultural Dance', 'Cultural', '37', 'https://via.placeholder.com/150/313e53/ffffff?text=Dance', 'Celebrate diversity through dance! Learn traditional dances from around the world and perform at campus events. No experience necessary - just bring your enthusiasm!', 'Sundays', 'Dance Studio')">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <button class="px-6 py-2 border border-[var(--border)] rounded-lg hover:bg-[var(--muted)] transition">
                    Load More Clubs
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="clubModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle" class="text-2xl font-bold"></h2>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3">
                        <!-- <img id="modalImage" src="" alt="Club Logo" class="w-full rounded-lg mb-4"> -->
                        <div class="flex items-center text-lg mb-2">
                            <i class="fas fa-users mr-2 text-[var(--accent)]"></i>
                            <span id="modalMembers"></span> members
                        </div>
                        <div class="mb-4">
                            <span id="modalCategory" class="text-sm px-3 py-1 rounded-full"></span>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <h3 class="text-xl font-semibold mb-3">About the Club</h3>
                        <p id="modalDescription" class="text-gray-700 mb-4"></p>
                        
                        <div class="mb-4">
                            <!-- <h4 class="font-medium mb-2">Meeting Details</h4> -->
                            <div class="flex items-center mb-2">
                                <!-- <i class="fas fa-calendar-day mr-2 text-[var(--accent)]"></i> -->
                                <span id="modalMeetingDay"></span>
                            </div>
                            <div class="flex items-center">
                                <!-- <i class="fas fa-map-marker-alt mr-2 text-[var(--accent)]"></i> -->
                                <span id="modalLocation"></span>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="px-4 py-2 border border-[var(--border)] rounded-lg hover:bg-[var(--muted)] transition" onclick="closeModal()">
                    Close
                </button>
                <button class="join-btn px-6 py-2 rounded-lg font-medium" onclick="joinClub()">
                    <i class="fas fa-user-plus mr-2"></i> Join Club
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal(name, category, members, image, description, meetingDay, location) {
            const modal = document.getElementById('clubModal');
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalCategory').textContent = category;
            document.getElementById('modalCategory').className = `text-sm px-3 py-1 rounded-full ${getCategoryColor(category)}`;
            document.getElementById('modalMembers').textContent = members;
            // document.getElementById('modalImage').src = image;
            // document.getElementById('modalImage').alt = `${name} Logo`;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalMeetingDay').textContent = meetingDay;
            document.getElementById('modalLocation').textContent = location;
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('clubModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function joinClub() {
            const clubName = document.getElementById('modalTitle').textContent;
            alert(`You have successfully joined ${clubName}!`);
            closeModal();
        }

        function getCategoryColor(category) {
            const colors = {
                'Academic': 'bg-blue-100 text-blue-800',
                'Arts': 'bg-purple-100 text-purple-800',
                'Sports': 'bg-green-100 text-green-800',
                'Community': 'bg-red-100 text-red-800',
                'Cultural': 'bg-yellow-100 text-yellow-800'
            };
            return colors[category] || 'bg-gray-100 text-gray-800';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('clubModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('clubModal');
            if (event.key === 'Escape' && modal.style.display === 'flex') {
                closeModal();
            }
        });

        // Sample data for demonstration (could be replaced with actual API calls)
        const clubs = [
            {
                name: "Debate Society",
                category: "Academic",
                members: 45,
                description: "The Debate Society provides a platform for students to develop public speaking and critical thinking skills. We host weekly meetings, inter-college competitions, and workshops with experienced debaters.",
                meeting: "Wednesdays",
                location: "Student Center",
                color: "16a3b8"
            },
            // More club data would go here...
        ];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // renderClubs(); // Uncomment if using dynamic rendering
        });
    </script>
</body>
</html>