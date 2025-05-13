<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Course Enrollment - DAFI Scholarship</title>
   <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
      <link rel="stylesheet" href="{{ asset('css/studentCourses.css') }}">
  
</head>
<body >
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


  <!-- Main Content -->
    <div class="flex-1 p-6">
  <div class="main-content">
    <!-- Form for adding/editing a course -->
    <div class="form-card">
      <h2><i class="fas fa-plus-circle"></i>Add a Course</h2>
      <form id="courseForm">
        <div class="form-group">
          <label for="semester">Semester</label>
          <input type="text" id="semester" name="semester" placeholder="Enter semester number" required>
        </div>
        <div class="form-group">
          <label for="courseName">Course Name</label>
          <input type="text" id="courseName" name="courseName" placeholder="Enter course name" required>
        </div>
        <div class="form-group">
          <label for="grade">Grade</label>
          <input type="text" id="grade" name="grade" placeholder="Enter your grade" required>
        </div>
        <div class="form-group">
          <label for="registrationImage">Upload Registration Image</label>
          <input type="file" id="registrationImage" name="registrationImage" accept="image/*">
        </div>
        <button type="submit" class="btn">
          <i class="fas fa-save"></i> Save Course
        </button>
      </form>
    </div>

    <!-- Table displaying the added courses -->
    <div class="form-card">
      <h2><i class="fas fa-list-alt"></i>Registered Courses</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Semester</th>
              <th>Course Name</th>
              <th>Grade</th>
              <th>Registration Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="coursesTableBody">
            <!-- Example row -->
            <tr>
              <td>1</td>
              <td>Mathematics</td>
              <td>95</td>
              <td><a href="#" class="view-link">View Image</a></td>
              <td><a href="#" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a></td>
            </tr>
            <!-- Additional example rows -->
            <tr>
              <td>1</td>
              <td>Physics</td>
              <td>88</td>
              <td><a href="#" class="view-link">View Image</a></td>
              <td><a href="#" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Chemistry</td>
              <td>92</td>
              <td><a href="#" class="view-link">View Image</a></td>
              <td><a href="#" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  <script>
    // Form submission handler
    document.getElementById('courseForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const semester = document.getElementById('semester').value;
      const courseName = document.getElementById('courseName').value;
      const grade = document.getElementById('grade').value;
      const tableBody = document.getElementById('coursesTableBody');
      
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>${semester}</td>
        <td>${courseName}</td>
        <td>${grade}</td>
        <td><a href="#" class="view-link">View Image</a></td>
        <td><a href="#" class="action-btn edit-btn"><i class="fas fa-edit"></i> Edit</a></td>
      `;
      tableBody.appendChild(newRow);
      e.target.reset();
      
      // Show success message
      alert('Course added successfully!');
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.querySelector('.sidebar');
    
    function checkScreenSize() {
      if (window.innerWidth <= 576) {
        mobileMenuBtn.style.display = 'flex';
      } else {
        mobileMenuBtn.style.display = 'none';
        sidebar.classList.remove('active');
      }
    }
    
    mobileMenuBtn.addEventListener('click', function() {
      sidebar.classList.toggle('active');
    });
    
    window.addEventListener('resize', checkScreenSize);
    checkScreenSize(); // Initial check
  </script>
</body>
</html>