<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Opportunities</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/opp.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminSideBar.css') }}">
</head>
<body>
    <div class="layout">
        @include('include.adminSideBar')
        <div class="container">
            <h2>Manage Opportunities</h2>

            <div class="card">
                <div class="card-header">
                    <span>Add New Opportunity</span>
                    <button id="toggleAddForm" class="btn">Add</button>
                </div>
                <div class="card-body">
                    <form id="opportunityForm" method="POST" action="{{ route('opportunities.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type">
                                <option value="Event">Event</option>
                                <option value="Volunteer">Volunteer</option>
                                <option value="Training">Training</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="scholarships">Scholarships</label>
                            <select name="scholarships[]" id="scholarships" multiple required>
                                @foreach ($scholarships as $sch)
                                    <option value="{{ $sch->scholarshipID }}">{{ $sch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*">
                        </div>
                        <button type="submit" class="btn">Submit</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Existing Opportunities</div>
                <div class="card-body">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Scholarships</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="opportunityList">
                            @foreach ($opps as $opp)
                                <tr>
                                    <td>{{ $opp->title }}</td>
                                    <td>{{ $opp->type }}</td>
                                    <td>{{ $opp->description }}</td>
                                    <td>{{ $opp->status }}</td>
                                    <td>{{ $opp->date }}</td>
                                    <td>{{ $opp->location }}</td>
                                    <td>
                                        @foreach ($opp->scholarships as $sch)
                                            <span>{{ $sch->name }}</span>@if (! $loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="actions">
                                        <button class="btn" onclick="openEditForm(...)">Edit</button>
                                        <form method="POST" action="{{ route('opportunities.destroy', $opp->opportunityID) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" onclick="return confirm('Delete?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('toggleAddForm').addEventListener('click', () => {
            const form = document.getElementById('opportunityForm');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        });
        function openEditForm(id, title, type, status, date, location, description, scholarshipIds) {
            const form = document.getElementById('editForm');
            form.action = '/opportunities/' + id;

            document.getElementById('editTitle').value = title;
            document.getElementById('editType').value = type;
            document.getElementById('editStatus').value = status;
            document.getElementById('editDate').value = date;
            document.getElementById('editLocation').value = location;
            document.getElementById('editDescription').value = description;

            // فك التحديد عن الكل
            const select = document.getElementById('editScholarships');
            Array.from(select.options).forEach(opt => opt.selected = false);

            // علمّ المُختار
            scholarshipIds.forEach(idSch => {
                const opt = select.querySelector(`option[value="${idSch}"]`);
                if (opt) opt.selected = true;
            });

            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editFormContainer').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'none';
        }
    </script>

</body>

</html>
