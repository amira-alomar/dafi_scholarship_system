<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins & Supervisors</title>
    <style>
        .tabs li { display: inline; margin-right: 10px; }
        .tabs a.active { font-weight: bold; color: darkblue; }
        .tab-pane { display: none; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; border-collapse: collapse; padding: 8px; }
        .alert { padding: 10px; background-color: #dff0d8; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Manage Admins & Supervisors</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="tabs">
        <li><a href="#admins-list">📋 List</a></li>
        <li><a href="#add-admin">➕ Add</a></li>
        <li><a href="#assign-supervisor">🔗 Assign</a></li>
        <li><a href="#assigned-list">👀 Assigned</a></li>
    </ul>

    <div class="tab-content">
        {{-- 1. List --}}
        <div id="admins-list" class="tab-pane">
            <h2>Admins & Supervisors</h2>
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Phone</th></tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ ucfirst($admin->role) }}</td>
                            <td>{{ $admin->phone ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 2. Add --}}
        <div id="add-admin" class="tab-pane">
            <h2>Add Admin / Supervisor</h2>
            <form action="{{ route('admins.store') }}" method="POST">
                @csrf
                <label>Name:</label>
                <input type="text" name="name" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <label>Phone:</label>
                <input type="text" name="phone">
                <label>Address:</label>
                <input type="text" name="address">
                <label>Role:</label>
                <select name="role" required>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                </select>
                <button type="submit">Add</button>
            </form>
        </div>

        {{-- 3. Assign --}}
        <div id="assign-supervisor" class="tab-pane">
            <h2>Assign Supervisor to Scholarship</h2>
            <form action="{{ route('admins.assign') }}" method="POST">
                @csrf
                <label>Supervisor:</label>
                <select name="supervisor_id" required>
                    @foreach ($supervisors as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                    @endforeach
                </select>

                <label>Scholarship:</label>
                <select name="scholarship_id" required>
                    @foreach ($scholarships as $sch)
                        <option value="{{ $sch->scholarshipID }}">{{ $sch->name }}</option>
                    @endforeach
                </select>

                <button type="submit">Assign</button>
            </form>
        </div>

        {{-- 4. Assigned View --}}
        <div id="assigned-list" class="tab-pane">
            <h2>Supervisors & Their Scholarships</h2>
            <table>
                <thead>
                    <tr><th>Supervisor</th><th>Scholarship</th></tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->admin->name }}</td>
                            <td>{{ $assignment->scholarship->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    document.querySelectorAll('.tabs a').forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            document.querySelectorAll('.tab-pane').forEach(p => p.style.display = 'none');
            document.querySelectorAll('.tabs a').forEach(a => a.classList.remove('active'));
            document.querySelector(tab.getAttribute('href')).style.display = 'block';
            tab.classList.add('active');
        });
    });
    document.querySelector('.tabs a').click(); // Default tab
    </script>
</body>
</html>
