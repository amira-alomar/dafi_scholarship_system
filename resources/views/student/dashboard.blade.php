<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - DAFI Scholarship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --background: #f5f5f5;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --primary: #e05252;
            --primary-foreground: #f8fafc;
            --secondary: #313e53;
            --secondary-foreground: #f8fafc;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #16a3b8;
            --accent-foreground: #f8fafc;
            --destructive: #ef4444;
            --destructive-foreground: #f8fafc;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --radius: 0.5rem;
            --font-sans: system-ui, 'Segoe UI', Roboto, Arial, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
        }

        .card {
            background-color: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: var(--muted);
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background-color: var(--primary);
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-training {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .badge-volunteering {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-event {
            background-color: #fae8ff;
            color: #86198f;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn-primary:hover {
            background-color: #c94545;
        }

        .btn-accent {
            background-color: var(--accent);
            color: var(--accent-foreground);
        }

        .btn-accent:hover {
            background-color: #0d8a9c;
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
        }

        .btn-secondary:hover {
            background-color: #253348;
        }

        .tab-active {
            border-bottom: 2px solid var(--primary);
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-3 {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex">
        <!-- Sidebar goes here -->
        <div class="hidden md:block w-64 bg-white border-r border-gray-200">
       
      <!-- Sidebar Navigation -->
      <div class="sidebar">
  <div class="sidebar-header">
    <img src="https://static.thenounproject.com/png/3314643-200.png" alt="Logo" class="sidebar-logo">
    <h1 class="sidebar-title">ScholarPath</h1>
  </div>
  
  <div class="sidebar-user">
    <div class="user-avatar">
      <img src=" https://avatar.iran.liara.run/public/97">
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

        <div class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Welcome back, Yasmine!</h1>
                    <p class="text-gray-500">Track your progress, opportunities, and academic journey.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 font-medium">Y</span>
                        </div>
                        <span class="absolute top-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
            </div>

            <!-- At-a-Glance Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="card p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">GPA</p>
                            <h3 class="text-2xl font-bold">3.40</h3>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-hands-helping text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Volunteering Hours</p>
                            <h3 class="text-2xl font-bold">22</h3>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-certificate text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Trainings Completed</p>
                            <h3 class="text-2xl font-bold">1</h3>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-book text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Courses Registered</p>
                            <h3 class="text-2xl font-bold">3</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Goals -->
            <div class="card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Academic Goals</h2>
                    <button class="px-4 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
                        <i class="fas fa-plus mr-2"></i>Add Goal
                    </button>
                </div>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">Complete Research Project</h3>
                            <span class="text-sm text-gray-500">Due: May 13, 2025</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="progress-bar flex-1">
                                <div class="progress-fill" style="width: 83%"></div>
                            </div>
                            <span class="text-sm font-medium">83%</span>
                        </div>
                        <div class="flex space-x-2 mt-3">
                            <button class="px-3 py-1 text-sm rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                Update Progress
                            </button>
                            <button class="px-3 py-1 text-sm rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                Delete
                            </button>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">Improve GPA to 3.5</h3>
                            <span class="text-sm text-gray-500">Due: Dec 15, 2024</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="progress-bar flex-1">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                            <span class="text-sm font-medium">45%</span>
                        </div>
                        <div class="flex space-x-2 mt-3">
                            <button class="px-3 py-1 text-sm rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                Update Progress
                            </button>
                            <button class="px-3 py-1 text-sm rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opportunities Feed -->
            <div class="card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Your Opportunities</h2>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 text-sm rounded-md tab-active">All</button>
                        <button class="px-3 py-1 text-sm rounded-md hover:bg-gray-100">Training</button>
                        <button class="px-3 py-1 text-sm rounded-md hover:bg-gray-100">Volunteering</button>
                        <button class="px-3 py-1 text-sm rounded-md hover:bg-gray-100">Events</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium">Leadership Workshop</h3>
                            <span class="badge badge-training">Training</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Develop essential leadership skills for academic and professional success.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="far fa-calendar mr-2"></i>
                            <span>May 20, 2024</span>
                            <i class="far fa-map-marker-alt ml-4 mr-2"></i>
                            <span>Main Campus</span>
                        </div>
                        <button class="w-full py-2 rounded-md btn-primary hover:bg-red-600">
                            Register
                        </button>
                    </div>
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium">Community Cleanup</h3>
                            <span class="badge badge-volunteering">Volunteering</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Join fellow students in cleaning up the local community park.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="far fa-calendar mr-2"></i>
                            <span>June 5, 2024</span>
                            <i class="far fa-map-marker-alt ml-4 mr-2"></i>
                            <span>Riverside Park</span>
                        </div>
                        <button class="w-full py-2 rounded-md btn-accent hover:bg-cyan-700">
                            Apply Now
                        </button>
                    </div>
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium">Career Fair</h3>
                            <span class="badge badge-event">Event</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Connect with top employers and explore internship opportunities.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="far fa-calendar mr-2"></i>
                            <span>April 15, 2024</span>
                            <i class="far fa-map-marker-alt ml-4 mr-2"></i>
                            <span>University Hall</span>
                        </div>
                        <button class="w-full py-2 rounded-md btn-primary hover:bg-red-600">
                            Register
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listings Preview -->
            <div class="card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Available Jobs</h2>
                    <button class="text-blue-600 hover:text-blue-800">View All</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <h3 class="font-medium mb-2">Research Assistant</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar mr-2"></i>
                            <span>Posted: Mar 12, 2024</span>
                            <i class="far fa-map-marker-alt ml-4 mr-2"></i>
                            <span>Biology Dept</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Assist professors with ongoing research projects in molecular biology.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-green-600">Your skills match: 1/1 skills</span>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 hover:bg-gray-200">
                                    View Details
                                </button>
                                <button class="px-3 py-1 text-sm rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <h3 class="font-medium mb-2">Library Assistant</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar mr-2"></i>
                            <span>Posted: Mar 5, 2024</span>
                            <i class="far fa-map-marker-alt ml-4 mr-2"></i>
                            <span>Main Library</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Help organize materials and assist students with finding resources.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-green-600">Your skills match: 1/1 skills</span>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm rounded-md bg-gray-100 hover:bg-gray-200">
                                    View Details
                                </button>
                                <button class="px-3 py-1 text-sm rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Courses -->
            <div class="card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Registered Courses</h2>
                    <button class="text-blue-600 hover:text-blue-800">View All</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Spring 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">Advanced Biology</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A-</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                    <button class="text-gray-600 hover:text-gray-900">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Spring 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">Statistics 101</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">B+</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                    <button class="text-gray-600 hover:text-gray-900">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Spring 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">Literature Survey</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                    <button class="text-gray-600 hover:text-gray-900">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Student Clubs -->
            <div class="card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Student Clubs</h2>
                    <div class="flex space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search clubs..." class="pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>All Categories</option>
                            <option>Academic</option>
                            <option>Arts</option>
                            <option>Sports</option>
                            <option>Cultural</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-flask text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Science Club</h3>
                                <span class="text-sm text-gray-500">Academic</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600"><i class="fas fa-users mr-1"></i> 45 members</span>
                            <button class="px-3 py-1 text-sm rounded-md bg-gray-100 hover:bg-gray-200">
                                View Details
                            </button>
                        </div>
                    </div>
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-paint-brush text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Art Society</h3>
                                <span class="text-sm text-gray-500">Arts</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600"><i class="fas fa-users mr-1"></i> 32 members</span>
                            <button class="px-3 py-1 text-sm rounded-md bg-gray-100 hover:bg-gray-200">
                                View Details
                            </button>
                        </div>
                    </div>
                    <div class="card p-4 border border-gray-200 hover:border-gray-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="fas fa-running text-red-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Track Team</h3>
                                <span class="text-sm text-gray-500">Sports</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600"><i class="fas fa-users mr-1"></i> 28 members</span>
                            <button class="px-3 py-1 text-sm rounded-md bg-gray-100 hover:bg-gray-200">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Snapshot -->
            <div class="card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Profile Snapshot</h2>
                    <div class="flex space-x-3">
                        <button class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200">
                            Edit Profile
                        </button>
                        <button class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200">
                            Change Photo
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium">Yasmine Mohamad</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Major</p>
                                <p class="font-medium">Computer Science</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">GPA</p>
                                <p class="font-medium">3.40</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Student ID</p>
                                <p class="font-medium">12233883</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Current Year</p>
                                <p class="font-medium">third</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium mb-4">Contact Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">yasmine.mohamad@dafi.edu</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">+1 (555) 123-4567</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium">123 University Ave, Apt 4B<br>College Town, CT 06511</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple script to handle tab switching in Opportunities section
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-active, .hover\\:bg-gray-100');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('tab-active'));
                    // Add active class to clicked tab
                    this.classList.add('tab-active');
                    
                    // In a real app, you would filter the opportunities here
                });
            });
        });
    </script>
</body>
</html>