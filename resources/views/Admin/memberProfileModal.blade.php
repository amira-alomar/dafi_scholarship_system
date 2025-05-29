<div class="bg-[--card] rounded-[--radius] shadow-xl w-full max-w-md p-6 relative">
  <button id="closeMemberModal" class="absolute top-4 right-4 text-[--foreground] hover:text-red-500">✕</button>
  <h2 class="text-2xl font-semibold text-[--foreground] mb-4 text-center">Member Profile</h2>
  <div class="space-y-3 text-[--foreground]">
    <p><strong>Name:</strong> {{ $memberInfo->user->fname }} {{ $memberInfo->user->lname }}</p>
    <p><strong>Joined:</strong> {{ $memberInfo->created_at->format('F j, Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($memberInfo->status) }}</p>
    {{-- add any club‑specific fields here --}}
  </div>
</div>
<script>
  document.querySelectorAll('.view-member-profile').forEach(btn => {
    btn.addEventListener('click', async () => {
      const userId = btn.dataset.userId;
      const modal = document.getElementById('memberModal');
      const content = document.getElementById('memberModalContent');

      try {
        const res = await fetch(`{{ url('admin/member-profile') }}/${userId}`);
        if (!res.ok) throw new Error('Failed to load profile');
        const html = await res.text();
        content.innerHTML = html;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // wire up close
        document.getElementById('closeMemberModal').onclick = () => {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        };
        modal.onclick = e => {
          if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
          }
        };
      } catch (err) {
        console.error(err);
      }
    });
  });
</script>
