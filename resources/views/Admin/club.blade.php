<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --background: #f5f5f5;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --primary: #e05252;
            --primary-foreground: #f8fafc;
            --secondary: #313e53;
            --secondary-foreground: #f8fafc;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #16a3b8;
            --accent-foreground: #f8fafc;
            --destructive: #ef4444;
            --destructive-foreground: #f8fafc;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --radius: 0.5rem;
            --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .main {
            min-height: 100vh;
            flex: 1;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
        }

        .club-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .club-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .member-card {
            transition: background-color 0.2s;
        }

        .member-card:hover {
            background-color: var(--muted);
        }

        .status-pending {
            color: var(--muted-foreground);
            background-color: var(--muted);
        }

        .status-member {
            color: var(--accent-foreground);
            background-color: var(--accent);
        }

        .status-admin {
            color: var(--secondary-foreground);
            background-color: var(--secondary);
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn-primary:hover {
            background-color: #d14545;
        }

        .btn-accept {
            background-color: var(--accent);
            color: var(--accent-foreground);
        }

        .btn-accept:hover {
            background-color: #1294a8;
        }

        .btn-reject {
            background-color: var(--destructive);
            color: var(--destructive-foreground);
        }

        .layout {
            display: flex;
            flex: 1;
        }

        .btn-reject:hover {
            background-color: #dc2626;
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
        }

        .btn-secondary:hover {
            background-color: #2a374d;
        }

        .backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        .slide-out {
            animation: slideOut 0.3s ease-in forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="layout">
        @include('include.adminSideBar')
        <!-- Main Clubs List View -->
        <div class="main">
            <div id="clubsView" class="p-4 max-w-3xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">My Clubs</h1>
                    <button onclick="showCreateClubModal()"
                        class="btn-primary flex items-center gap-2 px-4 py-2 rounded-lg">
                        <i class="fas fa-plus"></i> Create Club
                    </button>
                </div>

                <!-- clubs grid -->
                <div class="grid gap-4">
                    @foreach ($clubs as $club)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between cursor-pointer"
                            onclick="showClubDetail('{{ $club->id }}')">

                            <!-- Profile Image -->
                            <div class="flex items-center gap-4">
                                @if ($club->image)
                                    <img src="{{ route('partner.picture', ['filename' => $club->image]) }}"
                                        alt="Club Image"
                                        class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-20 h-20 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center text-sm italic border border-gray-200">
                                        No image
                                    </div>
                                @endif

                                <!-- Club Info -->
                                <div>
                                    <h2 class="text-lg font-semibold">{{ $club->name }}</h2>
                                    <p class="text-gray-500 text-sm">
                                        {{ $club->members_count }} members • {{ $club->pending_count }} pending
                                    </p>
                                    @if ($club->category)
                                        <p class="text-sm text-gray-600 mt-1">
                                            Category: <span
                                                class="font-medium text-gray-800">{{ $club->category }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button onclick="event.stopPropagation(); openEditClub({{ $club->id }})"
                                    class="text-gray-500 hover:text-gray-700 p-2">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button
                                    onclick="event.stopPropagation(); openDeleteClub({{ $club->id }}, '{{ $club->name }}')"
                                    class="text-red-500 hover:text-red-700 p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- Club Detail View (hidden by default) -->
        <div id="clubDetailView" class="fixed inset-0 bg-white z-50 overflow-y-auto hidden">
            <div class="p-4 max-w-3xl mx-auto">
                <div class="flex items-center gap-4 mb-6">
                    <button class="p-2 rounded-full hover:bg-gray-100" onclick="hideClubDetail()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h1 class="text-2xl font-bold" id="clubDetailTitle">Club Details</h1>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="font-semibold text-lg" id="clubName"></h2>
                            <p class="text-gray-500 text-sm" id="clubStats">
                                {{ $club->members_count }} members • {{ $club->pending_count }} pending
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button class="p-2 text-gray-500 hover:text-gray-700" onclick="editCurrentClub()">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="p-2 text-red-500 hover:text-red-700" onclick="deleteCurrentClub()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-700" id="clubDescription"></p>
                    </div>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <h2 class="font-semibold text-lg">Members & Requests</h2>
                    <div class="flex gap-2">
                        <!-- All active by default -->
                        <button class="tab-button px-3 py-1 text-sm rounded-lg bg-blue-100 text-blue-700"
                            data-filter="all">All</button>
                        <button class="tab-button px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700"
                            data-filter="accepted">Members</button>
                        <button class="tab-button px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700"
                            data-filter="pending">Pending</button>
                    </div>
                </div>


                <div class="p-4">
                    <h2 class="text-2xl font-bold mb-4">Members of {{ $club->name }}</h2>

                    <div class="grid gap-3" id="membersList">
                        <!-- Member Card 1 (Pending) -->
                        @if ($members)
                            @foreach ($members as $member)
                                <div class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between mb-3"
                                    data-status="{{ $member->status }}">

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-medium">
                                                {{ strtoupper(substr($member->user->fname, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">{{ $member->user->fname }}</h3>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full 
                                        @if ($member->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($member->status == 'accepted') bg-green-100 text-green-800 
                                        @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($member->status === 'pending')
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.clubs.members.accept', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <button
                                                    class="btn-accept px-3 py-1 text-sm rounded-lg flex items-center gap-1">
                                                    <i class="fas fa-check text-xs"></i><span>Accept</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.clubs.members.reject', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <button
                                                    class="btn-reject px-3 py-1 text-sm rounded-lg flex items-center gap-1">
                                                    <i class="fas fa-times text-xs"></i><span>Reject</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No members to show yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Club Modal (hidden by default) -->
        <div id="createClubModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
            <div class="backdrop absolute inset-0" onclick="hideCreateClubModal()"></div>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 z-10 slide-in">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Create New Club</h2>
                        <button class="text-gray-500 hover:text-gray-700" onclick="hideCreateClubModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" id="createClubForm" method="POST"
                        action="{{ route('admin.clubs.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="clubNameInput" class="block text-gray-700 text-sm font-medium mb-1">
                                Club Name
                            </label>
                            <input type="text" id="clubNameInput" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="clubCategorySelect" class="block text-gray-700 text-sm font-medium mb-1">
                                Category
                            </label>
                            <select id="clubCategorySelect" name="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="art">Art</option>
                                <option value="techno">Techno</option>
                                <option value="sports">Sports</option>
                                <option value="science">Science</option>
                                <option value="culture">Culture</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="clubImageInput" class="block text-gray-700 text-sm font-medium mb-1">
                                Club Image
                            </label>
                            <input type="file" id="clubImageInput" name="image"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="clubDescriptionInput" class="block text-gray-700 text-sm font-medium mb-1">
                                Description
                            </label>
                            <textarea id="clubDescriptionInput" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50"
                                onclick="hideCreateClubModal()">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary px-4 py-2 rounded-lg">
                                Create Club
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit Club Modal (hidden by default) -->
        <div id="editClubModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
            <div class="backdrop absolute inset-0" onclick="hideEditClubModal()"></div>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 z-10 slide-in">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Edit Club</h2>
                        <button class="text-gray-500 hover:text-gray-700" onclick="hideEditClubModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- داخل Edit Club Modal -->
                    <form id="editClubForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" id="editClubId" name="id">

                        <div class="mb-4">
                            <label for="editClubNameInput" class="block text-gray-700 text-sm font-medium mb-1">
                                Club Name
                            </label>
                            <input type="text" id="editClubNameInput" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="editClubCategorySelect" class="block text-gray-700 text-sm font-medium mb-1">
                                Category
                            </label>
                            <select id="editClubCategorySelect" name="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="art">Art</option>
                                <option value="techno">Techno</option>
                                <option value="sports">Sports</option>
                                <option value="science">Science</option>
                                <option value="culture">Culture</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="editClubDescriptionInput"
                                class="block text-gray-700 text-sm font-medium mb-1">
                                Description
                            </label>
                            <textarea id="editClubDescriptionInput" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50"
                                onclick="hideEditClubModal()">
                                Cancel
                            </button>
                            <button type="submit" class="btn-secondary px-4 py-2 rounded-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal (hidden by default) -->
        <div id="deleteClubModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
            <div class="backdrop absolute inset-0" onclick="hideDeleteClubModal()"></div>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 z-10 slide-in">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Delete Club</h2>
                        <input type="hidden" name="id" id="deleteClubId">
                        <button class="text-gray-500 hover:text-gray-700" onclick="hideDeleteClubModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-700">Are you sure you want to delete <span id="deleteClubName"
                                class="font-semibold"></span>? This action cannot be undone.</p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50"
                            onclick="hideDeleteClubModal()">
                            Cancel
                        </button>
                        <button type="button" class="btn-reject px-4 py-2 rounded-lg" onclick="confirmDeleteClub()">
                            Delete Club
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // ——— SHOW / HIDE Create Modal ———
        function showCreateClubModal() {
            document.getElementById('createClubModal').classList.remove('hidden');
        }

        function hideCreateClubModal() {
            document.getElementById('createClubModal').classList.add('hidden');
        }

        // ——— SHOW / HIDE Edit Modal ———
        function openEditClub(id) {
            fetch(`/admin/clubs/${id}/fetch`)
                .then(r => r.json())
                .then(data => {
                    document.querySelector('#editClubModal input[name="id"]').value = data.id;
                    document.querySelector('#editClubModal input[name="name"]').value = data.name;
                    document.querySelector('#editClubModal select[name="category"]').value = data.category;
                    document.querySelector('#editClubModal textarea[name="description"]').value = data.description ||
                        '';
                    document.getElementById('editClubForm').action = `/admin/clubs/${id}`;

                    document.getElementById('editClubModal').classList.remove('hidden');
                });
        }


        function hideEditClubModal() {
            document.getElementById('editClubModal').classList.add('hidden');
        }

        // ——— SHOW / HIDE Delete Modal ———
        function openDeleteClub(id, name) {
            document.querySelector('#deleteClubModal input[name="id"]').value = id;
            document.getElementById('deleteClubName').textContent = name;
            document.getElementById('deleteClubModal').classList.remove('hidden');
        }

        function hideDeleteClubModal() {
            document.getElementById('deleteClubModal').classList.add('hidden');
        }

        function showClubDetail(clubId) {
            fetch(`/admin/clubs/${clubId}/fetch`)
                .then(r => r.json())
                .then(data => {
                    const c = data.club;
                    const members = data.members;

                    // تحديث بيانات النادي
                    document.getElementById('clubDetailTitle').textContent = c.name;
                    document.getElementById('clubName').textContent = c.name;
                    document.getElementById('clubStats').textContent =
                        `${c.members_count} members • ${c.pending_count} pending`;
                    document.getElementById('clubDescription').textContent = c.description || '';

                    // نظّف القائمة قبل ما تعبيها
                    const membersList = document.getElementById('membersList');
                    membersList.innerHTML = '';

                    if (members.length === 0) {
                        membersList.innerHTML = '<p class="text-gray-500">No members to show yet.</p>';
                    } else {
                        members.forEach(member => {
                            const statusClass = member.status === 'pending' ?
                                'bg-yellow-100 text-yellow-800' :
                                member.status === 'accepted' ?
                                'bg-green-100 text-green-800' :
                                'bg-red-100 text-red-800';

                            membersList.insertAdjacentHTML('beforeend', `
<div class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between mb-3" data-status="${member.status}">
  <div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
      <span class="text-blue-600 font-medium">
        ${member.user.fname.slice(0,2).toUpperCase()}
      </span>
    </div>
    <div>
      <h3 class="font-medium">${member.user.fname}</h3>
      <span class="text-xs px-2 py-1 rounded-full ${statusClass}">
        ${member.status.charAt(0).toUpperCase() + member.status.slice(1)}
      </span>
    </div>
  </div>
  ${member.status === 'pending' ? `
      <div class="flex gap-2">
        <form action="/admin/clubs/members/accept/${member.id}" method="POST">
          <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
          <button class="btn-accept px-3 py-1 text-sm rounded-lg flex items-center gap-1">
            <i class="fas fa-check text-xs"></i><span>Accept</span>
          </button>
        </form>
        <form action="/admin/clubs/members/reject/${member.id}" method="POST">
          <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
          <button class="btn-reject px-3 py-1 text-sm rounded-lg flex items-center gap-1">
            <i class="fas fa-times text-xs"></i><span>Reject</span>
          </button>
        </form>
      </div>` : ''}
</div>
                    `);
                        });
                    }

                    // عرض المودال
                    document.getElementById('clubsView').classList.add('hidden');
                    document.getElementById('clubDetailView').classList.remove('hidden');

                    // حدّث الـ URL بدون رفريش
                    history.pushState(null, '', `/admin/clubs?club_id=${clubId}`);
                });
        }

        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const clubId = urlParams.get('club_id');
            if (clubId) {
                showClubDetail(clubId);
            }
        });

        function hideClubDetail() {
            document.getElementById('clubDetailView').classList.add('hidden');
            document.getElementById('clubsView').classList.remove('hidden');
        }

        // ——— Edit / Delete From Detail ———
        function editCurrentClub() {
            const id = document.querySelector('#clubDetailView input[name="id"]').value;
            hideClubDetail();
            openEditClub(id);
        }

        function deleteCurrentClub() {
            const id = document.querySelector('#clubDetailView input[name="id"]').value;
            const name = document.getElementById('clubName').textContent;
            hideClubDetail();
            openDeleteClub(id, name);
        }

        // ——— Close on backdrop click ———
        document.querySelectorAll('.backdrop').forEach(el =>
            el.addEventListener('click', () => {
                hideCreateClubModal();
                hideEditClubModal();
                hideDeleteClubModal();
            })
        );

        function confirmDeleteClub() {
            const id = document.querySelector('#deleteClubModal input[name="id"]').value;

            fetch(`/admin/clubs/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Optionally remove the club from the UI or reload
                        hideDeleteClubModal();
                        location.reload(); // or update DOM manually
                    } else {
                        alert("Failed to delete club.");
                    }
                })
                .catch(error => {
                    console.error("Error deleting club:", error);
                    alert("An error occurred.");
                });
        }
    </script>

    <script>
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                const cards = document.querySelectorAll('.member-card');

                // أزل اللون الأزرق من كل الأزرار
                document.querySelectorAll('.tab-button').forEach(b => {
                    b.classList.remove('bg-blue-100', 'text-blue-700');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });

                // لون الزر النشط
                this.classList.remove('bg-gray-100', 'text-gray-700');
                this.classList.add('bg-blue-100', 'text-blue-700');

                // فلترة العناصر
                cards.forEach(card => {
                    const status = card.getAttribute('data-status');

                    if (filter === 'all' || status === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>
