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
    <!-- <script defer src="{{ asset('js/job.js') }}"></script> -->
     <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
</head>
<body class="min-h-screen">
    
<div style="display: flex; min-height: 100vh;">
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
                            <input 
                                type="text" 
                                placeholder="Search jobs ..." 
                                id="skills"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                            <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
                        </div>
                        <button onclick="searchJobs()" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition flex items-center gap-2">
                            <span>Search</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Job listings -->
                <h2 class="text-2xl font-semibold mb-6">Available Jobs</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Job Card 1 -->
                    @foreach($jobs as $job)
                    <div class="job-card bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                        <div class="p-6 job-card-content">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold">{{ $job->title }}e</h3>
                                <span class="text-sm text-gray-500">2 days ago</span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>Remote</span>
                            </div>
                            <p class="text-gray-600 mb-4">We're looking for a skilled frontend developer to join our team and help build amazing user experiences.</p>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Your skills match:</span>
                                    <span>3/5 skills</span>
                                </div>
                                <div class="skill-progress">
                                    <div class="skill-progress-fill" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-footer p-6 pt-0 border-t border-gray-100 flex justify-between items-center">
                            <button onclick="openModal('frontend')" class="text-primary hover:text-primary-dark font-medium">View Details</button>
                            <button onclick="showToast()" class="text-secondary hover:text-secondary-dark flex items-center gap-1">
                                <i class="far fa-star"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                    @endforeach

 
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast fixed bottom-4 right-4 hidden bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2">
        <i class="fas fa-check-circle text-green-500"></i>
        <span>Job saved successfully</span>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 id="modal-title" class="text-2xl font-semibold">Frontend Developer</h3>
                        <div class="flex items-center text-gray-600 mt-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span id="modal-location">Remote</span>
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
                        We're looking for a skilled frontend developer to join our team and help build amazing user experiences. 
                        You'll work with React, TypeScript, and modern CSS frameworks to create responsive, accessible interfaces.
                    </p>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium text-lg mb-2">Requirements</h4>
                    <ul id="modal-requirements" class="list-disc pl-5 text-gray-600 space-y-1">
                        <li>3+ years experience with React</li>
                        <li>Strong TypeScript skills</li>
                        <li>Experience with responsive design</li>
                        <li>Familiarity with testing frameworks</li>
                        <li>Good communication skills</li>
                    </ul>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button onclick="showToast()" class="text-secondary hover:text-secondary-dark flex items-center gap-1 px-4 py-2 rounded-lg border border-gray-200">
                        <i class="far fa-star"></i>
                        <span>Save</span>
                    </button>
                    <button class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition">
                        Apply Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toast notification
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Modal functions
        function openModal(jobType) {
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Set modal content based on job type
            switch(jobType) {
                case 'frontend':
                    document.getElementById('modal-title').textContent = 'Frontend Developer';
                    document.getElementById('modal-location').textContent = 'Remote';
                    document.getElementById('modal-skills').textContent = '3/5 skills';
                    document.getElementById('modal-progress').style.width = '60%';
                    document.getElementById('modal-description').textContent = "We're looking for a skilled frontend developer to join our team and help build amazing user experiences. You'll work with React, TypeScript, and modern CSS frameworks to create responsive, accessible interfaces.";
                    
                    const frontendRequirements = [
                        '3+ years experience with React',
                        'Strong TypeScript skills',
                        'Experience with responsive design',
                        'Familiarity with testing frameworks',
                        'Good communication skills'
                    ];
                    setRequirements(frontendRequirements);
                    break;
                case 'devops':
                    document.getElementById('modal-title').textContent = 'DevOps Engineer';
                    document.getElementById('modal-location').textContent = 'Austin, TX';
                    document.getElementById('modal-skills').textContent = '3/5 skills';
                    document.getElementById('modal-progress').style.width = '60%';
                    document.getElementById('modal-description').textContent = "Implement CI/CD pipelines and manage cloud infrastructure for our growing platform. You'll automate deployments, monitor system health, and ensure our services are highly available and performant.";
                    
                    const devopsRequirements = [
                        'Experience with Kubernetes and Docker',
                        'CI/CD pipeline implementation',
                        'Infrastructure as code (Terraform, CloudFormation)',
                        'Monitoring and logging tools',
                        'Scripting skills (Bash, Python)'
                    ];
                    setRequirements(devopsRequirements);
                    break;
            }
        }

        function setRequirements(items) {
            const requirementsList = document.getElementById('modal-requirements');
            requirementsList.innerHTML = '';
            
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                requirementsList.appendChild(li);
            });
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>