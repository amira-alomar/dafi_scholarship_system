<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="{{ asset('css/studentProfile.css') }}">
    <script defer src="Script.js"></script>
</head>
<body>
     <!-- Sidebar Navigation -->
     <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
        <li><a href="{{ url('/student/dashboard') }}"> Home</a></li>
    <li><a href="{{ url('/acadmic') }}"> Academic Info</a></li>
    <li><a href="{{ url('/dafi_opp') }}"> DAFI Opportunity</a></li>
    <li><a href="{{ url('/jobs') }}"> Job Opportunity</a></li>
    <li><a href="{{ url('/courses') }}"> Courses</a></li>
    <li><a href="{{ url('/profile') }}"> Profile</a></li>
        </ul>
    </div>
    <div class="profile-container">
        <header>
            
        </header>
        
        <div class="profile-info">
            <img src="image/pexels-ekrulila-2292837.jpg" alt="Profile Picture" class="profile-pic">
            <input type="file" id="file-input" accept="image/*" class="hidden" onchange="updateProfilePic(event)">
                <label for="file-input">
                    <i class="fas fa-camera"></i>
            <div class="student-details">
                <h3>Student Name</h3>
                <p>Student ID: 210065</p>
                <p>Academic Year: 3rd</p>
             
            </div>
        </div>

        <div class="tabs">
            <button class="tab-button active" onclick="showTab('profile')">Profile</button>
            <button class="tab-button" onclick="showTab('courses')">Courses</button>
            <button class="tab-button" onclick="showTab('achievements')">Achievements</button>
        </div>

        <div id="profile" class="tab-content active">
           
            <div class="info-box">
                <div class="info-card blue"> Major : Economics</div>
                <div class="info-card green">CGPA : 3.1</div>
           
            </div>
            <div class="section">

            <h3>Personal Information</h3>
            <p><strong>Full Name:</strong> Austin James Carr</p>
            <p><strong>Date of Birth:</strong> March 12, 2002</p>
            <p><strong>Gender:</strong> Male</p>
            <p><strong>Nationality:</strong> American</p>
            <p><strong>Email:</strong> austin.carr@example.com</p>
            <p><strong>Phone:</strong> +1 (555) 123-4567</p>
            <p><strong>Address:</strong> 123 Maple Street, Springfield, IL, USA</p>
        </div>
        <!-- Academic Information (Only for Accepted Students) -->
    <div class="section " id="academic-info-section">
        <div class="edit-button">
             <!-- <button class="icon-button">
                <i class="bx bx-edit"></i>
              </button> -->
            <button onclick="toggleEditMode('academic-info')" id="edit-academic-btn">Edit</button>
            <button onclick="saveChanges('academic-info')" id="save-academic-btn" class="hidden">Save</button>
        </div>
        <h3>Academic Information</h3>
        <div class="info-row" id="academic-info">
            <div>
                <label>University</label>
                <p id="university">University of Leeds</p>
                <input type="text" id="university-input" class="hidden" value="University of Leeds">
            </div>
            <div>
                <label>GPA</label>
                <p id="gpa">3.8</p>
                <input type="number" step="0.1" id="gpa-input" class="hidden" value="3.8">
            </div>
            <div>
                <label>Volunteering Hours</label>
                <p id="volunteer-hours">120</p>
                <input type="number" id="volunteer-hours-input" class="hidden" value="120">
            </div>
            <div>
                <label>Training Hours</label>
                <p id="training-hours">50</p>
                <input type="number" id="training-hours-input" class="hidden" value="50">
            </div>
        </div>
    </div>
        </div>
    </div>

        <div id="courses" class="tab-content">
            <h3>Courses</h3>
            <p>Course details will be listed here.</p>
        </div>

        <div id="achievements" class="tab-content">
            <h3>Achievements</h3>
            <p>Achievements will be displayed here.</p>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function updateProfilePic(event) {
        const image = document.getElementById('profile-pic');
        image.src = URL.createObjectURL(event.target.files[0]);
    }

    function toggleEditMode(sectionId) {
        const section = document.getElementById(sectionId);
        const inputs = section.querySelectorAll('input');
        const paragraphs = section.querySelectorAll('p');

        inputs.forEach(input => input.classList.toggle('hidden'));
        paragraphs.forEach(p => p.classList.toggle('hidden'));

        // Toggle edit/save buttons
        if (sectionId === 'personal-info') {
            document.getElementById('edit-btn').classList.toggle('hidden');
            document.getElementById('save-btn').classList.toggle('hidden');
        } else if (sectionId === 'academic-info') {
            document.getElementById('edit-academic-btn').classList.toggle('hidden');
            document.getElementById('save-academic-btn').classList.toggle('hidden');
        }
    }

    function saveChanges(sectionId) {
        if (sectionId === 'personal-info') {
            document.getElementById('first-name').innerText = document.getElementById('first-name-input').value;
            document.getElementById('last-name').innerText = document.getElementById('last-name-input').value;
            document.getElementById('dob').innerText = document.getElementById('dob-input').value;
        } else if (sectionId === 'academic-info') {
            document.getElementById('university').innerText = document.getElementById('university-input').value;
            document.getElementById('gpa').innerText = document.getElementById('gpa-input').value;
            document.getElementById('volunteer-hours').innerText = document.getElementById('volunteer-hours-input').value;
            document.getElementById('training-hours').innerText = document.getElementById('training-hours-input').value;
        }

        // Exit Edit Mode
        toggleEditMode(sectionId);
    }
    </script>
</body>

</html>
