<head>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"/>
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.opp') }}">Manage Opportunity</a>
            <a href="{{ route('admin.user') }}">Manage Users</a>
            <a href="scholarship.html">Manage Scholarships</a>
            <a href="{{ route('admin.uni') }}">Manage Universities</a>
            <a href="job.html">Manage Job Opp</a>
        </div>
    </div>
</body>
