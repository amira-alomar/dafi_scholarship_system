<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
=======
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Course Enrollment - DAFI Scholarship</title>
   <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
      <link rel="stylesheet" href="{{ asset('css/studentCourses.css') }}">
    
       <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<body class="page-courses">
 
>>>>>>> 69f923898ffe61c0f84fac63ccaa26dc47e7b3f5

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Enrollment - DAFI Scholarship</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebarstudent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/studentCourses.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="page-courses">


    <!-- Sidebar goes here -->
    <div class="flex">
        <div class="hidden md:block  bg-gray-100 min-h-screen">
            <!-- Sidebar Navigation -->
            <div class="sidebar hidden md:flex md:flex-col">
                <div class="sidebar-header items-center space-x-2">
                    <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
                    <h1 class="sidebar-title text-xl font-bold">ScholarPath</h1>
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


        <!-- Main Content -->
        <div style="flex: 1; padding-left: 15px;">
            <div class="main-content p-4 md:p-8 md:ml-[250px] w-full md:w-[calc(100%-250px)]">
                <!-- Form for adding/editing a course -->
                <div class="form-card">
                    <h2>
                        @if (isset($editingCourse))
                            <i class="fas fa-edit"></i> Edit Course
                        @else
                            <i class="fas fa-plus-circle"></i> Add a Course
                        @endif
                    </h2>
                    <form id="courseForm"
                        action="{{ isset($editingCourse) ? route('courses.update', $editingCourse->courseID) : route('courses.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($editingCourse))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <input type="text" id="semester" name="semester"
                                value="{{ old('semester', $editingCourse->semester ?? '') }}"
                                placeholder="Enter semester " required>
                        </div>

                        <div class="form-group">
                            <label for="courseCode">Course Code</label>
                            <input type="text" id="code" name="code"
                                value="{{ old('code', $editingCourse->code ?? '') }}" placeholder="Enter course code "
                                required>
                        </div>
                        <div class="form-group">
                            <label for="courseName">Course Name</label>
                            <input type="text" id="courseName" name="course_name"
                                value="{{ old('course_name', $editingCourse->course_name ?? '') }}"
                                placeholder="Enter course_name " required>
                        </div>
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="text" id="grade" name="grade"
                                value="{{ old('grade', $editingCourse->grade ?? '') }}" placeholder="Enter grade ">
                        </div>
                        <div class="form-group">
                            <label for="grade">Credit</label>
                            <input type="text" id="credit" name="credit"
                                value="{{ old('credit', $editingCourse->credit ?? '') }}"
                                placeholder="Enter credit ">
                        </div>
                        <div class="form-group">
                            <label for="registrationImage">Upload Registration Image</label>
                            <input type="file" id="registrationImage" name="registration_image"
                                placeholder="Enter registration_image " accept="image/*">
                        </div>
                        @if (isset($editingCourse) && $editingCourse->image)
                            <div class="form-group">
                                <label>Current Registration Image:</label><br>
                                <img src="{{ asset('course_images/' . $editingCourse->image) }}" alt="Current image"
                                    style="max-height: 150px;">
                            </div>
                        @endif
                        @if (isset($editingCourse))
                            <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        @endif
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i>
                            {{ isset($editingCourse) ? 'Update Course' : 'Save Course' }}
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
                                    <th>Course Code</th>
                                    <th>Grade</th>
                                    <th>Credit</th>
                                    <th>Registration Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="coursesTableBody">
                                <!-- Example row -->
                                @forelse($courses as $course)
                                    <tr>
                                        <td>{{ $course->semester }}</td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->grade }}</td>
                                        <td>{{ $course->credit }}</td>
                                        <td>
                                            @if ($course->image)
                                                <a href="{{ asset('course_images/' . $course->image) }}"
                                                    target="_blank">View Image</a>
                                            @else
                                                —
                                            @endif
                                        </td>


                                        <!-- @method('edit') مثلاً -->
                                        <td>
                                            <a href="{{ route('courses.edit', $course->courseID) }}"
                                                class="action-btn edit-btn">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No courses registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div id="success-toast" class="toast toast-success">
                {{ session('success') }}
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const toast = document.getElementById('success-toast');
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 4000);
                });
            </script>
        @endif
</body>

</html>
