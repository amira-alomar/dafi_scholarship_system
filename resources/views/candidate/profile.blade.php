<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
<style>
        /* CSS Variables */
        :root {
            --background: #f5f5f5;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --primary: #e05252;
            --primary-foreground: #f8fafc;
            --secondary: #313e53;
            --secondary-foreground: #f8fafc;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #16a3b8;
            --accent-foreground: #f8fafc;
            --destructive: #ef4444;
            --destructive-foreground: #f8fafc;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --radius: 0.5rem;
            --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: var(--background);
            min-height: 100vh;
            color: var(--foreground);
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background: var(--card);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav a {
            text-decoration: none;
            color: var(--muted-foreground);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            transition: left 0.3s ease;
            z-index: -1;
        }

        nav a:hover {
            color: var(--primary-foreground);
            transform: translateY(-2px);
        }

        nav a:hover::before {
            left: 0;
        }

        /* Profile Container */
        .profile-container {
            max-width: 600px;
            margin: 3rem auto;
            background: var(--card);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Profile Picture */
        .profile-picture img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--card);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Alert Styles */
        .alert-success {
            background: var(--accent);
            color: var(--accent-foreground);
            box-shadow: 0 8px 25px rgba(22, 163, 184, 0.3);
        }

        /* Form Styles */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background: var(--muted);
            border: 2px solid var(--input);
            color: var(--foreground);
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(224, 82, 82, 0.1);
        }

        button[type="submit"] {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--primary-foreground);
        }

        button[type="submit"]:hover {
            box-shadow: 0 15px 35px rgba(224, 82, 82, 0.4);
        }
    </style>
</head>
<body>
 <!-- Header -->
 <!-- Enhanced Modern Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center group">
                        <span
                            class="text-xl font-bold text-[var(--primary)] transition-all duration-300 group-hover:scale-110">DAFI</span>
                        <span
                            class="text-xl font-bold text-[var(--secondary)] ml-1 transition-all duration-300 group-hover:scale-110">Scholarship</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-2">
                    <a href="{{ route('candidate.dashboard') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Dashboard</a>
                    <a href="{{ route('track_your_application') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Track
                        Application</a>
                    <a href="{{ route('profile.show') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Profile</a>
                    <a href="{{ route('logout') }}"
                        class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-[var(--secondary)] hover:text-[var(--primary)] hover:bg-gray-50/80 transition-all duration-300">Logout</a>
                </div>
            </div>
        </div>
    </nav>

<div class="profile-container">
    <h2>Your Profile</h2>
    <div class="profile-picture">
        <img src="{{ $user->profile_picture ? route('profile.picture', basename($user->profile_picture)) : asset('images/default-profile.png') }}" alt="Profile Picture">
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Display Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" value="{{ old('lname', $user->lname) }}">
        </div>

        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" value="{{ old('fname', $user->fname) }}">
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label for="password">Password (Leave as it if you don't want to change it)</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="profile_picture">Change Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture">
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>