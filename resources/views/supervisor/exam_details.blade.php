<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #D32F2F;
            --dark-bg: #fff;
            /* now the page background */
            --accent-bg: #f4f4f4;
            /* card backgrounds */
            --light-bg: #fff;
            --muted-bg: #fff;
            --light-gray: #f9f9f9;
            --text-color: #333;
            /* main text color */
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
            min-height: 100vh;
        }

        .card {
            background-color: var(--accent-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed) ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .info-item {
            background-color: rgba(0, 0, 0, 0.03);
            border-left: 4px solid var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            transition: all var(--transition-speed) ease;
        }

        .btn-primary:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: #388E3C;
            transition: all var(--transition-speed) ease;
        }

        .btn-success:hover {
            background-color: #2E7D32;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: #D32F2F;
            transition: all var(--transition-speed) ease;
        }

        .btn-danger:hover {
            background-color: #B71C1C;
            transform: translateY(-2px);
        }

        .status-accepted {
            background-color: rgba(56, 142, 60, 0.1);
            border-left: 4px solid #388E3C;
        }

        .status-rejected {
            background-color: rgba(211, 47, 47, 0.1);
            border-left: 4px solid #D32F2F;
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex items-center justify-center p-4">
    <div class="container mx-auto max-w-4xl">
        <div class="card p-8 fade-in">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-clipboard-check text-red-500 mr-3"></i>
                        Exam Details
                    </h1>
                    <p class="text-gray-600 mt-2">for {{ $student->fname }} {{ $student->lname }}</p>
                </div>
                <a href="{{ url()->previous() }}"
                    class="btn-primary text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>

            <!-- Content -->
            @if (!$exam)
                <div class="bg-light-gray rounded-lg p-8 text-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800">No Exam Found</h3>
                    <p class="text-gray-600 mt-2">No exam record exists for this student.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="info-item p-4 rounded-lg">
                        <p class="text-gray-600 text-sm font-medium">Course</p>
                        <p class="text-gray-800 text-lg font-semibold">{{ $exam->course ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item p-4 rounded-lg">
                        <p class="text-gray-600 text-sm font-medium">Score</p>
                        <p class="text-gray-800 text-lg font-semibold">{{ $exam->score ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item p-4 rounded-lg">
                        <p class="text-gray-600 text-sm font-medium">Status</p>
                        <p class="text-gray-800 text-lg font-semibold capitalize">{{ $exam->status ?? 'N/A' }}</p>
                    </div>
                    <div class="info-item p-4 rounded-lg">
                        <p class="text-gray-600 text-sm font-medium">Exam Date</p>
                        <p class="text-gray-800 text-lg font-semibold">{{ $exam->exam_date ?? 'N/A' }}</p>
                    </div>
                </div>
            @endif

            <!-- Decision Section -->
            @if ($exam)
                <div class="mt-8">
                    @if ($stageProgress->status == 'pending')
                        <div class="flex flex-col sm:flex-row gap-4">
                            <form action="{{ route('exam.approve', ['studentID' => $student->id]) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="btn-success text-white w-full py-3 px-6 rounded-lg flex items-center justify-center space-x-2">
                                    <i class="fas fa-check"></i>
                                    <span>Approve</span>
                                </button>
                            </form>
                            <form action="{{ route('exam.reject', ['studentID' => $student->id]) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="btn-danger text-white w-full py-3 px-6 rounded-lg flex items-center justify-center space-x-2">
                                    <i class="fas fa-times"></i>
                                    <span>Reject</span>
                                </button>
                            </form>
                        </div>
                    @elseif($stageProgress->status == 'accepted')
                        <div class="status-accepted p-4 rounded-lg flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            <div>
                                <h3 class="text-gray-800 font-semibold">Approved</h3>
                                <p class="text-gray-600 text-sm">This student has been approved for the next stage.</p>
                            </div>
                        </div>
                    @elseif($stageProgress->status == 'rejected')
                        <div class="status-rejected p-4 rounded-lg flex items-center space-x-3">
                            <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                            <div>
                                <h3 class="text-gray-800 font-semibold">Rejected</h3>
                                <p class="text-gray-600 text-sm">This student has been rejected from the scholarship.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif


        </div>
    </div>

    <script>
        // Simple animation trigger
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>
