<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DAFI Scholarship - Login</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="container login-container">
    <div class="card">
      <div class="card-header">
        <h2>Login</h2>
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

        <form action="{{ route('login') }}" method="POST">
          @csrf
          <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
          <input type="password" name="password" placeholder="Password" required>
          <div class="extra-options">
            <label class="remember-me"><input type="checkbox"> Remember me</label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit" class="btn">Login</button>
        </form>
        <div class="switch-link">
          <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
