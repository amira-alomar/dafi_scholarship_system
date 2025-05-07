<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Course Enrollment - DAFI Scholarship</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet"
  />
  <style>
    /* Basic Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: #F5F5F5;
      color: #212121;
      line-height: 1.6;
    }
    a {
      text-decoration: none;
      color: inherit;
    }
    /* Navbar (same as Scholarships Dashboard) */
    header {
      background: #fff;
      padding: 1rem 2rem;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header .logo {
      font-size: 1.8rem;
      font-weight: 700;
      color: #000;
    }
    header .logo span {
      color: #D32F2F;
    }
    header nav a {
      margin-left: 1rem;
      color: #333;
      transition: color 0.3s;
    }
    header nav a:hover {
      color: #D32F2F;
    }
    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 0 20px;
    }
    .form-card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .form-card h2 {
      font-size: 1.5rem;
      color: #D32F2F;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #E0E0E0;
      border-radius: 5px;
      font-size: 1rem;
    }
    .form-group input[type="file"] {
      padding: 5px;
    }
    .btn {
      display: inline-block;
      padding: 12px 20px;
      background: #D32F2F;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }
    .btn:hover {
      background: #B71C1C;
    }
    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #E0E0E0;
      text-align: center;
      font-size: 1rem;
    }
    th {
      background: #37474F;
      color: white;
      font-weight: 600;
    }
    .edit-btn {
      background: #D32F2F;
      padding: 5px 12px;
      border-radius: 5px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s;
    }
    .edit-btn:hover {
      background: #B71C1C;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header>
    <div class="logo"><span>DAFI</span> Scholarship</div>
    <nav>
      <a href="{{ url('/student/dashboard') }}">Home</a>
      <a href="{{ url('/acadmic') }}">Academic Info</a>
      <a href="{{ url('/dafi_opp') }}">DAFI Opportunity</a>
      <a href="{{ url('/jobs') }}">Job Opportunity</a>
      <a href="{{ route('student.profile') }}">Profile</a>
    </nav>
  </header>
  
  <!-- Course Enrollment Content -->
  <div class="container">
    <!-- Form for adding/editing a course -->
    <div class="form-card">
      <h2>Add  a Course</h2>
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
          <button type="submit" class="btn">Save Course</button>
        </form>
      </div>
  
      <!-- Table displaying the added courses -->
      <div class="form-card">
        <h2>Registered Courses</h2>
        <table>
          <thead>
            <tr>
              <th>Semester</th>
              <th>Course Name</th>
              <th>Grade</th>
              <th>Registration Image</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody id="coursesTableBody">
            <!-- Example row -->
            <tr>
              <td>1</td>
              <td>Mathematics</td>
              <td>95</td>
              <td><a href="#">View Image</a></td>
              <td><a href="#" class="edit-btn">Edit</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <script>
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
          <td><a href="#">View Image</a></td>
          <td><a href="#" class="edit-btn">Edit</a></td>
        `;
        tableBody.appendChild(newRow);
        e.target.reset();
      });
    </script>
  </body>
  </html>