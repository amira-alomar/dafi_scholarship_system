<head>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
{{-- <body> --}}
<!-- Sidebar -->
<div class="sidebar flex flex-col w-64 bg-white border-r border-color">
    <!-- Logo -->
    <div class="flex items-center justify-between p-4 border-b border-color">
        <div class="flex items-center space-x-2">
            <i class="fas fa-graduation-cap text-2xl" style="color: var(--primary);"></i>
            <span class="text-xl font-bold">ScholarshipHub</span>
        </div>
        <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- User Profile -->
    <div class="p-4 border-b border-color flex items-center space-x-3">
        <div>
            <div class="font-medium">Admin User</div>
            <div class="text-sm text-muted">Super Admin</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto">
        <div class="p-2">
            <div class="mb-2 px-2 text-xs font-semibold text-muted uppercase tracking-wider">Main</div>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item flex items-center p-2 rounded-lg active-nav-item">
                <i class="sidebar-item-icon fas fa-tachometer-alt mr-3"></i>
                <span class="sidebar-item-text">Dashboard</span>
            </a>
            <div class="mb-2 px-2 text-xs font-semibold text-muted uppercase tracking-wider mt-4">Management</div>
            <a href="{{ route('admin.opp') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-bullseye mr-3"></i>
                <span class="sidebar-item-text">Opportunities</span>
            </a>
            <a href="{{ route('applications.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-file-alt mr-3"></i>
                <span class="sidebar-item-text">Applications Opportunities</span>
            </a>
            <a href="{{ route('admin.user') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-users mr-3"></i>
                <span class="sidebar-item-text">Users</span>
            </a>
            <a href="{{ route('scholarships.index') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-award mr-3"></i>
                <span class="sidebar-item-text">Scholarships</span>
            </a>
            <a href="{{ route('admin.uni') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-university mr-3"></i>
                <span class="sidebar-item-text">Universities</span>
            </a>
            <a href="{{ route('admin.jobOpp') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-briefcase mr-3"></i>
                <span class="sidebar-item-text">Job Opportunities</span>
            </a>
            <a href="{{ route('admin.partners') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-handshake mr-3"></i>
                <span class="sidebar-item-text">Partners</span>
            </a>

            <a href="{{ route('admin.clubs.list') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-users mr-3"></i>
                <span class="sidebar-item-text">Clubs</span>
            </a>

            <a href="{{ route('faqs.create') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-question-circle mr-3"></i>
                <span class="sidebar-item-text">FAQs</span>
            </a>

            <div class="mb-2 px-2 text-xs font-semibold text-muted uppercase tracking-wider mt-4">System</div>
            <a href="{{ route('admins.manage') }}" class="sidebar-item flex items-center p-2 rounded-lg">
                <i class="sidebar-item-icon fas fa-user-shield mr-3"></i>
                <span class="sidebar-item-text">Admins & Supervisors</span>
            </a>
        </div>
    </nav>

    <!-- Collapse Button -->
    <div class="p-4 border-t border-color">
        <a href="{{ route('logout') }}"
            class="w-full btn-secondary py-2 px-4 rounded-lg flex items-center justify-center">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span class="sidebar-item-text">Logout</span>
        </a>
    </div>
</div>
