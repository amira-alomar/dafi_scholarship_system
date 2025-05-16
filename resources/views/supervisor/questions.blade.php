<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        .modal-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 50;
            width: 90%;
            max-width: 500px;
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Question Manager</h1>
                </div>
                <div>
                    <a href="/dashboard" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#e05252] hover:bg-[#c94545] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e05252] transition-colors">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800">Manage Questions: {{ $scholarship->name }}</h2>
            </div>

            <!-- Alerts -->
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-md border border-green-200 alert fade-in">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('edit_error'))
                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-md border border-red-200 alert fade-in">
                        {{ session('edit_error') }}
                    </div>
                @endif
            </div>

            <!-- Questions List -->
            <div class="divide-y divide-gray-200">
                @foreach($questions as $question)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-800 font-medium">{{ $question->question_text }}</p>
                                <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                    {{ $question->question_type }}
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" 
                                        class="px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e05252] transition-colors"
                                        onclick="openEditForm('{{ $question->questionID }}', '{{ $question->question_text }}', '{{ $question->question_type }}')">
                                    Edit
                                </button>
                                <form action="{{ route('questions.destroy', $question->questionID) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#ef4444] hover:bg-[#dc2626] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ef4444] transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add New Question -->
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Question</h3>
                <form action="{{ route('questions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="idScholarship" value="{{ $scholarship->scholarshipID }}">
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                        <input type="text" 
                               id="question_text" 
                               name="question_text" 
                               placeholder="Enter new question" 
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e05252] focus:ring focus:ring-[#e05252] focus:ring-opacity-50 transition-colors">
                    </div>
                    <div>
                        <label for="question_type" class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                        <select id="question_type" 
                                name="question_type" 
                                required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e05252] focus:ring focus:ring-[#e05252] focus:ring-opacity-50 transition-colors">
                            <option value="" disabled selected>Select type of question</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#e05252] hover:bg-[#c94545] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e05252] transition-colors">
                            Add Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup Overlay -->
    <div id="overlay" class="overlay" style="display:none;"></div>

    <!-- Modal Edit Form -->
    <div id="editFormContainer" class="modal-form" style="display:none;">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Question</h3>
            <div class="space-y-4">
                <div>
                    <label for="editText" class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                    <input type="text" 
                           id="editText" 
                           name="question_text" 
                           required
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e05252] focus:ring focus:ring-[#e05252] focus:ring-opacity-50 transition-colors">
                </div>
                <div>
                    <label for="editType" class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                    <select id="editType" 
                            name="question_type" 
                            required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e05252] focus:ring focus:ring-[#e05252] focus:ring-opacity-50 transition-colors">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" 
                            onclick="closeEditForm()"
                            class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#e05252] hover:bg-[#c94545] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e05252] transition-colors">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="p-6 bg-gray-50 border-t border-gray-200">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Required Documents</h3>

    {{-- Alerts for docs --}}
    @if(session('success_docs'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-md border border-green-200 alert fade-in">
            {{ session('success_docs') }}
        </div>
    @endif

    {{-- Documents List --}}
    <div class="divide-y divide-gray-200 mb-6">
        @foreach($documents as $doc)
            <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                <div>
                    <span class="font-medium text-gray-800">{{ $doc->name }}</span>
                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ strtoupper($doc->type) }}</span>
                </div>
                <div class="flex space-x-2">
                    <button onclick="openEditDoc({{ $doc->id }}, '{{ $doc->name }}', '{{ $doc->type }}')" 
                            class="px-3 py-1.5 border rounded-md text-sm bg-white hover:bg-gray-100">Edit</button>
                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete document?')" 
                                class="px-3 py-1.5 rounded-md text-sm bg-red-500 text-white hover:bg-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Add Document Form --}}
    <form action="{{ route('documents.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="idScholarship" value="{{ $scholarship->scholarshipID }}">
        <div class="flex space-x-4">
            <input type="text" name="name" placeholder="Document Name" required 
                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring focus:ring-red-200">
            <select name="type" required class="rounded-md border-gray-300 shadow-sm focus:ring focus:ring-red-200">
                <option value="" disabled selected>Type</option>
                <option value="pdf">PDF</option>
                <option value="image">Image</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Add</button>
        </div>
    </form>
</div>

{{-- Edit Document Modal (similar to question) --}}
<div id="editDocOverlay" class="overlay" style="display:none;"></div>
<div id="editDocFormContainer" class="modal-form" style="display:none;">
    <form id="editDocForm" method="POST">
        @csrf @method('PUT')
        <h3 class="text-lg font-medium">Edit Document</h3>
        <div class="space-y-4 mt-4">
            <input type="text" name="name" id="editDocName" required class="block w-full">
            <select name="type" id="editDocType" required class="block w-full">
                <option value="pdf">PDF</option>
                <option value="image">Image</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditDoc()" class="px-3 py-1.5">Cancel</button>
                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white">Update</button>
            </div>
        </div>
    </form>
</div>

<script>
function openEditDoc(id, name, type) {
    const form = document.getElementById('editDocForm');
    form.action = `/documents/${id}`;
    document.getElementById('editDocName').value = name;
    document.getElementById('editDocType').value = type;
    document.getElementById('editDocOverlay').style.display = 'block';
    document.getElementById('editDocFormContainer').style.display = 'block';
}

function closeEditDoc() {
    document.getElementById('editDocOverlay').style.display = 'none';
    document.getElementById('editDocFormContainer').style.display = 'none';
}
</script>


    <script>
        function openEditForm(id, text, type) {
            const form = document.getElementById('editForm');
            form.action = '/questions/' + id;
            document.getElementById('editText').value = text;
            document.getElementById('editType').value = type;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editFormContainer').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'none';
        }

        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert) alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert) alert.style.display = 'none';
                }, 300);
            });
        }, 2000);
    </script>
</body>
</html>