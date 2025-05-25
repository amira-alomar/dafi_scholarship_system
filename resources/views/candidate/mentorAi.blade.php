{{-- Floating Action Button --}}
<button id="floating-btn" title="Open Mentor"
    class="fixed bottom-6 right-6 bg-purple-600 text-white p-4 rounded-full shadow-lg hover:bg-purple-700 focus:outline-none transition duration-300 z-50">
    💡
</button>

{{-- Overlay + Panel --}}
<div id="mentor-panel" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-40 overflow-auto">
     
    {{-- Panel Container (أصغر شوي) --}}
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative max-h-[90vh] overflow-auto p-6">
        {{-- Close “X” --}}
        <button id="close-panel"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 focus:outline-none text-xl">
            &times;
        </button>

        {{-- المحتوى --}}
        @if (!empty($advice))
            <div id="advice-box">
                <h2 class="text-2xl font-semibold mb-4">Your AI Mentor Advice</h2>
                <div class="prose max-h-[70vh] overflow-auto">
                    {!! nl2br(e($advice)) !!}
                </div>
                <button id="try-again" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Try Again
                </button>
            </div>
        @else
            <div id="mentor-form">
                <h2 class="text-2xl font-semibold mb-4">Get Scholarship Advice</h2>
                <form method="POST" action="{{ route('mentor.mentor') }}">
                    @csrf
                    <div class="space-y-4">
                        {{-- نفس الفورم --}}
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Age</label>
                            <input type="number" name="age" value="{{ old('age') }}" required
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Country</label>
                            <input type="text" name="country" value="{{ old('country') }}" required
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Field of Study / Interest</label>
                            <input type="text" name="field" value="{{ old('field') }}" required
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Target Degree / Level</label>
                            <input type="text" name="target" value="{{ old('target') }}" required
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Experience / Background</label>
                            <textarea name="experience" rows="3" class="w-full border rounded px-3 py-2">{{ old('experience') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Get Advice
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fab = document.getElementById('floating-btn');
        const panel = document.getElementById('mentor-panel');
        const closer = document.getElementById('close-panel');
        const tryAgain = document.getElementById('try-again');

        function disableScroll() {
            document.body.style.overflow = 'hidden';
        }
        function enableScroll() {
            document.body.style.overflow = '';
        }

        // افتح المودال ومنع سكرول الصفحة الخلفية
        fab.addEventListener('click', () => {
            panel.classList.remove('hidden');
            disableScroll();
        });

        // اقفل المودال وارجع السماح بالسكرول
        closer.addEventListener('click', () => {
            panel.classList.add('hidden');
            enableScroll();
        });

        // اضغط Try Again يعيد تحميل الصفحة (بيشتغل داخل المودال)
        if (tryAgain) {
            tryAgain.addEventListener('click', () => {
                window.location = '{{ route('mentor.mentor') }}';
            });
        }
    });
</script>
