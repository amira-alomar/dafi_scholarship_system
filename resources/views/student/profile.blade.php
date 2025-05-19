<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | Academic Portal</title>
    <link rel="stylesheet" href="{{ asset('css/studentProfile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="{{ asset('js/job.js') }}"></script>
</head>
<body>
<div style="display: flex; min-height: 100vh;">
      <!-- Sidebar Navigation -->
      <div class="sidebar">
  <div class="sidebar-header items-center space-x-2">
    <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
    <h1 class="sidebar-title text-xl font-bold">ScholarPath</h1>
  </div>
  
  <div class="sidebar-user">
    <div class="user-avatar">
      <img src="{{ optional(auth()->user())->profile_picture ? asset('storage/profile_images/' . optional(auth()->user())->profile_picture) : 'https://i.pravatar.cc/150?img=32' }}" alt="User avatar">
      
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
      </ul>
    </div>
  </nav>
    </div>
    <div style="flex: 1; margin-left: 260px; padding: 2rem;">
        <div class="container">
            <div class="profile-card">
                <div class="profile-pic-container">
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="profile-pic-upload">
                    <img src="{{ optional(auth()->user())->profile_picture ? asset('storage/profile_images/' . optional(auth()->user())->profile_picture) : 'https://i.pravatar.cc/150?img=32' }}" 
     alt="Profile Picture" 
     class="profile-pic"
     onclick="document.getElementById('profile-upload').click()">
     <input type="file" name="image" id="profile-upload" accept="image/*" class="hidden" onchange="document.getElementById('image-submit').click()">
                    </div>
                    <button type="submit" id="image-submit" class="hidden">Upload</button>
                </form>
                    <div class="profile-student-details">
                        <h3>{{ auth()->user()->fname }} {{ auth()->user()->lname }}</h3>
                        <p>Student ID: {{ $universityID ?? 'Not Set' }}</p>
                        <p>Academic Year: <span>{{ $year ?? 'Not Set' }} Year</span> </p>
                        <button onclick="document.getElementById('profile-upload').click()" 
                                class="btn btn-outline mt-2">
                            <i class="fas fa-camera mr-1"></i> Change Photo
                        </button>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <div class="profile-tab active" onclick="showTab('profile-tab')">Profile</div>
                <div class="profile-tab" onclick="showTab('courses-tab')">Saved Jobs</div>
                <div class="profile-tab" onclick="showTab('achievements-tab')">Skills</div>
            </div>
            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content active">
                <div class="stats-grid">
                    <div class="stat-card stat-card-blue">
                        <div class="stat-card-title">Major</div>
                        <div class="stat-card-value">{{ $major ?? 'Not Set' }}</div>
                    </div>
                    <div class="stat-card stat-card-red">
                        <div class="stat-card-title">GPA</div>
                        <div class="stat-card-value">{{ $gpa ?? 'Not Set' }}</div>
                    </div>
                    <div class="stat-card stat-card-green">
                        <div class="stat-card-title">Volunteering Hours</div>
                        <div class="stat-card-value">{{ $volunteeringHours }}</div>
                    </div>
                    <div class="stat-card stat-card-purple">
                        <div class="stat-card-title">Training Number</div>
                        <div class="stat-card-value">{{  $totalTrainings}}</div>
                    </div>
                </div>
                <div class="profile-card" id="personal-info">
                    <div class="profile-section-title">
                        <span>Personal Information</span>
                        <button onclick="toggleEditMode('personal-info')" class="btn btn-outline btn-sm">
                            <i class="fas fa-pen mr-1"></i> Edit
                        </button>
                    </div>
                    <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="profile-grid">
                        <div class="profile-info-item">
                            <div class="profile-info-label">Full Name</div>
                            <div class="profile-info-value">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</div>
                            <!-- <input type="text" class="profile-info-input" value=""> -->
                        </div>
                   
                        <div class="profile-info-item">
                            <div class="profile-info-label">Date of Birth</div>
                            <div class="profile-info-value"> {{ \Carbon\Carbon::parse(auth()->user()->birthdate)->format('M d, Y') }}</div>
                            <input type="date" class="profile-info-input" name="birthdate" value="{{ auth()->user()->birthdate }}">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Email</div>
                            <div class="profile-info-value">{{ auth()->user()->email }}</div>
                            <!-- <input type="email" class="profile-info-input" value=""> -->
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Phone</div>
                            <div class="profile-info-value">{{ auth()->user()->phone_number }}</div>
                            <input type="tel" class="profile-info-input" name="phone_number" value="{{ auth()->user()->phone_number }}">
                        </div>
                    </div>
                    <div class="profile-info-item mt-4">
                        <div class="profile-info-label">Address</div>
                        <div class="profile-info-value">{{ auth()->user()->address }}</div>
                        <textarea class="profile-info-input" name="address">{{ auth()->user()->address }}</textarea>
                    </div>
                    <div class="edit-buttons">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                        
                    </div>   
                </div>
                </form>
                <div class="profile-card" id="academic-info">
                    <div class="profile-section-title">
                        <span>Academic Information</span>
                        <button onclick="toggleEditMode('academic-info')" class="btn btn-outline btn-sm">
                            <i class="fas fa-pen mr-1"></i> Edit
                        </button>
                    </div>
                    <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="profile-grid">
                        <div class="profile-info-item">
                            <div class="profile-info-label">University</div>
                            <div class="profile-info-value">{{ $university ?? 'Not Set' }}</div>
                            
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">University ID</div>
                            <div class="profile-info-value">{{ $universityID ?? 'Not Set' }}</div>
                            <input type="text" class="profile-info-input" name="universityID" value="{{ $universityID ?? 'Not Set' }}">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Scholarship</div>
                            <div class="profile-info-value">{{ $scholarship ?? 'Not Set' }}</div>
                           
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">GPA</div>
                            <div class="profile-info-value">{{ $gpa ?? 'Not Set' }}</div>
                            <input type="number" name="gpa" step="0.1" class="profile-info-input" value="{{ $gpa ?? '' }}">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Expected Graduation</div>
                            <div class="profile-info-value">{{ $expected_graduation ?? 'Not Set' }}</div>
                            <input type="month" name="expected_graduation" class="profile-info-input" value="{{ $expected_graduation ?? 'Not Set' }}">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Major</div>
                            <div class="profile-info-value">{{ $major ?? 'Not Set' }}</div>
                            <input type="text" name="major" class="profile-info-input" value="{{ $major ?? 'Not Set' }}">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Current Year</div>
                            <div class="profile-info-value">{{ $year ?? 'Not Set' }} </div>
                            <input type="number" name="year" step="1" class="profile-info-input" value="{{ $year ?? 'Not Set' }}">
 
                        </div>
                    </div>
                    <div class="edit-buttons">
                        <button onclick="saveChanges('academic-info')" class="btn btn-primary" type="submit">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </div>

            </div>
            </form>
            <!-- Courses Tab -->
            <div id="courses-tab" class="tab-content">
                <div class="profile-card">
                    <div class="profile-section-title">
                        <span>Saved Jobs</span>
                    </div>
                     <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($savedJobs as $job)
            
        
                      <div class="card p-6 ">
                        <x-job-card :job="$job" />
