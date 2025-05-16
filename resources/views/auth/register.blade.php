<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DAFI Scholarship - Register</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="container register-container">
    <div class="card">
      <div class="card-header">
        <h2>Registration</h2>
      </div>
      <div class="card-body">
        @if(session('success'))
  <div class="alert success">
    {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div class="alert error">
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

        <form action="{{ route('register') }}" method="POST">
          @csrf
          <input type="text" name="fname" placeholder="First Name" required>
          <input type="text" name="lname" placeholder="Last Name" required>
          <input type="text" name="address" placeholder="Adress" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <input type="date" name="birthdate" placeholder="Birthdate" required>
          <input type="text" name="phone_number" placeholder="Phone Number" required>
          <button type="submit" class="btn">Register</button>
        </form>
        <div class="switch-link">
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
