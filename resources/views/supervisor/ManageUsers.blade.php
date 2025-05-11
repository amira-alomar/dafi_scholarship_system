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
                <h1>Users for Scholarship: {{ $scholarship->name }}</h1>
            </header>
            @if($applications->isEmpty())
                <p>No applications yet for this scholarship.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Email</th>
                            <th>Phone</th><th>Address</th>
                            <th>Birthdate</th><th>Role</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $app)
                        <tr>
                            <td>{{ $app->user->id }}</td>
                            <td>{{ $app->user->fname }} {{ $app->user->lname }}</td>
                            <td>{{ $app->user->email }}</td>
                            <td>{{ $app->user->phone_number }}</td>
                            <td>{{ $app->user->address }}</td>
                            <td>{{ $app->user->birthdate }}</td>
                            <td>{{ $app->user->role->role_name }}</td>
                            <td>
                                <form action="{{ route('updateUserStatus', $app->user->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="switch">
                                        <input type="checkbox"
                                            name="status" value="1"
                                            onchange="this.form.submit()"
                                            {{ $app->user->status === 'active' ? 'checked' : '' }}>
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
    </body>
</html>
