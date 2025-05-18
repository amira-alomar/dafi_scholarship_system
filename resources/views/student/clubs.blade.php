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
    @if (session('success'))
        <div class="toast bg-green-500 text-white p-4 rounded shadow-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="toast bg-blue-500 text-white p-4 rounded shadow-md">
            {{ session('info') }}
        </div>
    @endif

    @if (session('error'))
        <div class="toast bg-red-500 text-white p-4 rounded shadow-md">
            {{ session('error') }}
        </div>
    @endif


    <!-- Sidebar goes here -->
    <div class="flex">
        <div class="hidden md:block w-64 bg-gray-100 min-h-screen">
            <!-- Sidebar Navigation -->
            <div class="sidebar">
                <div class="sidebar-header">
                    <img src="https://static.thenounproject.com/png/3314643-200.png" alt="Logo"
                        class="sidebar-logo">
                    <h1 class="sidebar-title">ScholarPath</h1>
                </div>

                <div class="sidebar-user">
                    <div class="user-avatar">
                        <img src="{{ optional(auth()->user())->profile_picture ? asset('storage/profile_images/' . optional(auth()->user())->profile_picture) : 'https://i.pravatar.cc/150?img=32' }}"
                            alt="User avatar">
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

        <!-- Main content -->
        <div class="flex-1 p-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Student Clubs</h1>
                <p class="text-lg text-gray-600">Join a community that matches your interests</p>
                <form method="GET" action="{{ route('student.clubs') }}"
                    class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search clubs..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary)]">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select name="category"
                            class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] bg-white">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-[var(--primary)] text-white hover:bg-[var(--accent)] transition">
                            Search
                        </button>
                </form>
        </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Club Card 1 -->
            @foreach ($clubs as $club)
                <div class="club-card bg-[var(--card)] rounded-lg overflow-hidden border border-[var(--border)]"
                    data-category="{{ $club->category }}">
                    <div class="p-4 flex justify-center">
                         @if ($club->image)
                                <img src="{{ route('partner.picture', basename($club->image)) }}" alt="Club Image"
                                    class="w-32 h-32 object-cover">
                            @else
                                <img src="https://lh3.googleusercontent.com/proxy/j35bVRSs4zGoF6EkUqQODb7k6v7cqTLNq9bfcpo6uYo19C16j4tDXunQzNF8tuVOQUQ8RM9HPlIJKEc0Zhcv6Wjg-3m0rS6MUCwPOtKD9mIgMvnD_-uKbFvfDcq7k7jS7CALgkqCSkSlJEdY72fNuYeECImKKK8wdOFpNhs"
                            alt="Debate Club Logo" class="club-logo rounded-lg w-full">
                            @endif

                        
                    </div>
                    <div class="p-4 pt-0">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">{{ $club->name }}</h3>
                            <span class="category-tag text-xs px-2 py-1 rounded-full">{{ $club->category }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-users mr-1"></i>
                            <span> {{ $club->accepted_users_count }} members</span>
                        </div>
                        <button class="view-details-btn w-full py-2 rounded-lg font-medium"
                            onclick="openModal('{{ addslashes($club->name) }}', '{{ $club->category }}','{{ $club->accepted_users_count }}', '{{ $club->image }}', '{{ addslashes($club->description) }}', '{{ $club->meeting_day ?? '' }}', '{{ $club->location ?? '' }}')">
                            View Details
                        </button>

                    </div>
                </div>
            @endforeach
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

                        <div class="flex items-center text-lg mb-2">
                            <i class="fas fa-users mr-2 text-[var(--accent)]"></i>
                            <span id="modalMembers">{{ $club->accepted_users_count }} members </span> members

                        </div>
                        <div class="mb-4">
                            <span id="modalCategory" class="text-sm px-3 py-1 rounded-full"></span>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <h3 class="text-xl font-semibold mb-3">About the Club</h3>
                        <p id="modalDescription" class="text-gray-700 mb-4"></p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="px-4 py-2 border border-[var(--border)] rounded-lg hover:bg-[var(--muted)] transition"
                    onclick="closeModal()">
                    Close
                </button>
                <form method="POST" action="{{ route('student.clubs.join') }}">
                    @csrf
                    <input type="hidden" name="club_id" id="modalClubId" value="">
                    <button class="join-btn px-6 py-2 rounded-lg font-medium" onclick="joinClub()">
                        <i class="fas fa-user-plus mr-2"></i> Join Club
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(name, category, members, image, description, meetingDay = '', location = '') {
            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalMembers').innerText = members;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('modalClubId').value = window.clubs.find(c => c.name === name)?.id || '';
            document.getElementById('clubModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('clubModal').classList.remove('show');
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

        // Passing clubs data for modal join
        window.clubs = @json($clubs);
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) toast.remove();
        }, 4000);
    </script>




    </script>
</body>

</html>
