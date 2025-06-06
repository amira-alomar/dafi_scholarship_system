<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Opportunities</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/job.css') }}">
    <script defer src="{{ asset('js/job.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
</head>

<body class="min-h-screen">
    <div style="display: flex; min-height: 100vh;">
        <!-- Sidebar Navigation -->
        <div class="sidebar hidden md:flex md:flex-col">
            <div class="sidebar-header items-center space-x-2">
                <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
                <h1 class="sidebar-title text-xl font-bold">DAFI Scholarship</h1>
            </div>
            <div class="sidebar-user">
                <div class="user-avatar">
                    <img src="{{ optional(auth()->user())->profile_picture ? asset('storage/profile_images/' . optional(auth()->user())->profile_picture) : 'https://i.pravatar.cc/150?img=32' }}"
                        alt="User avatar">
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
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="bx bx-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar (left) -->
                <div class="sidebar hidden lg:block w-64 shadow-sm h-fit sticky top-8">
                </div>
                <!-- Main content -->
                <div class="flex-1">
                    <!-- Search bar -->
                    <div class="mb-8">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <input type="text" placeholder="Search jobs ..." id="skills"
                                    onkeyup="searchJobs()"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Job listings -->
                    <h2 class="text-2xl font-semibold mb-6">Available Jobs</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Job Card  -->
                        @foreach ($jobs as $job)
                            <x-job-card :job="$job" />
                        @endforeach


                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div id="modal"
            class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 id="modal-title" class="text-2xl font-semibold"></h3>
                            <div class="flex items-center text-gray-600 mt-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span id="modal-location"></span>
                            </div>
                        </div>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Your skills match:</span>
                            <span id="modal-skills">3/5 skills</span>
                        </div>
                        <div class="skill-progress">
                            <div id="modal-progress" class="skill-progress-fill" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-lg mb-2">Job Description</h4>
                        <p id="modal-description" class="text-gray-600">
                        </p>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-lg mb-2">Application method</h4>
                        <p id="modal-app" class="text-gray-600">
                        </p>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-lg mb-2">Company name</h4>
                        <p id="modal-company" class="text-gray-600">
                        </p>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-lg mb-2">Application deadline</h4>
                        <p id="modal-deadline" class="text-gray-600">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div id="success-toast" class="toast toast-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="error-toast" class="toast toast-error">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success') || session('error'))
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    ['success-toast', 'error-toast'].forEach(id => {
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
