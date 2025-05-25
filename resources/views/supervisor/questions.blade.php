<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(17, 24, 39, 0.75); z-index: 40; backdrop-filter: blur(4px); }
        .modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 50; width: 90%; max-width: 480px; }
        .slide-in { animation: slideIn 0.3s ease-out; }
        .slide-out { animation: slideOut 0.3s ease-in; }
        .fade-in { animation: fadeIn 0.4s ease-out; }
        .fade-out { animation: fadeOut 0.3s ease-in; }
        @keyframes slideIn { from { opacity: 0; transform: translate(-50%, -60%); } to { opacity: 1; transform: translate(-50%, -50%); }}
        @keyframes slideOut { from { opacity: 1; transform: translate(-50%, -50%); } to { opacity: 0; transform: translate(-50%, -60%); }}
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); }}
        @keyframes fadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(20px); }}
        .notification { position: fixed; bottom: 24px; right: 24px; z-index: 60; min-width: 300px; max-width: 400px; }
        .notification-enter { animation: notificationEnter 0.4s ease-out; }
        .notification-exit { animation: notificationExit 0.3s ease-in; }
        @keyframes notificationEnter { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); }}
        @keyframes notificationExit { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); }}
        .card-hover { transition: all 0.2s ease-in-out; }
        .card-hover:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .input-focus { transition: all 0.2s ease-in-out; }
        .input-focus:focus { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(129, 140, 248, 0.15); }
        html, body { height: 100%; margin: 0; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-gray-50">
    @include('include.sidebar', ['scholarshipID' => $scholarship->scholarshipID])
    
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-6xl mx-auto p-6">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-2">Question Management</h1>
                    <p class="text-gray-600 font-medium">{{ $scholarship->name }}</p>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Application Questions</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach ($questions as $question)
                        <div class="p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-gray-900 font-medium mb-2">{{ $question->question_text }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ ucfirst($question->question_type) }}
                                    </span>
                                </div>
                                <div class="flex space-x-3 ml-4">
                                    <button type="button" onclick="openEditForm('{{ $question->questionID }}', '{{ $question->question_text }}', '{{ $question->question_type }}')"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                        Edit
                                    </button>
                                    <form action="{{ route('questions.destroy', $question->questionID) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this question?')"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-6 bg-gray-50 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Question</h3>
                        <form action="{{ route('questions.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="idScholarship" value="{{ $scholarship->scholarshipID }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                                    <input type="text" id="question_text" name="question_text" placeholder="Enter your question" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus">
                                </div>
                                <div>
                                    <label for="question_type" class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                                    <select id="question_type" name="question_type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus">
                                        <option value="" disabled selected>Select question type</option>
                                        <option value="text">Text Input</option>
                                        <option value="textarea">Text Area</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    Add Question
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Required Documents</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach ($documents as $doc)
                        <div class="p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-gray-900 font-medium mb-2">{{ $doc->name }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ strtoupper($doc->type) }}
                                    </span>
                                </div>
                                <div class="flex space-x-3 ml-4">
                                    <button onclick="openEditDoc({{ $doc->id }}, '{{ $doc->name }}', '{{ $doc->type }}')"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                        Edit
                                    </button>
                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this document?')"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-6 bg-gray-50 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Document</h3>
                        <form action="{{ route('documents.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="idScholarship" value="{{ $scholarship->scholarshipID }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <label for="doc_name" class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                                    <input type="text" id="doc_name" name="name" placeholder="Enter document name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus">
                                </div>
                                <div>
                                    <label for="doc_type" class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                                    <select id="doc_type" name="type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus">
                                        <option value="" disabled selected>Select type</option>
                                        <option value="pdf">PDF Document</option>
                                        <option value="image">Image File</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    Add Document
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Question Edit Modal -->
    <div id="overlay" class="overlay" style="display:none;"></div>
    <div id="editFormContainer" class="modal" style="display:none;">
        <div class="bg-white rounded-lg shadow-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Edit Question</h3>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="editText" class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                        <input type="text" id="editText" name="question_text" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="editType" class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                        <select id="editType" name="question_type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="text">Text Input</option>
                            <option value="textarea">Text Area</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" onclick="closeEditForm()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Document Edit Modal -->
    <div id="editDocOverlay" class="overlay" style="display:none;"></div>
    <div id="editDocFormContainer" class="modal" style="display:none;">
        <div class="bg-white rounded-lg shadow-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Edit Document</h3>
            </div>
            <form id="editDocForm" method="POST" class="p-6">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="editDocName" class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                        <input type="text" id="editDocName" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="editDocType" class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                        <select id="editDocType" name="type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="pdf">PDF Document</option>
                            <option value="image">Image File</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                    <button type="button" onclick="closeEditDoc()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update Document
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Notification -->
    @if (session('success') || session('success_docs'))
    <div id="notification" class="notification notification-enter">
        <div class="bg-white border border-green-200 rounded-lg shadow-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') ?: session('success_docs') }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="closeNotification()" class="text-green-400 hover:text-green-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (session('edit_error'))
    <div id="notification" class="notification notification-enter">
        <div class="bg-white border border-red-200 rounded-lg shadow-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('edit_error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="closeNotification()" class="text-red-400 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        function openEditForm(id, text, type) {
            document.getElementById('editForm').action = '/questions/' + id;
            document.getElementById('editText').value = text;
            document.getElementById('editType').value = type;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('editFormContainer').querySelector('.bg-white').classList.add('slide-in');
        }

        function closeEditForm() {
            const modal = document.getElementById('editFormContainer').querySelector('.bg-white');
            modal.classList.remove('slide-in');
            modal.classList.add('slide-out');
            setTimeout(() => {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('editFormContainer').style.display = 'none';
                modal.classList.remove('slide-out');
            }, 300);
        }

        function openEditDoc(id, name, type) {
            document.getElementById('editDocForm').action = `/documents/${id}`;
            document.getElementById('editDocName').value = name;
            document.getElementById('editDocType').value = type;
            document.getElementById('editDocOverlay').style.display = 'block';
            document.getElementById('editDocFormContainer').style.display = 'block';
            document.getElementById('editDocFormContainer').querySelector('.bg-white').classList.add('slide-in');
        }

        function closeEditDoc() {
            const modal = document.getElementById('editDocFormContainer').querySelector('.bg-white');
            modal.classList.remove('slide-in');
            modal.classList.add('slide-out');
            setTimeout(() => {
                document.getElementById('editDocOverlay').style.display = 'none';
                document.getElementById('editDocFormContainer').style.display = 'none';
                modal.classList.remove('slide-out');
            }, 300);
        }

        function closeNotification() {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.classList.remove('notification-enter');
                notification.classList.add('notification-exit');
                setTimeout(() => notification.remove(), 300);
            }
        }

        // Auto-hide notification after 3 seconds
        setTimeout(() => {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.classList.remove('notification-enter');
                notification.classList.add('notification-exit');
                setTimeout(() => notification.remove(), 300);
            }
        }, 3000);

        // Close modals when clicking overlay
        document.getElementById('overlay')?.addEventListener('click', closeEditForm);
        document.getElementById('editDocOverlay')?.addEventListener('click', closeEditDoc);
    </script>
</body>
</html>