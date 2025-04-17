<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Users - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ManageUser.css') }}"/>
    </head>
    <body>
        @include('include.sidebar')
        <div class="container">
            <header>
                <h1>Manage Users</h1>
            </header>
            <div class="search-bar">
                <input type="text" placeholder="Search by name, email, or role...">
                <button>Search</button>
            </div>
    
            @foreach($scholarshipApplications as $item)
            <div class="scholarship-section">
                <header>
                    <h2>Users for Scholarship: {{ $item['scholarship']->name }}</h2>
                </header>
                
                @if($item['applications']->isEmpty())
                    <p>No applications yet for this scholarship.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Birthdate</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item['applications'] as $application)
                                <tr>
                                    <td>{{ $application->user->id }}</td>
                                    <td>{{ $application->user->fname . ' ' . $application->user->lname }}</td>
                                    <td>{{ $application->user->email }}</td>
                                    <td>{{ $application->user->phone_number }}</td>
                                    <td>{{ $application->user->address }}</td>
                                    <td>{{ $application->user->birthdate }}</td>
                                    <td>{{ $application->user->role->role_name }}</td>
                                    <td>
                                        <form action="{{ route('updateUserStatus', $application->user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <label class="switch">
                                                <input type="checkbox" onchange="this.form.submit()" name="status" value="1"
                                                    {{ $application->user->status === 'active' ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <br><br>
            <br>
            @endforeach
        </div>
    </body>
</html>
