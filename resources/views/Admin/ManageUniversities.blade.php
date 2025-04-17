<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Universities - Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/uni.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminSideBar.css') }}">
</head>
<body>
  <div class="layout">
    @include('include.adminSideBar')
    <div class="container">
      <header>
        <h1>Manage Universities</h1>
      </header>
      <button class="add-btn" onclick="openModal()">Add University</button>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Phone</th>
            <th>Website</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($universities as $university)
          <tr>
            <td>{{ $university->name }}</td>
            <td>{{ $university->location }}</td>
            <td>{{ $university->phone_number }}</td>
            <td><a href="{{ $university->website }}" target="_blank">Visit</a></td>
            <td>{{ $university->contact_email }}</td>
            <td class="actions">
              <button 
                class="edit" 
                onclick="openEditModal(this)"
                data-id="{{ $university->universityID }}"
                data-name="{{ $university->name }}"
                data-location="{{ $university->location }}"
                data-phone="{{ $university->phone_number }}"
                data-website="{{ $university->website }}"
                data-email="{{ $university->contact_email }}">
                Edit
              </button>

              <form method="POST" action="{{ route('universities.destroy', $university->universityID) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="delete" onclick="return confirm('Delete this university?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="modal" id="modal">
      <div class="modal-content">
        <h2 id="modal-title">Add University</h2>
        <form id="university-form" method="POST">
          @csrf
          <input type="hidden" id="method" name="_method" value="POST">
          <input type="text" name="name" id="uni-name" placeholder="University Name" required>
          <input type="text" name="location" id="uni-location" placeholder="Location" required>
          <input type="text" name="phone_number" id="uni-phone" placeholder="Phone" required>
          <input type="url" name="website" id="uni-website" placeholder="Website">
          <input type="email" name="contact_email" id="uni-email" placeholder="Email" required>
          <button type="submit" class="save-btn">Save</button>
          <button type="button" class="close-btn" onclick="closeModal()">Cancel</button>
        </form>
      </div>
    </div>

    <script>
      function closeModal() {
        document.getElementById("modal").style.display = "none";
      }

      function openEditModal(button) {
        const modal = document.getElementById("modal");
        const form = document.getElementById("university-form");
        const title = document.getElementById("modal-title");

        modal.style.display = "flex";
        title.innerText = "Edit University";
        form.action = `/admin/universities/${button.dataset.id}`;
        document.getElementById("method").value = "PUT";

        form.reset();
        document.getElementById("uni-name").value = button.dataset.name;
        document.getElementById("uni-location").value = button.dataset.location;
        document.getElementById("uni-phone").value = button.dataset.phone;
        document.getElementById("uni-website").value = button.dataset.website;
        document.getElementById("uni-email").value = button.dataset.email;
      }

      function openModal() {
        const modal = document.getElementById("modal");
        const form = document.getElementById("university-form");
        const title = document.getElementById("modal-title");

        modal.style.display = "flex";
        title.innerText = "Add University";
        form.action = `/admin/universities`;
        document.getElementById("method").value = "POST";

        form.reset();
      }
    </script>
  </div>
</body>
</html>
