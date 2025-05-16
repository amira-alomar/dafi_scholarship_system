<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Users - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e8f0;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #16a3b8;
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
    </style>
</head>
<body class="bg-[#f5f5f5] font-sans min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <h1 class="text-lg font-semibold text-[#0f172a]">Scholarship Management</h1>
                <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarship->scholarshipID]) }}" class="px-4 py-2 bg-[#e05252] text-white rounded-md hover:bg-opacity-90 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-7-7a1 1 0 011.414-1.414L9 14.586V3a1 1 0 012 0v11.586l5.293-5.293a1 1 0 011.414 1.414l-7 7z" clip-rule="evenodd" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 py-4 border-b border-[#e2e8f0]">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-[#0f172a]">Users for Scholarship: {{ $scholarship->name }}</h2>
                    <span class="text-sm text-[#64748b]">{{ $applications->count() }} applications</span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                @if($applications->isEmpty())
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-[#64748b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-[#0f172a]">No applications yet</h3>
                        <p class="mt-1 text-[#64748b]">There are no applications for this scholarship at the moment.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#e2e8f0]">
                            <thead class="bg-[#f1f5f9]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Phone</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Address</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Birthdate</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-[#e2e8f0]">
                                @foreach($applications as $app)
                                <tr class="hover:bg-[#f1f5f9] transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">{{ $app->user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#0f172a]">{{ $app->user->fname }} {{ $app->user->lname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">{{ $app->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">{{ $app->user->phone_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">{{ $app->user->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">{{ $app->user->birthdate }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#313e53] text-white">
                                            {{ $app->user->role->role_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748b]">
                                        <form action="{{ route('updateUserStatus', $app->user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="status" value="1" onchange="this.form.submit()" {{ $app->user->status === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>