@if (!empty($advice))
  <!-- Global Advice Box -->
  <div id="advice-box" class="advice-box-global">
    <div class="advice-text">
      {!! nl2br(e($advice)) !!}
    </div>
    <button id="try-again" class="try-again">🔄 Try Again</button>
  </div>
@endif

<!-- Floating Action Button -->
<button id="floating-btn" class="fab" title="Open Mentor">
  <span>💡</span>
  {{-- <span>🤖</span> --}}
</button>

<!-- Overlay + Panel -->
<div id="mentor-panel" class="overlay overlay-hidden">
  <!-- Panel Container -->
  <div class="panel-container">
    <!-- Close “X” -->
    <button id="close-panel" class="close-btn">&times;</button>

    <!-- Header / Avatar -->
    <div class="header">
      <div class="avatar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M8 10h.01M12 10h.01M16 10h.01M9 16h6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <h2 class="title">Get Scholarship Advice</h2>
    </div>

    <!-- Mentor Form -->
    <div id="mentor-form" class="form-box">
      <form method="POST" action="{{ route('mentor.mentor') }}">
        @csrf
        <div class="form-group">
          <label>Age</label>
          <input type="text" name="age" value="{{ old('age') }}" required>
        </div>
        <div class="form-group">
          <label>Country</label>
          <input type="text" name="country" value="{{ old('country') }}" required>
        </div>
        <div class="form-group">
          <label>Field of Study / Interest</label>
          <input type="text" name="field" value="{{ old('field') }}" required>
        </div>
        <div class="form-group">
          <label>Target Degree / Level</label>
          <input type="text" name="target" value="{{ old('target') }}" required>
        </div>
        <button type="submit" class="submit-btn">🎓 Get Advice</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fab = document.getElementById('floating-btn');
    const panel = document.getElementById('mentor-panel');
    const closer = document.getElementById('close-panel');
    const tryAgain = document.getElementById('try-again');

    function disableScroll() { document.body.style.overflow = 'overlay-hidden'; }
    function enableScroll() { document.body.style.overflow = ''; }

    fab.addEventListener('click', () => {
      panel.classList.remove('overlay-hidden');
      disableScroll();
    });
    closer.addEventListener('click', () => {
      panel.classList.add('overlay-hidden');
      enableScroll();
    });
    if (tryAgain) {
      tryAgain.addEventListener('click', () => {
        window.location = '{{ route('mentor.mentor') }}';
      });
    }
  });
</script>

<style>
/* keep existing CSS unchanged */
</style>

<!-- Pure CSS -->
<style>
/* Floating Action Button */
.fab {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
    border: none;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
}
.fab:hover { transform: scale(1.1); }

/* Overlay Panel */
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
    padding: 16px;
    z-index: 900;
}
.overlay-hidden { display: none; }

.panel-container {
    background: #fff;
    border-radius: 16px;
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    overflow: auto;
    position: relative;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease-out;
}

.close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    background: transparent;
    border: none;
    font-size: 24px;
    color: #666;
    cursor: pointer;
}
.close-btn:hover { color: #333; }

.header {
    display: flex;
    align-items: center;
    margin-bottom: 24px;
}
.avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #8b5cf6, #ec4899);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.avatar svg { width: 24px; height: 24px; color: #fff; }
.title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.advice-box {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.advice-text {
    max-height: 65vh;
    overflow-y: auto;
    line-height: 1.6;
    color: #444;
}
.try-again {
    padding: 12px;
    background: linear-gradient(90deg, #3b82f6, #6366f1);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}
.try-again:hover { background: linear-gradient(90deg, #6366f1, #3b82f6); transform: translateY(-2px); }

.form-box {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.form-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.form-group label { font-size: 0.875rem; color: #555; }
.form-group input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.3s ease;
}
.form-group input:focus { border-color: #8b5cf6; }

.submit-btn {
    padding: 12px;
    background: #8b5cf6;
    border: none;
    border-radius: 12px;
    color: #fff;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}
.submit-btn:hover { background: #7c3aed; transform: scale(1.02); }

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.advice-box-global {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    border-radius: 16px;
    max-width: 480px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    z-index: 1200;
    display: flex;
    flex-direction: column;
    gap: 16px;
    animation: fadeIn 0.3s ease-out;
}


</style>