<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .notification {
            animation: slideInRight 0.4s ease-out, fadeOut 0.3s ease-in 2.7s forwards;
            transform: translateX(100%);
        }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .modal-overlay {
            background: rgba(17, 24, 39, 0.75);
        }

        .card-hover:hover {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }

        .layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 leading-relaxed">
    <div class="layout">
        <aside class="w-64 bg-white border-r border-gray-200 shadow-sm">
            @include('include.sidebar', ['scholarshipID' => $scholarshipID])
        </aside>

        <main class="flex-1 overflow-y-auto">
            @if (!$formClosed)
                <div class="flex items-center justify-center h-full p-8">
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-8 max-w-md text-center">
                        <svg class="w-12 h-12 text-amber-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-lg font-semibold text-amber-800 mb-2">Examination Stage Unavailable</h3>
                        <p class="text-amber-700">Examination stage cannot commence until all application procedures are
                            completed.</p>
                    </div>
                </div>
            @else
                <div class="max-w-6xl mx-auto px-8 py-8 space-y-8">
                    @if (isset($message))
                        <div class="flex items-center justify-center h-96">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 max-w-md text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4m0 4h.01M5.05 13a7 7 0 119.9-9.9" />
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Service Unavailable</h3>
                                <p class="text-gray-600">{{ $message }}</p>
                            </div>
                        </div>
                    @else
                        <header class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                                <div>
                                    <h1 class="text-2xl font-semibold text-gray-900 mb-2">Examination Management</h1>
                                    <p class="text-gray-600">Scholarship Program ID: <span
                                            class="font-medium text-indigo-600">{{ $scholarshipID }}</span></p>
                                </div>
                                <div class="mt-6 lg:mt-0">
                                    @if ($eligibleApplications->count() > 0)
                                        <form action="{{ route('supervisor.endExamStage', $scholarshipID) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button id="conclude-exam-btn" type="button"
                                                class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                                                Conclude Examination Stage
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </header>

                        @if ($eligibleApplications->count() > 0)
                            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @foreach ($eligibleApplications as $progress)
                                    <div
                                        class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover transition-all duration-200">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                                                        {{ $progress->application->user->fname }}
                                                        {{ $progress->application->user->lname }}
                                                    </h3>
                                                    <p class="text-gray-600 text-sm mb-2">
                                                        {{ $progress->application->user->email }}</p>
                                                    <p class="text-gray-500 text-xs">Application ID:
                                                        {{ $progress->application->applicationID }}</p>
                                                </div>
                                                <span
                                                    class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $progress->application->stageProgress->isNotEmpty() ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200' }}">
                                                    @if ($progress->application->stageProgress->isNotEmpty())
                                                        <svg class="w-3 h-3 mr-1 mt-0.5" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Invitation Sent
                                                    @else
                                                        <svg class="w-3 h-3 mr-1 mt-0.5" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Pending Invitation
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="flex flex-col sm:flex-row gap-3">
                                                @if ($progress->application->stageProgress->isNotEmpty())
                                                    <button disabled
                                                        class="px-4 py-2.5 bg-gray-100 text-gray-500 text-sm font-medium rounded-md cursor-not-allowed flex-1">
                                                        Examination Scheduled
                                                    </button>
                                                @else
                                                    <div x-data="{ showModal: false }" class="flex-1">
                                                        <button @click="showModal = true"
                                                            class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                                                            Send Invitation
                                                        </button>

                                                        <div x-show="showModal"
                                                            class="fixed inset-0 z-50 flex items-center justify-center modal-overlay"
                                                            x-transition>
                                                            <div
                                                                class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                                                                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                                                                    Schedule Examination</h3>
                                                                <form
                                                                    action="{{ route('exam.sendInvitation', ['applicationID' => $progress->application->applicationID]) }}"
                                                                    method="POST" class="space-y-4">
                                                                    @csrf
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-2">Exam
                                                                            Date & Time</label>
                                                                        <input type="datetime-local" name="exam_date"
                                                                            required
                                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                                                        <input type="text" name="exam_subject"
                                                                            required
                                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 mb-2">Additional
                                                                            Details <span
                                                                                class="text-gray-500">(Optional)</span></label>
                                                                        <textarea name="exam_details" rows="3"
                                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                                            placeholder="Special instructions or requirements..."></textarea>
                                                                    </div>
                                                                    <div class="flex justify-end gap-3 pt-4">
                                                                        <button type="button"
                                                                            @click="showModal = false"
                                                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                                                                            Cancel
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                                                                            Send & Notify
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <a href="{{ route('exam.details', ['studentID' => $progress->application->idUser]) }}"
                                                    class="px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition-colors text-center">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </section>
                        @else
                            <div class="text-center py-16">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 max-w-md mx-auto">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-6" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Eligible Candidates</h3>
                                    <p class="text-gray-600">There are currently no students eligible for examination
                                        scheduling.</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </main>
    </div>

    {{-- @if (session('success'))
        <div class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg notification z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-6 right-6 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg notification z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif --}}

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(el => {
                el.style.animation = 'fadeOut 0.3s ease-in forwards';
                setTimeout(() => el.remove(), 300);
            });
        }, 3000);
    </script>
</body>
<script>
// 1) Confirmation dialog
document.getElementById('conclude-exam-btn').addEventListener('click', function() {
  Swal.fire({
    title: 'Are you sure?',
    text: 'This will conclude the Examination stage for all eligible applicants!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, conclude it!',
    cancelButtonText: 'No, not yet',
    customClass: {
     actions: 'justify-center space-x-2',
      confirmButton: 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg',
      cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg'
    },
    buttonsStyling: false
  }).then((result) => {
    if (result.isConfirmed) {
      this.closest('form').submit();
    }
  });
});

// 2) On page load, if session('success'), show toast
@if(session('success'))
Swal.fire({
  toast: true,
  position: 'top-end',
  icon: 'success',
  title: @json(session('success')),
  showConfirmButton: false,
  timer: 2500,
  timerProgressBar: true,
  customClass: {
    popup: 'text-sm px-3 py-2 rounded-md shadow-md'
  }
});
@endif
</script>

</html>
