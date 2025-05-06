<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
 <!-- Header -->
 <header>
    <div class="logo"><span>DAFI</span> Scholarship</div>
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
