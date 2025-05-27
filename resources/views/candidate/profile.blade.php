<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
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
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 50px;
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
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        nav a:hover {
            color: white;
            transform: translateY(-2px);
        }

        nav a:hover::before {
            left: 0;
        }

        /* Profile Container */
        .profile-container {
            max-width: 600px;
            margin: 3rem auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Profile Picture */
        .profile-picture {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .profile-picture img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 0 0 0 rgba(102, 126, 234, 0.4);
            }
            50% {
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 0 0 20px rgba(102, 126, 234, 0);
            }
        }

        .profile-picture:hover img {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            animation: slideDown 0.5s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: none;
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 1);
        }

        input[type="file"] {
            padding: 0.8rem;
            cursor: pointer;
            border-style: dashed;
            border-color: #cbd5e0;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        /* Button Styles */
        button[type="submit"] {
            width: 100%;
            padding: 1.2rem 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }

        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2, #667eea);
            transition: left 0.3s ease;
            z-index: -1;
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:hover::before {
            left: 0;
        }

        button[type="submit"]:active {
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            nav {
                gap: 1rem;
            }

            nav a {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .profile-container {
                margin: 2rem 1rem;
                padding: 2rem 1.5rem;
            }

            h2 {
                font-size: 2rem;
            }

            .profile-picture img {
                width: 100px;
                height: 100px;
            }
        }

        /* Loading Animation for Form */
        .form-group {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }
        .form-group:nth-child(7) { animation-delay: 0.7s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating Labels Effect */
        .form-group {
            position: relative;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            transform: translateY(-25px) scale(0.8);
            color: #667eea;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
    </style>
</head>
<body>
 <!-- Header -->
 <header>
    <div class="logo"><span>ScholarPath</span> </div>
    <nav>
        <a href="{{ route('candidate.dashboard') }}">Home</a>
        <a href="{{ route('track_your_application') }}">Track Your Application</a>
        <a href="{{ route('profile.show') }}">Profile</a>
        <a href="{{ route('logout') }}">Logout</a>
    </nav>
    </header>

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