<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Scholarships</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'bounce-gentle': 'bounce-gentle 0.3s ease-in-out',
                        'slide-down': 'slide-down 0.3s ease-out',
                        'slide-up': 'slide-up 0.3s ease-out',
                        'fade-in': 'fade-in 0.3s ease-out',
                        'toast-slide': 'toast-slide 0.5s ease-out',
                    },
                    keyframes: {
                        'bounce-gentle': {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-4px)'
                            }
                        },
                        'slide-down': {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(-10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        'slide-up': {
                            '0%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                            '100%': {
                                opacity: '0',
                                transform: 'translateY(-10px)'
                            }
                        },
                        'fade-in': {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        'toast-slide': {
                            '0%': {
                                transform: 'translateX(100%)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateX(0)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn"
        class="fixed top-4 left-4 z-50 lg:hidden bg-white rounded-lg shadow-lg p-3 hover:shadow-xl transition-all duration-300">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Close button for mobile -->
            <button id="sidebar-close" class="absolute top-4 right-4 lg:hidden text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            @include('include.adminSideBar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <div class="container mx-auto px-4 py-8 lg:px-8 max-w-7xl">
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-gray-800 mb-2">Manage Scholarships</h2>
                    <p class="text-gray-600">Create, edit, and organize scholarship opportunities</p>
                </div>

                <!-- Toast Container -->
                <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
                    @if (session('success'))
                        <div
                            class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg animate-toast-slide flex items-center space-x-3 min-w-80">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                            <button class="ml-auto text-green-500 hover:text-green-700 toast-close">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div
                            class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg animate-toast-slide flex items-center space-x-3 min-w-80">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                            <button class="ml-auto text-green-500 hover:text-green-700 toast-close">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg animate-toast-slide min-w-80">
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-red-500 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <div class="flex-1">
                                    <ul class="mb-0 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="font-medium">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button class="text-red-500 hover:text-red-700 toast-close">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Add Scholarship Button -->
                <button id="toggle-add-btn"
                    class="mb-8 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center space-x-2">
                    <span class="text-xl">➕</span>
                    <span>Add Scholarship</span>
                </button>

                <!-- Add Scholarship Form -->
                <div class="add-scholarship hidden bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100"
                    id="add-scholarship-form">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center space-x-2">
                        <span class="text-2xl">🎓</span>
                        <span>Add New Scholarship</span>
                    </h3>
                    <form method="POST" action="{{ route('scholarships.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="scholarship-name"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" id="scholarship-name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="funding-org"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Funding
                                    Organization</label>
                                <input type="text" name="funding_organization" id="funding-org"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="start-date" class="block text-sm font-semibold text-gray-700 mb-2">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start-date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
                            </div>

                            <div class="form-group">
                                <label for="end-date" class="block text-sm font-semibold text-gray-700 mb-2">End
                                    Date</label>
                                <input type="date" name="end_date" id="end-date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description"
                                class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="form-group">
                                <label for="target_group"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Target Group</label>
                                <select name="target_group" id="target_group"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Master">Master</option>
                                    <option value="PHD">PHD</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="idUni"
                                    class="block text-sm font-semibold text-gray-700 mb-2">University</label>
                                <select name="idUni" id="idUni" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">-- Select University --</option>
                                    @foreach (\App\Models\University::all() as $uni)
                                        <option value="{{ $uni->universityID }}"
                                            {{ old('idUni') == $uni->universityID ? 'selected' : '' }}>
                                            {{ $uni->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idUni')
                                    <div class="text-red-600 text-sm mt-1 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            Add Scholarship
                        </button>
                    </form>
                </div>

                <!-- Scholarships Grid -->
                <div class="space-y-6">
                    @foreach ($scholarships as $scholarship)
                        <div class="scholarship-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300 border border-gray-100 overflow-hidden"
                            id="scholarship-{{ $scholarship->scholarshipID }}">
                            <!-- Card Header -->
                            <div
                                class="scholarship-header bg-gradient-to-r from-blue-50 to-purple-50 p-6 border-b border-gray-100">
                                <div
                                    class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                                    <h3 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                                        <span class="text-2xl">🎓</span>
                                        <span>{{ $scholarship->name }}</span>
                                    </h3>
                                    <div class="button-group flex flex-wrap gap-2">
                                        <button
                                            class="edit-btn open-modal-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2"
                                            data-id="{{ $scholarship->scholarshipID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                        <form
                                            action="{{ route('scholarships.destroy', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                            method="POST" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button
                                                class="delete-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2"
                                                onclick="return confirm('Are you sure you want to delete it?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Details -->
                            <div class="scholarship-details p-6 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Funding Organization</p>
                                            <p class="font-semibold text-gray-800">
                                                {{ $scholarship->funding_organization }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Duration</p>
                                            <p class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($scholarship->start_date)->format('Y-m-d') }}
                                                -
                                                {{ \Carbon\Carbon::parse($scholarship->end_date)->format('Y-m-d') }}
                                            </p>

                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mt-1">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">Description</p>
                                        <p class="text-gray-800 leading-relaxed">{{ $scholarship->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Toggle Details Button -->
                            <div class="px-6 pb-4">
                                <button
                                    class="toggle-details-btn w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2">
                                    <span>View Details</span>
                                    <svg class="w-4 h-4 transform transition-transform duration-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Hidden Details Sections -->
                            <div class="details-sections hidden border-t border-gray-100 bg-gray-50">
                                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Criteria -->
                                    <div class="relationship-section">
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center space-x-2">
                                            <span class="text-lg">📋</span>
                                            <span>Criteria</span>
                                        </h4>
                                        <ul class="relationship-list space-y-3 mb-4">
                                            @foreach ($scholarship->criteria as $item)
                                                <li
                                                    class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 flex items-center justify-between">
                                                    <span class="text-gray-700">{{ $item->criteria_text }}</span>
                                                    <form
                                                        action="{{ route('criteria.delete', $item->criteriaID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="rel-delete-btn text-red-500 hover:text-red-700 p-1 rounded transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="add-relationship">
                                            <form
                                                action="{{ route('criteria.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" class="flex space-x-2">
                                                @csrf
                                                <input type="text" name="text" placeholder="Add new criteria"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                                                <button
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Add</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Benefits -->
                                    <div class="relationship-section">
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center space-x-2">
                                            <span class="text-lg">🎁</span>
                                            <span>Benefits</span>
                                        </h4>
                                        <ul class="relationship-list space-y-3 mb-4">
                                            @foreach ($scholarship->benefits as $benefit)
                                                <li
                                                    class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 flex items-center justify-between">
                                                    <span class="text-gray-700">{{ $benefit->Benefit_text }}</span>
                                                    <form
                                                        action="{{ route('benefit.delete', $benefit->benefitID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="rel-delete-btn text-red-500 hover:text-red-700 p-1 rounded transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="add-relationship">
                                            <form
                                                action="{{ route('benefit.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" class="flex space-x-2">
                                                @csrf
                                                <input type="text" name="text" placeholder="Add new benefit"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                                                <button
                                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Add</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Application Stages -->
                                    <div class="relationship-section lg:col-span-2">
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center space-x-2">
                                            <span class="text-lg">📊</span>
                                            <span>Application Stages</span>
                                        </h4>
                                        <ul class="relationship-list space-y-4 mb-4">
                                            @foreach ($scholarship->applicationStages as $stage)
                                                <li class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-2 mb-2">
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $stage->order }}</span>
                                                                <h5 class="font-semibold text-gray-800">
                                                                    {{ $stage->name }}</h5>
                                                            </div>
                                                            <p class="text-gray-600 mb-2">{{ $stage->description }}
                                                            </p>
                                                            <p class="text-sm text-gray-500">{{ $stage->start_date }}
                                                                - {{ $stage->end_date ?? 'No End Date' }}</p>
                                                        </div>
                                                        <form
                                                            action="{{ route('stage.delete', $stage->applicationStageID) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf @method('DELETE')
                                                            <button
                                                                class="rel-delete-btn text-red-500 hover:text-red-700 p-1 rounded transition-colors duration-200">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="add-relationship">
                                            <form action="{{ route('stage.add', $scholarship->scholarshipID) }}"
                                                method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-2">
                                                @csrf
                                                <select name="name" required
                                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                                                    <option value="" disabled selected>Choose stage…</option>
                                                    <option value="Form">Form</option>
                                                    <option value="Exam">Exam</option>
                                                    <option value="Interview">Interview</option>
                                                </select>
                                                <input type="text" name="description" placeholder="Description"
                                                    required
                                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                                                {{-- <input type="number" name="order" placeholder="Order" required class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" /> --}}
                                                <input type="date" name="start_date" required
                                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                                                <input type="date" name="end_date"
                                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                                                <button
                                                    class="md:col-span-5 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Add
                                                    Stage</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Partners -->
                                    <div class="relationship-section lg:col-span-2">
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center space-x-2">
                                            <span class="text-lg">🤝</span>
                                            <span>Partners</span>
                                        </h4>
                                        <ul class="relationship-list space-y-3 mb-4">
                                            @foreach ($scholarship->partners as $partner)
                                                <li
                                                    class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 flex items-center justify-between">
                                                    <span class="text-gray-700">{{ $partner->Partner_name }}</span>
                                                    <form
                                                        action="{{ route('partner.delete', [$scholarship->scholarshipID, $partner->partnerID]) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="rel-delete-btn text-red-500 hover:text-red-700 p-1 rounded transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="add-relationship">
                                            <form
                                                action="{{ route('partner.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" class="flex space-x-2">
                                                @csrf
                                                <select name="partner_id" required
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                    <option value="">-- Select a Partner --</option>
                                                    @foreach ($allPartners as $p)
                                                        <option value="{{ $p->partnerID }}">{{ $p->Partner_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button
                                                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4"
                                id="modal-{{ $scholarship->scholarshipID }}">
                                <div
                                    class="modal-box bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                                    <div
                                        class="sticky top-0 bg-white border-b border-gray-200 p-6 flex items-center justify-between">
                                        <h3 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                                            <span class="text-2xl">✏️</span>
                                            <span>Edit Scholarship</span>
                                        </h3>
                                        <button class="modal-close text-gray-500 hover:text-gray-700 p-2"
                                            data-id="{{ $scholarship->scholarshipID }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <form method="POST"
                                        action="{{ route('scholarships.update', $scholarship->scholarshipID) }}#modal-{{ $scholarship->scholarshipID }}"
                                        class="p-6 space-y-6">
                                        @csrf @method('PUT')

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label for="name-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                                                <input type="text" id="name-{{ $scholarship->scholarshipID }}"
                                                    name="name" value="{{ $scholarship->name }}" required
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            </div>

                                            <div class="form-group">
                                                <label for="funding-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Funding
                                                    Organization</label>
                                                <input type="text" id="funding-{{ $scholarship->scholarshipID }}"
                                                    name="funding_organization"
                                                    value="{{ $scholarship->funding_organization }}" required
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="form-group">
                                                <label for="start-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Start
                                                    Date</label>
                                                <input type="date" id="start-{{ $scholarship->scholarshipID }}"
                                                    name="start_date" value="{{ $scholarship->start_date }}" required
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            </div>

                                            <div class="form-group">
                                                <label for="end-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">End
                                                    Date</label>
                                                <input type="date" id="end-{{ $scholarship->scholarshipID }}"
                                                    name="end_date" value="{{ $scholarship->end_date }}"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="desc-{{ $scholarship->scholarshipID }}"
                                                class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                            <textarea id="desc-{{ $scholarship->scholarshipID }}" name="description" rows="3"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none">{{ $scholarship->description }}</textarea>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="form-group">
                                                <label for="status-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                                <select id="status-{{ $scholarship->scholarshipID }}" name="status"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                                    <option value="open"
                                                        {{ $scholarship->status == 'open' ? 'selected' : '' }}>Open
                                                    </option>
                                                    <option value="closed"
                                                        {{ $scholarship->status == 'closed' ? 'selected' : '' }}>Closed
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="target-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">Target
                                                    Group</label>
                                                <select id="target-{{ $scholarship->scholarshipID }}"
                                                    name="target_group" required
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                                    <option value="Bachelor"
                                                        {{ $scholarship->target_group == 'Bachelor' ? 'selected' : '' }}>
                                                        Bachelor</option>
                                                    <option value="Master"
                                                        {{ $scholarship->target_group == 'Master' ? 'selected' : '' }}>
                                                        Master</option>
                                                    <option value="PHD"
                                                        {{ $scholarship->target_group == 'PHD' ? 'selected' : '' }}>PHD
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="uni-{{ $scholarship->scholarshipID }}"
                                                    class="block text-sm font-semibold text-gray-700 mb-2">University</label>
                                                <select id="uni-{{ $scholarship->scholarshipID }}" name="idUni"
                                                    required
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                                    @foreach (\App\Models\University::all() as $uni)
                                                        <option value="{{ $uni->universityID }}"
                                                            {{ $scholarship->idUni == $uni->universityID ? 'selected' : '' }}>
                                                            {{ $uni->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex justify-end pt-4 border-t border-gray-200">
                                            <button type="submit"
                                                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const sidebarClose = document.getElementById('sidebar-close');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
        });

        function closeMobileMenu() {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        }

        sidebarClose.addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);

        // Toggle Add Scholarship Form
        document.getElementById('toggle-add-btn').addEventListener('click', function() {
            const form = document.getElementById('add-scholarship-form');
            const icon = this.querySelector('span:first-child');
            const text = this.querySelector('span:last-child');

            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.classList.add('animate-slide-down');
                icon.textContent = '❌';
                text.textContent = 'Cancel';
                this.classList.remove('from-blue-500', 'to-purple-600', 'hover:from-blue-600',
                    'hover:to-purple-700');
                this.classList.add('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
            } else {
                form.classList.add('animate-slide-up');
                setTimeout(() => {
                    form.classList.add('hidden');
                    form.classList.remove('animate-slide-down', 'animate-slide-up');
                }, 300);
                icon.textContent = '➕';
                text.textContent = 'Add Scholarship';
                this.classList.remove('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
                this.classList.add('from-blue-500', 'to-purple-600', 'hover:from-blue-600', 'hover:to-purple-700');
            }
        });

        // Toggle each card's details
        document.querySelectorAll('.scholarship-card').forEach(card => {
            const btn = card.querySelector('.toggle-details-btn');
            const sections = card.querySelector('.details-sections');
            const arrow = btn.querySelector('svg');

            btn.addEventListener('click', () => {
                if (sections.classList.contains('hidden')) {
                    sections.classList.remove('hidden');
                    sections.classList.add('animate-slide-down');
                    btn.querySelector('span').textContent = 'Hide Details';
                    arrow.classList.add('rotate-180');
                } else {
                    sections.classList.add('animate-slide-up');
                    arrow.classList.remove('rotate-180');
                    setTimeout(() => {
                        sections.classList.add('hidden');
                        sections.classList.remove('animate-slide-down', 'animate-slide-up');
                    }, 300);
                    btn.querySelector('span').textContent = 'View Details';
                }
            });
        });

        // Handle URL hash for direct linking to expanded cards
        window.addEventListener('DOMContentLoaded', () => {
            const hash = location.hash; // e.g. "#scholarship-5"
            if (hash) {
                const card = document.querySelector(hash);
                if (card) {
                    const btn = card.querySelector('.toggle-details-btn');
                    const sections = card.querySelector('.details-sections');
                    const arrow = btn.querySelector('svg');

                    sections.classList.remove('hidden');
                    sections.classList.add('animate-fade-in');
                    btn.querySelector('span').textContent = 'Hide Details';
                    arrow.classList.add('rotate-180');
                }
            }
        });

        // Modal functionality
        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const modal = document.getElementById(`modal-${id}`);
                modal.classList.remove('hidden');
                modal.classList.add('flex', 'animate-fade-in');
            });
        });

        document.querySelectorAll('.modal-close').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const modal = document.getElementById(`modal-${id}`);
                modal.classList.add('animate-slide-up');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex', 'animate-fade-in', 'animate-slide-up');
                }, 300);
            });
        });

        // Close modal when clicking outside
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) {
                    const modal = backdrop;
                    modal.classList.add('animate-slide-up');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex', 'animate-fade-in', 'animate-slide-up');
                    }, 300);
                }
            });
        });

        // Toast auto-dismiss and manual close
        function setupToastDismissal() {
            const toasts = document.querySelectorAll('.alert');

            toasts.forEach(toast => {
                // Auto dismiss after 4 seconds
                setTimeout(() => {
                    dismissToast(toast);
                }, 4000);

                // Manual close button
                const closeBtn = toast.querySelector('.toast-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        dismissToast(toast);
                    });
                }
            });
        }

        function dismissToast(toast) {
            toast.style.transition = 'all 0.5s ease-out';
            toast.style.transform = 'translateX(100%)';
            toast.style.opacity = '0';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 500);
        }

        // Initialize toast functionality
        setupToastDismissal();

        // Add hover effects to buttons
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.classList.contains('animate-bounce-gentle')) {
                    this.classList.add('animate-bounce-gentle');
                    setTimeout(() => {
                        this.classList.remove('animate-bounce-gentle');
                    }, 300);
                }
            });
        });
    </script>
</body>

</html>
