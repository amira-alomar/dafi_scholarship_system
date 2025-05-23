<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/exam.css') }}">
</head>
<style>
    /* Animation for notifications */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .notification {
        animation: slideIn 0.3s ease-out;
    }

    .layout {
        display: flex;
        height: 100vh;
        /* Full height of viewport */
        overflow: hidden;
    }

    .layout>.content {
        flex: 1;
        overflow-y: auto;
        /* Scrollable main content */
        padding: 20px;
    }
</style>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </div>
    @if (!$formClosed)
        <div class="empty-state center">
            <p> Exam stage cannot start yet—there are still applicants in the Form stage.</p>
        </div>
    @else
        @if (session('success'))
            <!-- Notification -->
            <div class="fixed bottom-4 right-4 w-72 card p-4 shadow-lg notification hidden">
                <div class="flex items-start">
                    <div class="p-2 bg-green-100 text-green-600 rounded-full mr-3">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Email Sent</h4>
                        <p class="text-sm text-muted">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto text-muted hover:text-foreground" onclick="hideNotification()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif


        <div class="content">
            <!-- Main Content -->
            <div class="container">
                @if (isset($message))
                    <div class="content">
                        <div class="container mx-auto px-0 max-w-full">
                            <div class="flex items-center justify-center h-screen w-full">
                                <div class="bg-light-gray rounded-lg p-8 text-center shadow-lg">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                                    <h3 class="text-xl font-semibold text-gray-800">Not available</h3>
                                    <p class="text-gray-600 mt-2">{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                
                    <div class="page-header">
                        <h2>Exam Invitations</h2>
                        <h3>Scholarship ID: {{ $scholarshipID }}</h3>
                    </div>

                    @if ($eligibleApplications->count() > 0)
                    <form action="{{ route('supervisor.endExamStage', $scholarshipID) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger">
        End Exam Stage (Reject All Pending)
    </button>
</form>

                        <div class="invitation-grid">
                            @foreach ($eligibleApplications as $progress)
                                <div class="invitation-item @if ($progress->application->stageProgress->isNotEmpty()) disabled @endif">
                                    <div class="info">
                                        <p><strong>Student:</strong> {{ $progress->application->user->fname }}
                                            {{ $progress->application->user->lname }}</p>
                                        <p><strong>Email:</strong> {{ $progress->application->user->email }}</p>
                                        <p><strong>Application ID:</strong> {{ $progress->application->applicationID }}
                                        </p>
                                        <span
                                            class="status @if ($progress->application->stageProgress->isNotEmpty()) status-sent @else status-pending @endif">
                                            @if ($progress->application->stageProgress->isNotEmpty())
                                                ✓ Invitation Sent
                                            @else
                                                ✗ Pending Invitation
                                            @endif
                                        </span>
                                    </div>

                                    <div class="btn-group">
                                        @if ($progress->application->stageProgress->isNotEmpty())
                                            <button class="send-btn" disabled>Invitation Sent</button>
                                        @else
                                            <form
                                                action="{{ route('exam.sendInvitation', ['applicationID' => $progress->application->applicationID]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="send-btn">Send Invitation</button>
                                            </form>
                                        @endif
                                    </div>

                                    <a href="{{ route('exam.details', ['studentID' => $progress->application->idUser]) }}"
                                        class="btn-info">
                                        View Exam Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p>No eligible students found for this scholarship.</p>
                        </div>
                    @endif
                @endif
            </div>

            <script>
                // Enhanced button interactions
                document.addEventListener('DOMContentLoaded', function() {
                    const buttons = document.querySelectorAll('.send-btn:not(:disabled), .btn-info');

                    buttons.forEach(button => {
                        // Add ripple effect
                        button.addEventListener('click', function(e) {
                            const rect = this.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;

                            const ripple = document.createElement('span');
                            ripple.className = 'ripple';
                            ripple.style.left = `${x}px`;
                            ripple.style.top = `${y}px`;

                            this.appendChild(ripple);

                            setTimeout(() => {
                                ripple.remove();
                            }, 600);
                        });

                        // Hover effects
                        button.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-2px)';
                        });

                        button.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0)';
                        });
                    });
                });
                Show notification(demo)
                setTimeout(function() {
                    document.querySelector('.notification').classList.remove('hidden');
                }, 2000);

                function hideNotification() {
                    document.querySelector('.notification').classList.add('hidden');
                }
            </script>
        </div>
    @endif
</body>

</html>
