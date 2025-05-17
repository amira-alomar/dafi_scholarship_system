<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - DAFI Scholarship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
        <link rel="stylesheet" href="{{ asset('css/DashboardAcceptedStudents.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
                    <h1 class="text-2xl md:text-3xl font-bold">Welcome back, {{ optional(auth()->user())->fname ?? 'Guest' }}!</h1>
                    <p class="text-gray-500">Track your progress, opportunities, and academic journey.</p>
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
                            <h3 class="text-2xl font-bold">{{ $gpa ?? 'Not Set' }}</h3>
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
                            <h3 class="text-2xl font-bold">{{ $volunteeringHours }}</h3>
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
                            <h3 class="text-2xl font-bold">{{  $totalTrainings}}</h3>
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
                </div>
                <div class="space-y-6">
                    
                        @foreach($goals as  $goal)
                        <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium">{{ $goal->title }}</h3>
                            <span class="text-sm text-gray-500">Due: {{ $goal->due_date->format('M d, Y') }}</span>
                            
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="progress-bar flex-1">
                           @php
                                $progress = min(100, max(0, $goal->progress));
                            @endphp

                            <div class="progress-fill" style="width: {{ $progress }}%; background-color: {{ $goal->completion_color }};"></div>

                            </div>
                            <span class="text-sm font-medium">{{ $goal->progress }}%</span>
                            <span class="text-sm font-medium" >{{ $goal->days_remaining }} days remaining</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


<!-- Opportunities Feed -->
<div class="card p-6 mb-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Your Applications</h2>
  </div>

  @if($applications->isEmpty())
    <p class="text-gray-500">You haven't applied for any opportunity yet.</p>
  @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($applications as $app)
      
        <div class="card opportunity {{ strtolower($app->type) }} p-4 border border-gray-200 hover:border-gray-300">
   @if($app->photo)
      <img 
        src="{{ route('opportunity.photo', basename($app->photo)) }}" 
        alt="{{ $app->title }}" 
        class="w-full h-32 md:h-40 rounded-md object-cover mb-4"
      >
    @else
      <div class="w-full h-32 md:h-40 rounded-md bg-gray-100 mb-4 flex items-center justify-center">
        <span class="text-gray-400 text-sm">No image</span>
      </div>
    @endif
          <div class="flex justify-between items-start mb-3">
            <h3 class="font-medium">{{ $app->title }}</h3>
           
            <span class="badge badge-{{ strtolower($app->type) }}">{{ ucfirst($app->type) }}</span>
          </div>
          <div> <p class="text-sm text-gray-600 mb-3">{{ $app->description }}</p></div>

          <p class="text-sm text-gray-500 mb-2">
 <i class="far fa-calendar mr-2"></i>
            Applied:   @if($app->pivot->application_date)
    {{ \Carbon\Carbon::parse($app->pivot->application_date)->format('M d, Y') }}
  @else
    <span class="text-red-400">Not available</span>
  @endif
          </p>

          <div class="mb-4">
            @php
              $status = $app->pivot->status;
              $colors = [
                'accepted' => 'bg-green-100 text-green-800',
                'rejected' => 'bg-red-100 text-red-800',
                'pending'  => 'bg-yellow-100 text-yellow-800',
              ];
            @endphp
            <span class="px-2 py-1 rounded-full text-sm {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
              {{ ucfirst($status) }}
            </span>
          </div>

        </div>
      @endforeach
    </div>
  @endif
</div>

 <!-- Job Matches in Dashboard -->
<div class="card p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Jobs Matching Your Skills</h2>
        <a href="{{ url('/jobs') }}" class="text-blue-600 hover:text-blue-800">View All</a>
    </div>

    @if($jobs->isEmpty())
        <p class="text-gray-500">No matching job opportunities found.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($jobs->take(3) as $job)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <h3 class="text-lg font-semibold mb-1">{{ $job->title }}</h3>
                    <div class="text-sm text-gray-500 flex items-center gap-4 mb-2">
                        <span><i class="far fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($job->posting_date)->diffForHumans() }}
                        </span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $job->description }}</p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-green-600 font-medium">
                            Match: {{ $job->match_count }}/{{ $job->total_skills }}
                        </span>
                        <form method="POST" action="{{ route('jobs.save',  $job->jobID) }}">
                              @csrf
                            <button  type="submit" onclick="showToast()" class="text-secondary hover:text-secondary-dark flex items-center gap-1">
                                <i class="far fa-star"></i>
                                <span>Save</span>
                            </button>
                            </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>


<!-- My Courses Preview -->
<div class="card p-6 mb-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Registered Courses ({{ now()->year }})</h2>
    @if($remainingCount > 0)
      <a href="{{ route('student.courses') }}"
         class="text-blue-600 hover:text-blue-800">
        View All ({{ $remainingCount }} more)
      </a>
    @endif
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($dashboardCourses as $course)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course->semester }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $course->course_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $course->grade ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                @if($course->image)
              <a href="{{ asset('public/course_images/' . $course->image) }}" target="_blank" class="text-blue-600 hover:underline mr-3">View</a>
               @else
                  —
                @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No courses for {{ now()->year }}.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


 {{-- Student Clubs Preview --}}
<div class="card p-6 mb-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">My Clubs</h2>
    @if($dashboardClubs->count() > 4)
      <a href="{{ route('student.clubs') }}" class="text-blue-600 hover:text-blue-800">
        View All ({{ $dashboardClubs->count() - 4 }} more)
      </a>
    @endif
  </div>

  @if($dashboardClubs->isEmpty())
    <p class="text-gray-500">You have not joined or applied to any clubs yet.</p>
  @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($dashboardClubs->take(4) as $club)
      
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
          <div class="flex items-center space-x-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
              <i class="fas fa-users text-blue-600"></i>
            </div>
            <div>
              <h3 class="font-medium">{{ $club->name }}</h3>
              <span class="text-sm text-gray-500">{{ $club->category }}</span>
            </div>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">
              <i class="fas fa-users mr-1"></i>
              {{ $club->accepted_users_count }} members
            </span>
            @php
              $status = $club->pivot->status;
              $badge = $status === 'accepted'
                ? 'bg-green-100 text-green-800'
                : 'bg-yellow-100 text-yellow-800';
            @endphp
            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
              {{ ucfirst($status) }}
            </span>
          </div>
        </div>
      @endforeach
    </div>
  @endif
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
                // Toast notification
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>