<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
                    <h1 class="text-2xl font-bold text-gray-800">My Clubs</h1>
                    <button class="btn-primary px-4 py-2 rounded-lg flex items-center gap-2"
                        onclick="showCreateClubModal()">
                        <i class="fas fa-plus"></i>
                        <span>Create Club</span>
                    </button>
                </div>

                <div class="grid gap-4">
                    <!-- Club Card 1 -->
                    <div class="club-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 cursor-pointer"
                        onclick="showClubDetail('1')">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="font-semibold text-lg">Photography Club</h2>
                                <p class="text-gray-500 text-sm mt-1">45 members • 3 pending requests</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-gray-500 hover:text-gray-700" onclick="editClub(event, '1')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:text-red-700" onclick="deleteClub(event, '1')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-200 flex items-center justify-center text-xs">JC
                            </div>
                            <div class="w-6 h-6 rounded-full bg-purple-200 flex items-center justify-center text-xs">AM
                            </div>
                            <div class="w-6 h-6 rounded-full bg-green-200 flex items-center justify-center text-xs">TP
                            </div>
                            <div class="text-gray-400 text-sm">+42 more</div>
                        </div>
                    </div>

                    <!-- Club Card 2 -->
                    <div class="club-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 cursor-pointer"
                        onclick="showClubDetail('2')">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="font-semibold text-lg">Chess Enthusiasts</h2>
                                <p class="text-gray-500 text-sm mt-1">28 members • 1 pending request</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-gray-500 hover:text-gray-700" onclick="editClub(event, '2')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:text-red-700" onclick="deleteClub(event, '2')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-200 flex items-center justify-center text-xs">RK
                            </div>
                            <div class="w-6 h-6 rounded-full bg-purple-200 flex items-center justify-center text-xs">SM
                            </div>
                            <div class="w-6 h-6 rounded-full bg-green-200 flex items-center justify-center text-xs">DL
                            </div>
                            <div class="text-gray-400 text-sm">+25 more</div>
                        </div>
                    </div>

                    <!-- Club Card 3 -->
                    <div class="club-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 cursor-pointer"
                        onclick="showClubDetail('3')">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="font-semibold text-lg">Book Lovers Society</h2>
                                <p class="text-gray-500 text-sm mt-1">63 members • 5 pending requests</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-gray-500 hover:text-gray-700" onclick="editClub(event, '3')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:text-red-700" onclick="deleteClub(event, '3')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-200 flex items-center justify-center text-xs">JM
                            </div>
                            <div class="w-6 h-6 rounded-full bg-purple-200 flex items-center justify-center text-xs">AS
                            </div>
                            <div class="w-6 h-6 rounded-full bg-green-200 flex items-center justify-center text-xs">KW
                            </div>
                            <div class="text-gray-400 text-sm">+60 more</div>
                        </div>
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
                                <h2 class="font-semibold text-lg" id="clubName">Photography Club</h2>
                                <p class="text-gray-500 text-sm mt-1" id="clubStats">45 members • 3 pending requests</p>
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
                            <p class="text-gray-700" id="clubDescription">A community for photography enthusiasts to
                                share their work, learn new techniques, and organize photo walks.</p>
                        </div>
                    </div>

                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="font-semibold text-lg">Members & Requests</h2>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700">All</button>
                            <button class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700">Members</button>
                            <button class="px-3 py-1 text-sm rounded-lg bg-blue-100 text-blue-700">Pending</button>
                        </div>
                    </div>

                    <div class="grid gap-3" id="membersList">
                        <!-- Member Card 1 (Pending) -->
                        <div
                            class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">JC</span>
                                </div>
                                <div>
                                    <h3 class="font-medium">John Carter</h3>
                                    <span class="status-pending text-xs px-2 py-1 rounded-full">Pending</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="btn-accept px-3 py-1 text-sm rounded-lg flex items-center gap-1"
                                    onclick="acceptMember('1')">
                                    <i class="fas fa-check text-xs"></i>
                                    <span>Accept</span>
                                </button>
                                <button class="btn-reject px-3 py-1 text-sm rounded-lg flex items-center gap-1"
                                    onclick="rejectMember('1')">
                                    <i class="fas fa-times text-xs"></i>
                                    <span>Reject</span>
                                </button>
                            </div>
                        </div>

                        <!-- Member Card 2 (Pending) -->
                        <div
                            class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-purple-600 font-medium">AM</span>
                                </div>
                                <div>
                                    <h3 class="font-medium">Anna Miller</h3>
                                    <span class="status-pending text-xs px-2 py-1 rounded-full">Pending</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="btn-accept px-3 py-1 text-sm rounded-lg flex items-center gap-1"
                                    onclick="acceptMember('2')">
                                    <i class="fas fa-check text-xs"></i>
                                    <span>Accept</span>
                                </button>
                                <button class="btn-reject px-3 py-1 text-sm rounded-lg flex items-center gap-1"
                                    onclick="rejectMember('2')">
                                    <i class="fas fa-times text-xs"></i>
                                    <span>Reject</span>
                                </button>
                            </div>
                        </div>

                        <!-- Member Card 3 (Member) -->
                        <div
                            class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-medium">TP</span>
                                </div>
                                <div>
                                    <h3 class="font-medium">Tom Parker</h3>
                                    <span class="status-member text-xs px-2 py-1 rounded-full">Member</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700 flex items-center gap-1"
                                    onclick="messageMember('3')">
                                    <i class="fas fa-envelope text-xs"></i>
                                    <span>Message</span>
                                </button>
                                <button
                                    class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700 flex items-center gap-1"
                                    onclick="removeMember('3')">
                                    <i class="fas fa-user-minus text-xs"></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>

                        <!-- Member Card 4 (Admin) -->
                        <div
                            class="member-card bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <span class="text-yellow-600 font-medium">SD</span>
                                </div>
                                <div>
                                    <h3 class="font-medium">Sarah Davis</h3>
                                    <span class="status-admin text-xs px-2 py-1 rounded-full">Admin</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700 flex items-center gap-1"
                                    onclick="messageMember('4')">
                                    <i class="fas fa-envelope text-xs"></i>
                                    <span>Message</span>
                                </button>
                            </div>
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
                        <form id="createClubForm">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-1" for="clubNameInput">Club
                                    Name</label>
                                <input type="text" id="clubNameInput"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-1"
                                    for="clubDescriptionInput">Description</label>
                                <textarea id="clubDescriptionInput" rows="3"
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
                        <form id="editClubForm">
                            <input type="hidden" id="editClubId">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-1"
                                    for="editClubNameInput">Club Name</label>
                                <input type="text" id="editClubNameInput"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-1"
                                    for="editClubDescriptionInput">Description</label>
                                <textarea id="editClubDescriptionInput" rows="3"
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
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Delete Club</h2>
                            <button class="text-gray-500 hover:text-gray-700" onclick="hideDeleteClubModal()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="mb-6">
                            <p class="text-gray-700">Are you sure you want to delete <span id="deleteClubName"
                                    class="font-semibold">Photography Club</span>? This action cannot be undone.</p>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50"
                                onclick="hideDeleteClubModal()">
                                Cancel
                            </button>
                            <button type="button" class="btn-reject px-4 py-2 rounded-lg"
                                onclick="confirmDeleteClub()">
                                Delete Club
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Club Detail View Functions
        function showClubDetail(clubId) {
            // In a real app, you would fetch the club data based on the ID
            const clubsView = document.getElementById('clubsView');
            const clubDetailView = document.getElementById('clubDetailView');

            // Set club details based on ID (simulated)
            if (clubId === '1') {
                document.getElementById('clubDetailTitle').textContent = 'Photography Club';
                document.getElementById('clubName').textContent = 'Photography Club';
                document.getElementById('clubStats').textContent = '45 members • 3 pending requests';
                document.getElementById('clubDescription').textContent =
                    'A community for photography enthusiasts to share their work, learn new techniques, and organize photo walks.';
            } else if (clubId === '2') {
                document.getElementById('clubDetailTitle').textContent = 'Chess Enthusiasts';
                document.getElementById('clubName').textContent = 'Chess Enthusiasts';
                document.getElementById('clubStats').textContent = '28 members • 1 pending request';
                document.getElementById('clubDescription').textContent =
                    'A group for chess players of all levels to meet, play, and improve their game.';
            } else if (clubId === '3') {
                document.getElementById('clubDetailTitle').textContent = 'Book Lovers Society';
                document.getElementById('clubName').textContent = 'Book Lovers Society';
                document.getElementById('clubStats').textContent = '63 members • 5 pending requests';
                document.getElementById('clubDescription').textContent =
                    'A book club where members read and discuss a new book each month.';
            }

            clubsView.classList.add('hidden');
            clubDetailView.classList.remove('hidden');
        }

        function hideClubDetail() {
            const clubsView = document.getElementById('clubsView');
            const clubDetailView = document.getElementById('clubDetailView');

            clubsView.classList.remove('hidden');
            clubDetailView.classList.add('hidden');
        }

        function editCurrentClub() {
            // Get current club details and populate edit form
            const clubName = document.getElementById('clubName').textContent;
            const clubDescription = document.getElementById('clubDescription').textContent;

            document.getElementById('editClubNameInput').value = clubName;
            document.getElementById('editClubDescriptionInput').value = clubDescription;

            showEditClubModal();
        }

        function deleteCurrentClub() {
            const clubName = document.getElementById('clubName').textContent;
            document.getElementById('deleteClubName').textContent = clubName;
            showDeleteClubModal();
        }

        // Create Club Modal Functions
        function showCreateClubModal() {
            document.getElementById('createClubModal').classList.remove('hidden');
        }

        function hideCreateClubModal() {
            document.getElementById('createClubModal').classList.add('hidden');
        }

        // Edit Club Modal Functions
        function editClub(event, clubId) {
            event.stopPropagation();

            // In a real app, you would fetch the club data based on the ID
            if (clubId === '1') {
                document.getElementById('editClubNameInput').value = 'Photography Club';
                document.getElementById('editClubDescriptionInput').value =
                    'A community for photography enthusiasts to share their work, learn new techniques, and organize photo walks.';
            } else if (clubId === '2') {
                document.getElementById('editClubNameInput').value = 'Chess Enthusiasts';
                document.getElementById('editClubDescriptionInput').value =
                    'A group for chess players of all levels to meet, play, and improve their game.';
            } else if (clubId === '3') {
                document.getElementById('editClubNameInput').value = 'Book Lovers Society';
                document.getElementById('editClubDescriptionInput').value =
                    'A book club where members read and discuss a new book each month.';
            }

            document.getElementById('editClubId').value = clubId;
            showEditClubModal();
        }

        function showEditClubModal() {
            document.getElementById('editClubModal').classList.remove('hidden');
        }

        function hideEditClubModal() {
            document.getElementById('editClubModal').classList.add('hidden');
        }

        // Delete Club Modal Functions
        function deleteClub(event, clubId) {
            event.stopPropagation();

            // In a real app, you would fetch the club name based on the ID
            if (clubId === '1') {
                document.getElementById('deleteClubName').textContent = 'Photography Club';
            } else if (clubId === '2') {
                document.getElementById('deleteClubName').textContent = 'Chess Enthusiasts';
            } else if (clubId === '3') {
                document.getElementById('deleteClubName').textContent = 'Book Lovers Society';
            }

            document.getElementById('deleteClubId').value = clubId;
            showDeleteClubModal();
        }

        function showDeleteClubModal() {
            document.getElementById('deleteClubModal').classList.remove('hidden');
        }

        function hideDeleteClubModal() {
            document.getElementById('deleteClubModal').classList.add('hidden');
        }

        function confirmDeleteClub() {
            // In a real app, you would send a request to delete the club
            alert('Club deleted successfully!');
            hideDeleteClubModal();
        }

        // Member Management Functions
        function acceptMember(memberId) {
            // In a real app, you would send a request to accept the member
            alert('Member request accepted!');
        }

        function rejectMember(memberId) {
            // In a real app, you would send a request to reject the member
            alert('Member request rejected!');
        }

        function messageMember(memberId) {
            // In a real app, you would open a chat with the member
            alert('Opening chat with member...');
        }

        function removeMember(memberId) {
            // In a real app, you would send a request to remove the member
            alert('Member removed from club!');
        }

        // Form Submissions
        document.getElementById('createClubForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const clubName = document.getElementById('clubNameInput').value;
            const clubDescription = document.getElementById('clubDescriptionInput').value;

            // In a real app, you would send this data to your backend
            alert(`Club "${clubName}" created successfully!`);
            hideCreateClubModal();

            // Reset form
            this.reset();
        });

        document.getElementById('editClubForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const clubName = document.getElementById('editClubNameInput').value;
            const clubDescription = document.getElementById('editClubDescriptionInput').value;

            // In a real app, you would send this data to your backend
            alert(`Club "${clubName}" updated successfully!`);
            hideEditClubModal();

            // Update the UI (in a real app, you would refresh the data)
            if (document.getElementById('clubDetailView').classList.contains('hidden')) {
                // Update the club card in the list view
            } else {
                // Update the club detail view
                document.getElementById('clubName').textContent = clubName;
                document.getElementById('clubDescription').textContent = clubDescription;
            }
        });
    </script>
</body>

</html>
