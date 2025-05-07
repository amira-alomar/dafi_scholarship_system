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
</head>
<body>
<div style="display: flex; min-height: 100vh;">
      <!-- Sidebar Navigation -->
      <div class="sidebar">
  <div class="sidebar-header">
    <img src="logo.svg" alt="Logo" class="sidebar-logo">
    <h1 class="sidebar-title">DAFI Scholarship</h1>
  </div>
  
  <div class="sidebar-user">
    <div class="user-avatar">
      <img src="https://i.pravatar.cc/150?img=32" alt="User avatar">
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
            <div class="profile-header">
                <h1 class="profile-title">Student Profile</h1>
                <div class="profile-actions">
                    <button class="btn btn-secondary">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="profile-card">
                <div class="profile-pic-container">
                    <div class="profile-pic-upload">
                        <img src="https://i.pravatar.cc/150?img=32" 
                             alt="Profile Picture" 
                             class="profile-pic">
                        <div class="profile-pic-overlay">
                            <i class="fas fa-camera text-white text-xl"></i>
                        </div>
                        <input type="file" id="profile-upload" class="hidden" accept="image/*">
                    </div>
                    <div class="profile-student-details">
                        <h3>Yasmine</h3>
                        <p>Student ID: 210065</p>
                        <p>Academic Year: 3rd Year</p>
                        <button onclick="document.getElementById('profile-upload').click()" 
                                class="btn btn-outline mt-2">
                            <i class="fas fa-camera mr-1"></i> Change Photo
                        </button>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <div class="profile-tab active" onclick="showTab('profile-tab')">Profile</div>
                <div class="profile-tab" onclick="showTab('courses-tab')">Courses</div>
                <div class="profile-tab" onclick="showTab('achievements-tab')">Achievements</div>
            </div>
            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content active">
                <div class="stats-grid">
                    <div class="stat-card stat-card-blue">
                        <div class="stat-card-title">Major</div>
                        <div class="stat-card-value">Computer Science</div>
                    </div>
                    <div class="stat-card stat-card-red">
                        <div class="stat-card-title">CGPA</div>
                        <div class="stat-card-value">3.5</div>
                    </div>
                    <div class="stat-card stat-card-green">
                        <div class="stat-card-title">Volunteering Hours</div>
                        <div class="stat-card-value">85</div>
                    </div>
                    <div class="stat-card stat-card-purple">
                        <div class="stat-card-title">Training Hours</div>
                        <div class="stat-card-value">120</div>
                    </div>
                </div>
                <div class="profile-card" id="personal-info">
                    <div class="profile-section-title">
                        <span>Personal Information</span>
                        <button onclick="toggleEditMode('personal-info')" class="btn btn-outline btn-sm">
                            <i class="fas fa-pen mr-1"></i> Edit
                        </button>
                    </div>
                    <div class="profile-grid">
                        <div class="profile-info-item">
                            <div class="profile-info-label">Full Name</div>
                            <div class="profile-info-value">Yasmine</div>
                            <input type="text" class="profile-info-input" value="Yasmine">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Date of Birth</div>
                            <div class="profile-info-value">April 15, 2000</div>
                            <input type="date" class="profile-info-input" value="2000-04-15">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Gender</div>
                            <div class="profile-info-value">Female</div>
                            <select class="profile-info-input">
                                <option value="Male">Male</option>
                                <option value="Female" selected>Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Nationality</div>
                            <div class="profile-info-value">Lebanese</div>
                            <input type="text" class="profile-info-input" value="Lebanese">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Email</div>
                            <div class="profile-info-value">yasminalkathi7@gmail.com</div>
                            <input type="email" class="profile-info-input" value="yasminalkathi7@gmail.com">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Phone</div>
                            <div class="profile-info-value">+961 71 123 456</div>
                            <input type="tel" class="profile-info-input" value="+961 71 123 456">
                        </div>
                    </div>
                    <div class="profile-info-item mt-4">
                        <div class="profile-info-label">Address</div>
                        <div class="profile-info-value">123 Main Street, Tripoli, Lebanon</div>
                        <textarea class="profile-info-input">123 Main Street, Tripoli, Lebanon</textarea>
                    </div>
                    <div class="edit-buttons">
                        <button onclick="saveChanges('personal-info')" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                        <button onclick="toggleEditMode('personal-info')" class="btn btn-outline">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
                <div class="profile-card" id="academic-info">
                    <div class="profile-section-title">
                        <span>Academic Information</span>
                        <button onclick="toggleEditMode('academic-info')" class="btn btn-outline btn-sm">
                            <i class="fas fa-pen mr-1"></i> Edit
                        </button>
                    </div>
                    <div class="profile-grid">
                        <div class="profile-info-item">
                            <div class="profile-info-label">University</div>
                            <div class="profile-info-value">Al-Manar University of Tripoli</div>
                            <input type="text" class="profile-info-input" value="Al-Manar University of Tripoli">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">GPA</div>
                            <div class="profile-info-value">3.5</div>
                            <input type="number" step="0.1" class="profile-info-input" value="3.5">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Expected Graduation</div>
                            <div class="profile-info-value">June 2024</div>
                            <input type="month" class="profile-info-input" value="2024-06">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Major</div>
                            <div class="profile-info-value">Computer Science</div>
                            <input type="text" class="profile-info-input" value="Computer Science">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Faculty</div>
                            <div class="profile-info-value">Engineering & Technology</div>
                            <input type="text" class="profile-info-input" value="Engineering & Technology">
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Current Year</div>
                            <div class="profile-info-value">Third Year</div>
                            <select class="profile-info-input">
                                <option>First Year</option>
                                <option>Second Year</option>
                                <option selected>Third Year</option>
                                <option>Fourth Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="edit-buttons">
                        <button onclick="saveChanges('academic-info')" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                        <button onclick="toggleEditMode('academic-info')" class="btn btn-outline">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
            <!-- Courses Tab -->
            <div id="courses-tab" class="tab-content">
                <div class="profile-card">
                    <div class="profile-section-title">
                        <span>Current Courses</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-2">Course Code</th>
                                    <th class="pb-2">Course Name</th>
                                    <th class="pb-2">Instructor</th>
                                    <th class="pb-2">Credits</th>
                                    <th class="pb-2">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-3">CS-301</td>
                                    <td>Database Systems</td>
                                    <td>Dr. Mohammed Ali</td>
                                    <td>3</td>
                                    <td>A-</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">CS-320</td>
                                    <td>Advanced Algorithms</td>
                                    <td>Prof. Sarah Johnson</td>
                                    <td>4</td>
                                    <td>B+</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">CS-350</td>
                                    <td>Web Development</td>
                                    <td>Dr. Hassan Kamal</td>
                                    <td>3</td>
                                    <td>A</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">MATH-240</td>
                                    <td>Discrete Mathematics</td>
                                    <td>Dr. Layla Ghanem</td>
                                    <td>3</td>
                                    <td>B</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="profile-card">
                    <div class="profile-section-title">
                        <span>Completed Courses</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-2">Course Code</th>
                                    <th class="pb-2">Course Name</th>
                                    <th class="pb-2">Semester</th>
                                    <th class="pb-2">Credits</th>
                                    <th class="pb-2">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-3">CS-101</td>
                                    <td>Introduction to Programming</td>
                                    <td>Fall 2021</td>
                                    <td>3</td>
                                    <td>A</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">CS-201</td>
                                    <td>Data Structures</td>
                                    <td>Spring 2022</td>
                                    <td>4</td>
                                    <td>A-</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">CS-210</td>
                                    <td>Computer Architecture</td>
                                    <td>Fall 2022</td>
                                    <td>3</td>
                                    <td>B+</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3">CS-230</td>
                                    <td>Operating Systems</td>
                                    <td>Spring 2023</td>
                                    <td>4</td>
                                    <td>B</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Achievements Tab -->
            <div id="achievements-tab" class="tab-content">
                <div class="profile-card">
                    <div class="profile-section-title">
                        <span>Certificates</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-blue-100 rounded mr-4">
                                <i class="fas fa-certificate text-blue-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Web Development Fundamentals</h3>
                                <p class="text-sm text-gray-500">Issued: Mar 12, 2023</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-eye mr-1"></i> View
                            </button>
                        </div>
                        
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-blue-100 rounded mr-4">
                                <i class="fas fa-certificate text-blue-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Data Structures & Algorithms</h3>
                                <p class="text-sm text-gray-500">Issued: Jan 5, 2023</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-eye mr-1"></i> View
                            </button>
                        </div>
                        
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-blue-100 rounded mr-4">
                                <i class="fas fa-certificate text-blue-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Python Programming</h3>
                                <p class="text-sm text-gray-500">Issued: Nov 20, 2022</p>
                            </div>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-eye mr-1"></i> View
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="profile-card">
                    <div class="profile-section-title">
                        <span>Awards & Honors</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-yellow-100 rounded mr-4">
                                <i class="fas fa-trophy text-yellow-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Dean's List</h3>
                                <p class="text-sm text-gray-500">Spring Semester 2023</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-yellow-100 rounded mr-4">
                                <i class="fas fa-trophy text-yellow-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Academic Excellence Award</h3>
                                <p class="text-sm text-gray-500">Fall Semester 2022</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                            <div class="p-2 bg-yellow-100 rounded mr-4">
                                <i class="fas fa-trophy text-yellow-500"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">Programming Competition - 2nd Place</h3>
                                <p class="text-sm text-gray-500">University Tech Week 2022</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    
    function saveChanges(sectionId) {
        const section = document.getElementById(sectionId);
        
        // Here you would typically send the data to your server
        // For demonstration, we'll just update the display values with input values
        
        section.querySelectorAll('.profile-info-item').forEach(item => {
            const value = item.querySelector('.profile-info-value');
            const input = item.querySelector('.profile-info-input');
            
            if (input.tagName === 'SELECT') {
                value.textContent = input.options[input.selectedIndex].text;
            } else if (input.type === 'date') {
                value.textContent = new Date(input.value).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } else if (input.type === 'month') {
                const date = new Date(input.value);
                value.textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long'
                });
            } else {
                value.textContent = input.value;
            }
        });
        
        // Exit edit mode
        section.classList.remove('edit-mode');
    }
</script>
</body>
</html>