</div>

        @empty
            <p class="text-gray-500">You haven't saved any jobs yet.</p>
        @endforelse
        </div>
                </div>
            </div>
            <!-- Achievements Tab -->
            <div id="achievements-tab" class="tab-content">
                <div class="profile-card">
                    <div class="profile-section-title flex items-center justify-between">
                        <span>Skills</span>
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById('add-skill-modal').classList.remove('hidden')">
                <i class="fas fa-plus mr-1"></i> Add Skill
            </button>
                    </div>
                    <div class="space-y-4">
                    @forelse($userSkills as $userSkill)
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-blue-100 rounded mr-4">
                                <i class="fas fa-certificate text-blue-500"></i>
                            </div>
                            <div class="flex-1">
                            <h3 class="font-medium">{{ $userSkill->skill->name }}</h3>
                            <p class="text-sm text-gray-500">Level: {{ $userSkill->level }}</p>
                               
                            </div>
                        </div>
                        @empty

                      
                <p class="text-gray-500">No skills added yet.</p>
           
                @endforelse  
                      </div>
                    </div>
                </div>
                <!-- Modal -->
<div id="add-skill-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-96 shadow-xl">
        <h2 class="text-xl font-semibold mb-4">Add New Skill</h2>
        <form method="POST" action="{{ route('profile.skills.add') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Skill Name</label>
                <select name="name" class="w-full border rounded px-3 py-2" required>
        @foreach($allSkills as $skill)
            <option value="{{ $skill->name }}">{{ $skill->name }}</option>
        @endforeach
    </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Level</label>
                <select name="level" class="w-full border rounded px-3 py-2" required>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('add-skill-modal').classList.add('hidden')" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>
 <!-- Modal -->
    <div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
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


<script>
    function showTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.profile-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected tab content
        document.getElementById(tabId).classList.add('active');
        
        // Set active class on clicked tab
        event.currentTarget.classList.add('active');
    }
    
    function toggleEditMode(sectionId) {
        const section = document.getElementById(sectionId);
        section.classList.toggle('edit-mode');
    }
    
</script>
</body>
</html>
