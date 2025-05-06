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
        
        <form id="opportunityForm" method="POST" action="{{ route('opportunities.store') }}">
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
                <input type="text" name="description" required></input>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" required>
            </div>
            <button type="submit" class="btn">Add Opportunity</button>
        </form>
        <!-- Overlay -->
<div id="overlay" style="display: none;"></div>

<!-- Edit Form -->
<div id="editFormContainer" style="display: none;">
    <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editId">

        <label for="editTitle">Title</label>
        <input type="text" name="title" id="editTitle" required>

        <label for="editType">Type</label>
        <select name="type" id="editType">
            <option value="Event">Event</option>
            <option value="Volunteer">Volunteer</option>
            <option value="Training">Training</option>
        </select>

        <label for="editStatus">Status</label>
        <select name="status" id="editStatus">
            <option value="Open">Open</option>
            <option value="Closed">Closed</option>
        </select>
        {{-- <div class="form-group">
            <label for="scholarships">Scholarships</label>
            <select name="scholarships[]" id="scholarships" multiple required>
                @foreach ($scholarships as $scholarship)
                    <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                @endforeach
            </select>
        </div> --}}
        
        <label for="editDate">Date</label>
        <input type="date" name="date" id="editDate" required>

        <label for="editLocation">Location</label>
        <input type="text" name="location" id="editLocation" required>

        <label for="editDescription">Description</label>
        <input type="text" name="description" id="editDescription"></input>

        <button type="submit" class="btn">Update Opportunity</button>
        <button type="button" class="btn" onclick="closeEditForm()">Cancel</button>
    </form>
</div>

        
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Location</th>
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
    {{-- <td>
        @foreach ($opp->scholarships as $sch)
            <span>{{ $sch->name }}</span>@if(!$loop->last), @endif
        @endforeach
    </td> --}}
    <td>
        <button type="button" class="btn"
            onclick="openEditForm(
                '{{ $opp->opportunityID }}',
                '{{ addslashes($opp->title) }}',
                '{{ $opp->type }}',
                '{{ $opp->status }}',
                '{{ $opp->date }}',
                '{{ addslashes($opp->location) }}',
                '{{ addslashes($opp->description) }}'
            )">Edit</button>

        <form method="POST" action="{{ route('opportunities.destroy', $opp->opportunityID) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this opportunity?')">Delete</button>

        </form>
    </td>
</tr>
@endforeach

            </tbody>
        </table>
    </div>
</div>
<script>
    function openEditForm(id, title, type, status, date, location, description) {
        const form = document.getElementById('editForm');
        form.action = '/opportunities/' + id;

        document.getElementById('editTitle').value = title;
        document.getElementById('editType').value = type;
        document.getElementById('editStatus').value = status;
        document.getElementById('editDate').value = date;
        document.getElementById('editLocation').value = location;
        document.getElementById('editDescription').value = description;

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
