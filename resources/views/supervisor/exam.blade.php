<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Invitation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/exam.css') }}">
</head>

<body class="flex h-screen bg-gray-100">
  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md">
    @include('include.sidebar', ['scholarshipID' => $scholarshipID])
  </aside>

  <main class="flex-1 overflow-auto p-6">
    @if (!$formClosed)
      <div class="flex items-center justify-center h-full">
        <p class="text-lg text-gray-700">Exam stage cannot start yet—there are still applicants in the Form stage.</p>
      </div>
    @else
      @if (session('success'))
        <!-- Toast Notification -->
        <div id="toast" class="fixed bottom-6 right-6 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg transform translate-x-32 opacity-0 transition-all duration-500">
          <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <div>
              <p class="font-semibold">Email Sent</p>
              <p class="text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="hideToast()" class="ml-auto focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 6l8 8m0-8l-8 8" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      @endif

      <header class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Invitations</h1>
        <p class="text-gray-600">Scholarship ID: <span class="font-medium">{{ $scholarshipID }}</span></p>
      </header>

      @if (isset($message))
        <div class="flex items-center justify-center h-64">
          <div class="bg-white rounded-lg p-8 shadow-md text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 14v-6" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Not available</h2>
            <p class="text-gray-600 mt-2">{{ $message }}</p>
          </div>
        </div>
      @else
        <div class="space-y-4">
          @if ($eligibleApplications->count() > 0)
            <form action="{{ route('supervisor.endExamStage', $scholarshipID) }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">End Exam Stage (Reject All Pending)</button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
              @foreach ($eligibleApplications as $progress)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition relative">
                  <div class="space-y-1">
                    <p><strong>Student:</strong> {{ $progress->application->user->fname }} {{ $progress->application->user->lname }}</p>
                    <p><strong>Email:</strong> {{ $progress->application->user->email }}</p>
                    <p><strong>Application ID:</strong> {{ $progress->application->applicationID }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full @if ($progress->application->stageProgress->isNotEmpty()) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                      @if ($progress->application->stageProgress->isNotEmpty()) ✓ Invitation Sent @else ✗ Pending Invitation @endif
                    </span>
                  </div>

                  <div class="mt-4 flex space-x-2">
                    @if ($progress->application->stageProgress->isEmpty())
                      <button onclick="openModal('modal-{{ $progress->application->applicationID }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Send Invitation</button>
                    @else
                      <button disabled class="bg-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed">Invitation Sent</button>
                    @endif
                    <a href="{{ route('exam.details', ['studentID' => $progress->application->idUser]) }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">View Details</a>
                  </div>

                  <!-- Modal (hidden by default) -->
                  @if ($progress->application->stageProgress->isEmpty())
                    <div id="modal-{{ $progress->application->applicationID }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                      <div class="bg-white rounded-lg w-full max-w-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Send Exam Invitation</h2>
                        <form action="{{ route('exam.sendInvitation', ['applicationID' => $progress->application->applicationID]) }}" method="POST">
                          @csrf
                          <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Exam Date & Time</label>
                            <input type="datetime-local" name="exam_date" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                          </div>
                          <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Subject</label>
                            <input type="text" name="exam_subject" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                          </div>
                          <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Details <small>(optional)</small></label>
                            <textarea name="exam_details" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" placeholder="Anything extra…"></textarea>
                          </div>
                          <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeModal('modal-{{ $progress->application->applicationID }}')" class="px-4 py-2">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Send & Email</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-12">
              <p class="text-gray-700">No eligible students found for this scholarship.</p>
            </div>
          @endif
        </div>
      @endif
    @endif
  </main>

  <script>
    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }
    function hideToast() {
      const toast = document.getElementById('toast');
      toast.classList.add('translate-x-32', 'opacity-0');
    }
    document.addEventListener('DOMContentLoaded', () => {
      // Show toast if exists
      const toast = document.getElementById('toast');
      if (toast) setTimeout(() => {
        toast.classList.remove('translate-x-32');
        toast.classList.remove('opacity-0');
      }, 1000);
    });
  </script>
</body>

</html>
