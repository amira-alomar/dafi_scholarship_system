<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Interview Scheduling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* exam.css */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            /* adjust to taste */
            overflow-y: auto;
            background: #fff;
            box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
        }

        .main-content {
            margin-left: 250px;
            /* same width as .sidebar */
            min-height: 100vh;
            /* fill full height */
            padding: 2rem;
        }

        .hidden {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    </div>
    <div class="main-content">
        @if (isset($message))
            <div class="bg-light-gray rounded-lg p-8 text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800">Not available</h3>
                <p class="text-gray-600 mt-2">{{ $message }}</p>
            </div>
        @else
            <div class="w-full p-8">
                <h2 class="text-2xl font-bold">Schedule Interview for Scholarship #{{ $scholarshipID }}</h2>

                @if (session('success'))
                    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded" id="msg">
                        {{ session('success') }}
                    </div>
                @endif

                <button id="toggleForm" class="mt-6 btn-primary px-4 py-2">Add Interview</button>

                @if ($eligible->isEmpty())
                    <div class="mt-6 p-4 bg-yellow-50 text-yellow-700 rounded">
                        No eligible candidates (must have passed exam).
                    </div>
                @else
                    <form id="intForm"
                        action="{{ route('interviewResult.store', ['scholarshipID' => $scholarshipID]) }}"
                        method="POST" class="mt-6 hidden">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="block">Student:</label>
                                <select name="student_id" required class="w-full border px-2 py-1">
                                    <option value="">Select…</option>
                                    @foreach ($eligible as $item)
                                        <option value="{{ $item->application->user->id }}">
                                            {{ $item->application->user->id }} — {{ $item->application->user->fname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block">Date:</label>
                                <input type="date" name="interview_date" required class="w-full border px-2 py-1"
                                    value="{{ now()->toDateString() }}" />
                            </div>

                            <div>
                                <label class="block">Status:</label>
                                <select name="status" required class="w-full border px-2 py-1">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="completed">Completed</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="mt-4 btn-primary px-4 py-2">Submit</button>
                    </form>
                @endif

                <table class="mt-8">
                    <thead class="bg-gray-200">
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($interviews as $i)
                            <tr>
                                <td>{{ $i->interviewID }}</td>
                                <td>{{ $i->application->user->fname }} {{ $i->application->user->lname }}</td>
                                <td>{{ $i->interview_date }}</td>
                                <td class="capitalize">{{ $i->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
    </div>

    <script>
        // toggle form & auto-hide success
        document.getElementById('toggleForm').addEventListener('click', () => {
            document.getElementById('intForm').classList.toggle('hidden');
        });
        setTimeout(() => document.getElementById('msg')?.remove(), 5000);
    </script>
</body>

</html>
