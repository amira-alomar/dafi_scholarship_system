<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    .main {
        display: flex;

    }
</style>

<body class="main">
    <div class="w-64 bg-gray-900 text-white p-6 hidden md:block overflow-y-auto h-full sticky top-0">
        <div class="flex items-center space-x-2 mb-10">
            <i class="fas fa-graduation-cap text-2xl text-indigo-400"></i>
            <h1 class="text-xl font-bold">DAFI Scholarship</h1>
        </div>
        <nav>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg bg-gray-800">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.manageUsers', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-user-cog"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.acceptedStudents', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-user-check"></i>
                        <span>Accepted Students</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.course', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-book-reader"></i>
                        <span>Courses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.application', ['scholarshipId' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-file-signature"></i>
                        <span>Forms Application</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.questions', ['scholarshipId' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-question-circle"></i>
                        <span>Questions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.exam', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-pencil-alt"></i>
                        <span>Exams</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.interview', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-comments"></i>
                        <span>Interviews</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('examResult.create', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-poll"></i>
                        <span>Exam Result</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('interviewResult.create', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-user-tag"></i>
                        <span>Interview Result</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supervisor.finalApplication', ['scholarshipID' => $scholarshipID]) }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-800 transition">
                        <i class="fas fa-check-double"></i>
                        <span>Application Result</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition font-semibold shadow-md">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</body>
