{{-- resources/views/partials/mentor-ai.blade.php --}}
<div x-data="{ mode: '{{ empty($advice) ? 'form' : 'result' }}', advice: @js($advice) }" class="w-96 p-4 bg-white rounded shadow-lg">
  {{-- FORM --}}
  <template x-if="mode === 'form'">
    <form @submit.prevent="submit()" class="space-y-4">
      @csrf
      <h3 class="text-lg font-semibold">Get Scholarship Advice</h3>
      <input x-model="form.name" type="text" name="name" placeholder="Name" required class="w-full border rounded px-2 py-1">
      <input x-model="form.age" type="number" name="age" placeholder="Age" required class="w-full border rounded px-2 py-1">
      <input x-model="form.country" type="text" name="country" placeholder="Country" required class="w-full border rounded px-2 py-1">
      <input x-model="form.field" type="text" name="field" placeholder="Field" required class="w-full border rounded px-2 py-1">
      <input x-model="form.target" type="text" name="target" placeholder="Degree" required class="w-full border rounded px-2 py-1">
      <textarea x-model="form.experience" name="experience" placeholder="Experience" rows="3" class="w-full border rounded px-2 py-1"></textarea>
      <button type="submit" class="w-full py-2 bg-green-600 text-white rounded hover:bg-green-700">Get Advice</button>
    </form>
  </template>

  {{-- RESULT --}}
  <template x-if="mode === 'result'">
    <div>
      <h3 class="text-lg font-semibold mb-2">Your AI Mentor Advice</h3>
      <div class="prose max-h-60 overflow-auto" x-html="advice.replace(/\n/g, '<br>')"></div>
      <button @click="mode = 'form'; advice = null" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Try Again</button>
    </div>
  </template>

  <script>
    function submit() {
      let data = { ...this.form };
      fetch('{{ route('mentor.mentor') }}', {
        method: 'POST',
        headers: {'Content-Type': 'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body: JSON.stringify(data),
      })
      .then(r => r.json())
      .then(json => {
        this.advice = json.advice;
        this.mode = 'result';
      })
      .catch(err => alert('AI Error: '+ err));
    }
  </script>
</div>
