<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Applications Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-down': 'slideDown 0.3s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite',
                    },
                    keyframes: {
                        slideDown: {
                            '0%': {
                                transform: 'translateY(-10px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                            '100%': {
                                transform: 'translateY(-10px)',
                                opacity: '0'
                            }
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        pulseSoft: {
                            '0%, 100%': {
                                opacity: '1'
                            },
                            '50%': {
                                opacity: '0.8'
                            }
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="flex min-h-screen font-poppins">
    <aside class="w-64 bg-gray-900 text-white  hidden md:block h-screen overflow-y-auto sticky top-0">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </aside>

    <div class="container mx-auto px-4 py-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center lg:text-left">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                    Final Applications Results
                </h1>
                <p class="text-gray-600 text-lg">
                    Scholarship #<span class="font-semibold text-blue-600">{{ $scholarshipID }}</span>
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="success-message mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-md animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Applications Grid -->
        <div class="space-y-6">
            @foreach ($applications as $application)
                <div
                    class="application-card bg-white rounded-2xl shadow-lg border border-gray-200 p-6 lg:p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in">
                    <!-- Applicant Header -->
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span
                                    class="text-blue-600 font-bold text-lg">{{ substr($application->user->fname, 0, 1) }}</span>
                            </div>
                            {{ $application->user->fname }}
                        </h2>

                        @if ($application->status !== 'pending')
                            <div class="final-result flex items-center bg-gray-50 px-4 py-2 rounded-full">
                                <span class="text-gray-600 mr-2 text-sm font-medium">Final Result:</span>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if (strtolower($application->status) === 'approved') bg-green-100 text-green-800
                                    @elseif(strtolower($application->status) === 'rejected')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Progress List -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Application Progress
                        </h3>
                        <div class="grid gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($application->stageProgress as $progress)
                                <div
                                    class="progress-item bg-gray-50 rounded-xl p-4 border border-gray-200 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="progress-stage font-semibold text-gray-800 capitalize">
                                            {{ $progress->stage->name }}
                                        </span>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            @if (strtolower($progress->status) === 'passed') bg-green-100 text-green-800
                                            @elseif(strtolower($progress->status) === 'failed')
                                                bg-red-100 text-red-800
                                            @elseif(strtolower($progress->status) === 'pending')
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($progress->status) }}
                                        </span>
                                    </div>

                                    @php
                                        $stageName = strtolower($progress->stage->name);
                                    @endphp

                                    @if ($stageName === 'form')
                                        <a class="details-link inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors duration-200"
                                            href="{{ route('supervisor.applicationDetails', ['scholarshipId' => $scholarshipID, 'applicationID' => $application->applicationID]) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            View Details
                                        </a>
                                    @elseif($stageName === 'exam')
                                        <a class="details-link inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors duration-200"
                                            href="{{ route('exam.details', ['studentID' => $application->user->id]) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            View Details
                                        </a>
                                    @elseif($stageName === 'interview')
                                        <a class="details-link inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors duration-200"
                                            href="{{ route('interview.details', ['studentID' => $application->user->id]) }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            View Details
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-6">
                        @if ($application->notes)
                            <div class="notes-section bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    <span class="notes-title font-semibold text-amber-800">Notes:</span>
                                </div>
                                <p class="notes-content text-amber-700 text-sm leading-relaxed">
                                    {{ $application->notes }}</p>
                            </div>
                        @else
                            <form action="{{ route('supervisor.addNote', ['scholarshipID' => $scholarshipID]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $application->applicationID }}">

                                <button type="button"
                                    class="add-notes-btn inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 hover:shadow-md"
                                    onclick="toggleNotesField('{{ $application->applicationID }}')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Notes
                                </button>

                                <div id="notes-field-{{ $application->applicationID }}"
                                    class="notes-form mt-4 overflow-hidden transition-all duration-300 max-h-0 opacity-0">
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                        <textarea name="notes"
                                            class="notes-textarea w-full h-24 p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            placeholder="Enter your notes here..."></textarea>
                                        <div class="flex justify-end mt-3">
                                            <button type="submit"
                                                class="save-note-btn px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                                Save Note
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if ($application->status == 'pending')
                        <div class="action-buttons flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                            <form
                                action="{{ route('finalApplication.approve', ['applicationID' => $application->applicationID]) }}"
                                method="POST" class="flex-1">
                                @csrf
                                <!-- ACCEPT BUTTON -->
                                <button type="submit"
                                    class="accept-btn relative w-full px-6 py-3 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-semibold rounded-full shadow-xl transform transition duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300 flex items-center justify-center overflow-hidden">
                                    <svg class="w-5 h-5 mr-2 animate-pulse-soft" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Accept Application
                                </button>

                            </form>

                            <form
                                action="{{ route('finalApplication.reject', ['applicationID' => $application->applicationID]) }}"
                                method="POST" class="flex-1">
                                @csrf
                                <!-- REJECT BUTTON -->
                                <button type="submit"
                                    class="reject-btn relative w-full px-6 py-3 bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white font-semibold rounded-full shadow-xl transform transition duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-300 flex items-center justify-center overflow-hidden">
                                    <svg class="w-5 h-5 mr-2 animate-pulse-soft" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reject Application
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function toggleNotesField(applicationId) {
            const notesField = document.getElementById(`notes-field-${applicationId}`);
            const isOpen = notesField.style.maxHeight && notesField.style.maxHeight !== '0px';

            if (isOpen) {
                // Close
                notesField.style.maxHeight = '0px';
                notesField.style.opacity = '0';
            } else {
                // Open
                notesField.style.maxHeight = notesField.scrollHeight + 'px';
                notesField.style.opacity = '1';
            }
        }

        // Add animation to success message
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    successMessage.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 3000);
            }

            // Add staggered animation to application cards
            const cards = document.querySelectorAll('.application-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Add ripple effect to buttons
        document.addEventListener('click', function(e) {
            if (e.target.matches('.accept-btn, .reject-btn, .save-note-btn')) {
                const button = e.target;
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;

                button.style.position = 'relative';
                button.style.overflow = 'hidden';
                button.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            }
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
