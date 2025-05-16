<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins & Supervisors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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

        .layout {
            display: flex;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
        }

        .tab-content {
            transition: all 0.3s ease;
        }

        .tab-pane {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-input {
            transition: all 0.2s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(22, 163, 184, 0.2);
        }

        .table-row:hover {
            background-color: var(--muted);
        }

        .alert-success {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="layout">
        @include('include.adminSideBar')
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Management</h1>
                    <p class="text-gray-600 mt-2">Manage administrators and supervisors for the system</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-[var(--primary)] flex items-center justify-center text-white">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="font-medium">Admin Panel</p>
                        <p class="text-xs text-gray-500">Super Admin</p>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div id="successAlert"
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button onclick="hideAlert()" class="text-green-700 hover:text-green-900">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs">
                    <li class="mr-2">
                        <a href="#admins-list"
                            class="tab-link inline-flex items-center p-4 border-b-2 rounded-t-lg group"
                            aria-current="page">
                            <i class="fas fa-list mr-2"></i>
                            Admin List
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#add-admin"
                            class="tab-link inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-user-plus mr-2"></i>
                            Add Admin
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#assign-supervisor"
                            class="tab-link inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-link mr-2"></i>
                            Assign Supervisor
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#assigned-list"
                            class="tab-link inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-eye mr-2"></i>
                            Assigned List
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <div x-data="adminModal()" class="tab-pane" id="admins-list">
                    {{-- ===== الجدول ===== --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b flex justify-between items-center">
                            <h2 class="text-lg font-semibold">Admins & Supervisors</h2>
                            <div class="relative">
                                <input type="text" placeholder="Search..."
                                    class="pl-10 pr-4 py-2 border rounded-lg text-sm">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Name</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Role</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td class="px-6 py-4 flex items-center">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-[var(--{{ $admin->role === 'admin' ? 'primary' : 'secondary' }})] flex items-center justify-center text-white">
                                                    <i
                                                        class="fas fa-{{ $admin->role === 'admin' ? 'user' : 'user-tie' }}"></i>
                                                </div>
                                                <span class="ml-4">{{ $admin->name }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $admin->email }}</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-{{ $admin->role === 'admin' ? 'green' : 'blue' }}-100 text-{{ $admin->role === 'admin' ? 'green' : 'blue' }}-800">
                                                    {{ ucfirst($admin->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $admin->phone ?? '—' }}</td>
                                            <td class="px-6 py-4 text-sm font-medium space-x-2">
                                                {{-- Edit Button --}}
                                                <button
                                                    @click="openModal({
                    id: {{ $admin->id }},
                    name: '{{ addslashes($admin->name) }}',
                    email: '{{ addslashes($admin->email) }}',
                    phone: '{{ $admin->phone ?? '' }}',
                    address: '{{ $admin->address ?? '' }}',
                    role: '{{ $admin->role }}'
                  })"
                                                    class="text-[var(--accent)] hover:text-[var(--accent-dark)]">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                {{-- Delete Form --}}
                                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-[var(--destructive)] hover:text-red-700">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="show" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
                        style="display: none;">
                        <div class="bg-white rounded-lg w-full max-w-lg shadow-lg overflow-hidden">
                            <div class="px-6 py-4 border-b flex justify-between items-center">
                                <h3 class="text-lg font-semibold">Edit Admin</h3>
                                <button @click="closeModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                            <form :action="updateUrl()" method="POST" class="px-6 py-4 space-y-4">
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-sm">Name</label>
                                    <input type="text" x-model="form.name" name="name" required
                                        class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm">Email</label>
                                    <input type="email" x-model="form.email" name="email" required
                                        class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm">Phone</label>
                                    <input type="text" x-model="form.phone" name="phone"
                                        class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm">Address</label>
                                    <input type="text" x-model="form.address" name="address"
                                        class="w-full border rounded px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm">Role</label>
                                    <select x-model="form.role" name="role" required
                                        class="w-full border rounded px-3 py-2">
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm">Password <small>(leave empty to keep)</small></label>
                                    <input type="password" name="password" class="w-full border rounded px-3 py-2">
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="closeModal()"
                                        class="px-4 py-2 rounded border">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded bg-[var(--accent)] text-white">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function adminModal() {
                        return {
                            show: false,
                            form: {
                                id: null,
                                name: '',
                                email: '',
                                phone: '',
                                address: '',
                                role: 'admin'
                            },
                            openModal(data) {
                                this.form = {
                                    ...data
                                };
                                this.show = true;
                            },
                            closeModal() {
                                this.show = false;
                                this.form = {
                                    id: null,
                                    name: '',
                                    email: '',
                                    phone: '',
                                    address: '',
                                    role: 'admin'
                                };
                            },
                            updateUrl() {
                                return `/admins/${this.form.id}`;
                            }
                        }
                    }
                </script>

                <!-- 2. Add Admin -->
                <div id="add-admin" class="tab-pane">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Add New Admin/Supervisor</h2>
                            <p class="text-sm text-gray-600 mt-1">Fill in the details below to add a new administrator
                                or supervisor</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admins.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <div class="relative">
                                            <input type="text" id="name" name="name"
                                                class="form-input w-full pl-10" placeholder="John Doe" required>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <div class="relative">
                                            <input type="email" id="email" name="email"
                                                class="form-input w-full pl-10" placeholder="john@example.com"
                                                required>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-envelope text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                class="form-input w-full pl-10" placeholder="••••••••" required>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <div class="relative">
                                            <input type="text" id="phone" name="phone"
                                                class="form-input w-full pl-10" placeholder="(123) 456-7890">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-phone text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <div class="relative">
                                            <input type="text" id="address" name="address"
                                                class="form-input w-full pl-10" placeholder="123 Main St">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="role"
                                            class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <div class="relative">
                                            <select id="role" name="role" class="form-input w-full pl-10"
                                                required>
                                                <option value="">Select a role</option>
                                                <option value="admin">Admin</option>
                                                <option value="supervisor">Supervisor</option>
                                            </select>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user-tag text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-4">
                                    <button type="button" onclick="resetForm(this)"
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--accent)] mr-3">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary)] hover:bg-[var(--primary-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary)]">
                                        <i class="fas fa-user-plus mr-2"></i> Add Admin
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. Assign Supervisor -->
                <div id="assign-supervisor" class="tab-pane">
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Assign Supervisor to Scholarship</h2>
                            <p class="text-sm text-gray-600 mt-1">Link supervisors to specific scholarship programs</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admins.assign') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="supervisor"
                                            class="block text-sm font-medium text-gray-700 mb-1">Supervisor</label>
                                        <div class="relative">
                                            <select id="supervisor" name="supervisor_id"
                                                class="form-input w-full pl-10" required>
                                                <option value="">Select a supervisor</option>
                                                @foreach ($supervisors as $sup)
                                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-user-tie text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="scholarship"
                                            class="block text-sm font-medium text-gray-700 mb-1">Scholarship</label>
                                        <div class="relative">
                                            <select id="scholarship" name="scholarship_id"
                                                class="form-input w-full pl-10" required>
                                                <option value="">Select a scholarship</option>
                                                @foreach ($scholarships as $sch)
                                                    <option value="{{ $sch->scholarshipID }}">{{ $sch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-graduation-cap text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-4">
                                    <button type="button" onclick="resetForm(this)"
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--accent)] mr-3">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[var(--primary)] hover:bg-[var(--primary-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary)]">
                                        <i class="fas fa-link mr-2"></i> Assign Supervisor
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 4. Assigned List -->
                {{-- 4. Assigned List with Modal --}}
                <div x-data="assignmentModal()" id="assigned-list" class="tab-pane">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b flex justify-between items-center">
                            <h2 class="text-lg font-semibold">Supervisor Assignments</h2>
                            <div class="relative">
                                <input type="text" placeholder="Search assignments..."
                                    class="pl-10 pr-4 py-2 border rounded-lg text-sm">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Supervisor</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Scholarship</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Date Assigned</th>
                                        <th class="px-6 py-3 text-left text-xs uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($assignments as $as)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-[var(--secondary)] flex items-center justify-center text-white">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium">{{ $as->admin->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $as->admin->email }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium">{{ $as->scholarship->name }}</div>
                                                <div class="text-sm text-gray-500">ID:
                                                    {{ $as->scholarship->scholarshipID }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $as->created_at }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                {{-- Edit Assignment --}}
                                                <button
                                                    @click="openModal({
                  id: {{ $as->id }},
                  admin_id: {{ $as->admin_id }},
                  idScholarship: '{{ $as->idScholarship }}'
                })"
                                                    class="text-[var(--accent)] hover:text-[var(--accent-dark)]">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                {{-- Delete Assignment --}}
                                                <form action="{{ route('assignments.destroy', $as->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-[var(--destructive)] hover:text-red-700">
                                                        <i class="fas fa-unlink"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Modal for Editing Assignment --}}
                    <div x-show="show" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
                        style="display: none;">
                        <div class="bg-white rounded-lg w-full max-w-md shadow-lg overflow-hidden">
                            <div class="px-6 py-4 border-b flex justify-between items-center">
                                <h3 class="text-lg font-semibold">Edit Assignment</h3>
                                <button @click="closeModal()"
                                    class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                            <form :action="updateUrl()" method="POST" class="px-6 py-4 space-y-4">
                                @csrf @method('PUT')

                                {{-- Supervisor Select --}}
                                <div>
                                    <label class="block text-sm">Supervisor</label>
                                    <select x-model="form.admin_id" name="admin_id" required
                                        class="w-full border rounded px-3 py-2">
                                        @foreach ($supervisors as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}
                                                ({{ $sup->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Scholarship Select --}}
                                <div>
                                    <label class="block text-sm">Scholarship</label>
                                    <select x-model="form.idScholarship" name="idScholarship" required
                                        class="w-full border rounded px-3 py-2">
                                        @foreach ($scholarships as $sch)
                                            <option value="{{ $sch->scholarshipID }}">{{ $sch->name }} (ID:
                                                {{ $sch->scholarshipID }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="closeModal()"
                                        class="px-4 py-2 rounded border">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded bg-[var(--accent)] text-white">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Alpine.js Script --}}
                <script>
                    function assignmentModal() {
                        return {
                            show: false,
                            form: {
                                id: null,
                                admin_id: null,
                                idScholarship: null
                            },
                            openModal(data) {
                                this.form = {
                                    ...data
                                };
                                this.show = true;
                            },
                            closeModal() {
                                this.show = false;
                                this.form = {
                                    id: null,
                                    admin_id: null,
                                    idScholarship: null
                                };
                            },
                            updateUrl() {
                                return `/assignments/${this.form.id}`;
                            }
                        }
                    }
                </script>



            </div>
        </div>
        <script>
            // Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tabs
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // Show first tab by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs[0].classList.add('border-[var(--primary)]', 'text-[var(--primary)]');
                    tabPanes[0].style.display = 'block';

                    // Add click event to all tabs
                    tabs.forEach(tab => {
                        tab.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Remove active classes from all tabs
                            tabs.forEach(t => {
                                t.classList.remove('border-[var(--primary)]',
                                    'text-[var(--primary)]');
                                t.classList.add('border-transparent', 'text-gray-500',
                                    'hover:text-gray-600', 'hover:border-gray-300');
                            });

                            // Hide all tab panes
                            tabPanes.forEach(pane => {
                                pane.style.display = 'none';
                            });

                            // Add active class to clicked tab
                            this.classList.remove('border-transparent', 'text-gray-500',
                                'hover:text-gray-600', 'hover:border-gray-300');
                            this.classList.add('border-[var(--primary)]', 'text-[var(--primary)]');

                            // Show corresponding tab pane
                            const targetPane = document.querySelector(this.getAttribute('href'));
                            if (targetPane) {
                                targetPane.style.display = 'block';
                            }
                        });
                    });
                }
            });

            // Alert functions
            function hideAlert() {
                document.getElementById('successAlert').classList.add('hidden');
            }

            // Form reset function
            function resetForm(button) {
                const form = button.closest('form');
                if (form) {
                    form.reset();
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Remove active classes from all tabs
                        tabs.forEach(t => t.classList.remove('border-b-2', 'border-[var(--accent)]',
                            'text-[var(--accent)]'));

                        // Hide all tab panes
                        tabPanes.forEach(pane => pane.style.display = 'none');

                        // Add active class to clicked tab
                        this.classList.add('border-b-2', 'border-[var(--accent)]',
                            'text-[var(--accent)]');

                        // Show the corresponding tab pane
                        const targetId = this.getAttribute('href').replace('#', '');
                        const targetPane = document.getElementById(targetId);
                        if (targetPane) {
                            targetPane.style.display = 'block';
                        }
                    });
                });

                // Trigger click on first tab to show default
                if (tabs.length > 0) {
                    tabs[0].click();
                }
            });
        </script>

</body>

</html>
