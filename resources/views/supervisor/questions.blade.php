<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <link rel="stylesheet" href="{{ asset('css/questions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <div class="main-wrapper">
        @include('include.sidebar')

        <div class="main-content">
            <h2>Manage Questions {{ $scholarship->name }}</h2>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if(session('edit_error'))
                <div class="alert alert-error">
                    {{ session('edit_error') }}
                </div>
            @endif

            <!-- Display Questions -->
            @foreach($questions as $question)
                <div class="question">
                    <span>{{ $question->question_text }}</span>
                    <span>{{ $question->question_type }}</span>
                    <div class="buttons">
                        <button type="button" class="btn-edit" onclick="openEditForm('{{ $question->questionID }}', '{{ $question->question_text }}', '{{ $question->question_type }}')">Edit</button>
                        <form action="{{ route('questions.destroy', $question->questionID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Add New Question Form -->
            <div class="add-question">
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idScholarship" value="{{ $scholarship->scholarshipID }}">
                    <input type="text" name="question_text" placeholder="Enter new question" required>
                    <select name="question_type" required>
                        <option value="" disabled selected>Select type of question</option>
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>n>
                    </select>
                    <button class="add-btn" type="submit">Add</button>
                </form>
            </div>
        </div>

        <!-- Popup Overlay -->
        <div id="overlay" class="overlay" style="display:none;"></div>

        <!-- Modal Edit Form -->
        <div id="editFormContainer" class="modal-form" style="display:none;">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <h3>Edit Question</h3>
                <div class="form-group">
                    <label for="editText">Question Text</label>
                    <input type="text" id="editText" name="question_text" required>
                </div>
                <div class="form-group">
                    <label for="editType">Question Type</label>
                    <select id="editType" name="question_type" required>
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">Update</button>
                    <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditForm(id, text, type) {
            const form = document.getElementById('editForm');
            form.action = '/questions/' + id;
            document.getElementById('editText').value = text;
            document.getElementById('editType').value = type;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('editFormContainer').classList.add('show');
        }

        function closeEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'none';
        }
    </script>
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => alert.style.display = 'none');
        }, 2000); 
    </script>
    
</body>
</html>
