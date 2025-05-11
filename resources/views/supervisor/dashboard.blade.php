<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Scholarships - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #D32F2F;
            --dark-bg: #222;
            --accent-bg: #333;
            --light-bg: #fff;
            --muted-bg: #f4f4f4;
            --light-gray: #f9f9f9;
            --text-color: #333;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--muted-bg);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--dark-bg);
            color: white;
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-color);
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .no-scholarships {
            text-align: center;
            padding: 2rem;
            background-color: var(--light-bg);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            color: var(--text-color);
            font-size: 1.1rem;
        }

        .scholarship-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .scholarship-card {
            background-color: var(--light-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .scholarship-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
        }

        .card-body p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .card-footer {
            padding: 0 1.5rem 1.5rem;
        }

        .manage-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            border: 2px solid var(--primary-color);
        }

        .manage-btn:hover {
            background-color: transparent;
            color: var(--primary-color);
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }

        .sidebar-menu li {
            margin-bottom: 1rem;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar-collapsed .menu-text {
            display: none;
        }

        .sidebar-collapsed .sidebar-menu a {
            justify-content: center;
        }

        .sidebar-collapsed .sidebar-menu i {
            margin-right: 0;
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 100;
                height: 100vh;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-sidebar {
                display: block;
            }
        }

        /* Animation for cards */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .scholarship-card {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .scholarship-card:nth-child(1) { animation-delay: 0.1s; }
        .scholarship-card:nth-child(2) { animation-delay: 0.2s; }
        .scholarship-card:nth-child(3) { animation-delay: 0.3s; }
        .scholarship-card:nth-child(4) { animation-delay: 0.4s; }
        .scholarship-card:nth-child(5) { animation-delay: 0.5s; }
        .scholarship-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3 class="text-xl font-semibold text-white">ScholarshipHub</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="fas fa-home"></i> <span class="menu-text">Dashboard</span></a></li>
                <li><a href="#"><i class="fas fa-graduation-cap"></i> <span class="menu-text">Scholarships</span></a></li>
                <li><a href="#"><i class="fas fa-users"></i> <span class="menu-text">Applicants</span></a></li>
                <li><a href="#"><i class="fas fa-cog"></i> <span class="menu-text">Settings</span></a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span></a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Your Scholarships - Dashboard</h1>
                <div></div> <!-- Empty div for spacing -->
            </div>
            
            <!-- Blade content starts here -->
            @if ($scholarships->isEmpty())
                <p class="no-scholarships">Currently, there are no available scholarships you are responsible for.</p>
            @else
                <div class="scholarship-grid">
                    @foreach ($scholarships as $scholarship)
                        <div class="scholarship-card">
                            <div class="card-header">
                                <h2>{{ $scholarship->name }}</h2>
                            </div>
                            <div class="card-body">
                                <p>{{ $scholarship->description }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarship->scholarshipID]) }}" class="manage-btn">
                                    Manage Scholarship <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- Blade content ends here -->
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });

        // Collapse sidebar on larger screens if needed
        function handleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleSidebar);
        handleSidebar();

        // Add ripple effect to buttons
        document.querySelectorAll('.manage-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Create ripple element
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                // Get click position
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Position the ripple
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                    window.location.href = this.href;
                }, 300);
            });
        });

        // Add hover effect to cards
        document.querySelectorAll('.scholarship-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.card-header').style.backgroundColor = 'var(--accent-bg)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('.card-header').style.backgroundColor = 'var(--primary-color)';
            });
        });
    </script>
</body>
</html>