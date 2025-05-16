<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #16a3b8;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body class="bg-[#f5f5f5] font-sans text-[#0f172a]">
    <!-- Navigation -->
    <nav class="bg-[#313e53] text-[#f8fafc] px-6 py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-semibold">Scholarship Management</h1>
            {{-- <a href="{{ route('supervisor.manageScholarship', ['scholarshipID' => $scholarship->scholarshipID]) }}"  class="bg-[#e05252] hover:bg-[#ef4444] text-white px-4 py-2 rounded-md transition-colors duration-200">
                Back to Dashboard
            </a> --}}
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#0f172a]">Accepted Students</h2>
                <div class="bg-[#16a3b8] text-white px-4 py-2 rounded-md">
                    Total: {{ count($applications) }}
                </div>
            </div>

            @if(count($applications) > 0)
                <div class="space-y-4">
                    @foreach ($applications as $application)
                    <div class="border border-[#e2e8f0] rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <h3 class="text-lg font-semibold text-[#0f172a]">
                                    {{ $application->user->fname." ".$application->user->fname ?? 'N/A'}}
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-[#64748b]">Major</p>
                                        <p class="font-medium">{{ $application->user->studentInfo->major ?? 'N/A'}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#64748b]">Year</p>
                                        <p class="font-medium">{{ $application->user->studentInfo->year ?? 'N/A'}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#64748b]">GPA</p>
                                        <p class="font-medium">{{ $application->user->studentInfo->gpa ?? 'N/A'}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-[#64748b]">Trainings</p>
                                        <p class="font-medium">{{ $application->user->studentInfo->number_of_training ?? 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-[#64748b]">Volunteering Hours</p>
                                    <p class="font-medium">{{ $application->user->studentInfo->number_of_volunteering ?? 'N/A'}} hours</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="bg-[#f1f5f9] text-[#16a3b8] px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $application->scholarship->name }}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-[#64748b]">No accepted students found</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>