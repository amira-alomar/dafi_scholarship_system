<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Users - Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/adminSideBar.css') }}" />
  <style>
   
  </style>
</head>
<body>
  <div class="layout">
    @include('include.adminSideBar')
  <div class="container">
    <header>
      <h1>Manage Users</h1>
      <p>Admin Panel</p>
    </header>
    <div class="search-bar">
      <input type="text" placeholder="Search by name, email, or role...">
      <button>Search</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone</th>
          {{-- <th>Actions</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->fname .' '. $user->lname}}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->address }}</td>
          <td>{{ $user->phone_number }}</td>
          {{-- <td class="actions">
            <button class="edit"><a href="editUser.html">Edit</a></button>
            <button class="delete">Delete</button>
          </td> --}}
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  </div>
</body>
</html>
