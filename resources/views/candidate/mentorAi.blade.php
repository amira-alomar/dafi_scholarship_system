<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Mentor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-input {
            transition: all 0.2s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(22, 163, 184, 0.2);
        }

        .advice-content {
            line-height: 1.4;
            font-size: 0.875rem;
        }

        /* Modal backdrop */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="bg-[#f5f5f5] font-sans relative">

    <!-- Floating AI Button -->
    <button id="open-modal-btn"
        class="fixed bottom-6 right-6 w-14 h-14 bg-[#16a3b8] hover:bg-[#0e8a97] text-white rounded-full shadow-lg flex items-center justify-center z-50 transition-colors">
        <i class="fas fa-robot fa-lg"></i>
    </button>

    <!-- Modal Overlay -->
    <div id="modal" class="hidden fixed inset-0 flex items-center justify-center modal-backdrop z-40">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6 relative">
            <!-- Close Button -->
            <button id="close-modal-btn" class="absolute top-3 right-3 text-[#64748b] hover:text-[#0f172a]">
                <i class="fas fa-times fa-lg"></i>
            </button>

            <h2 class="text-xl font-bold mb-4 flex items-center text-[#0f172a]">
                <i class="fas fa-hands-helping text-[#e05252] mr-2"></i>
                Your Scholarship Mentor
            </h2>

            @if (isset($advice))
                <div class="advice-content bg-[#f1f5f9] p-4 rounded mb-4 text-[#0f172a] whitespace-pre-wrap">
                    {{ $advice }}
                </div>
                <div class="text-right">
                    <a href="{{ route('mentor.mentor') }}" class="bg-[#e05252] px-4 py-1 rounded text-sm text-white">Try
                        Again</a>
                </div>
            @else
                <form action="{{ route('mentor.mentor') }}" method="POST" class="space-y-4 text-sm">
                    @csrf
                    <input name="name" placeholder="Full Name" required
                        class="form-input w-full px-3 py-2 border rounded">
                    <input name="age" placeholder="Age" required class="form-input w-full px-3 py-2 border rounded">
                    <input name="country" placeholder="Country" required
                        class="form-input w-full px-3 py-2 border rounded">
                    <input name="field" placeholder="Field of Study" required
                        class="form-input w-full px-3 py-2 border rounded">
                    <input name="target" placeholder="Target Degree" required
                        class="form-input w-full px-3 py-2 border rounded">
                    <textarea name="experience" placeholder="Your Experience & Skills" required
                        class="form-input w-full px-3 py-2 border rounded"></textarea>
                    <button type="submit" class="w-full bg-[#e05252] px-4 py-2 rounded text-white">Get Advice</button>
                </form>
            @endif

        </div>
    </div>

    <script>
        const openBtn = document.getElementById('open-modal-btn');
        const closeBtn = document.getElementById('close-modal-btn');
        const modal = document.getElementById('modal');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
        closeBtn?.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
        // Close on backdrop click
        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
