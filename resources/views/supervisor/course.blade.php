<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .course-item {
            transition: all 0.2s ease;
        }
        .course-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .drop-btn {
            transition: all 0.2s ease;
        }
        .drop-btn:hover {
            background-color: #dc2626 !important;
        }
    </style>
</head>
<body  class="flex h-screen overflow-hidden bg-[#f5f5f5] font-sans">
    <!-- Navigation Bar -->
   @include('include.sidebar', ['scholarshipID' => $scholarshipID])

   <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e2e8f0]">
                <h2 class="text-2xl font-bold text-[#0f172a]">Manage Student Courses</h2>
            </div>

            <div class="divide-y divide-[#e2e8f0]">
                @foreach($applications as $app)
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-[#0f172a]">
                            {{ $app->user->fname.' '.$app->user->lname }}
                        </h3>
                    </div>

                    @if($app->user->courses->isEmpty())
                        <div class="bg-[#f1f5f9] rounded-lg p-4 text-center text-[#64748b]">
                            Not registered in any course yet.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($app->user->courses as $course)
                            <div class="course-item bg-white border border-[#e2e8f0] rounded-lg p-4 flex justify-between items-start">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 w-full">
                                    <div>
                                        <p class="text-xs font-medium text-[#64748b]">Code</p>
                                        <p class="font-medium">{{ $course->code }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-[#64748b]">Course</p>
                                        <p class="font-medium">{{ $course->course_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-[#64748b]">Details</p>
                                        <p class="text-sm">
                                            Grade: {{ $course->grade ?? 'N/A' }}<br>
                                            Semester: {{ $course->semester ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-[#64748b]">Instructor</p>
                                        <p class="font-medium">{{ $course->instructor ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-[#64748b]">Credits</p>
                                        <p class="font-medium">{{ $course->credits ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('courses.destroy', $course->courseID) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="drop-btn bg-[#ef4444] hover:bg-[#dc2626] text-white px-3 py-1 rounded-md text-sm font-medium">
                                        Drop
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>