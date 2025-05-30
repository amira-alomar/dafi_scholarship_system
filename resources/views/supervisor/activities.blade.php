{{-- resources/views/student/activities.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Activities</title>
    <style>
        body {
            background-color: #f9fafb;
            color: #1f2937;
            font-family: sans-serif;
        }

        .container {
            width: 90%;
            margin: 2rem auto;
        }

        h2 {
            color: #818cf8;
            margin-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        th {
            background: #374151;
            color: #e5e7eb;
            padding: .75rem;
            text-align: left;
        }

        td {
            border: 1px solid #e5e7eb;
            padding: .5rem .75rem;
        }

        .student-box {
            background: #fff;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 0 8px #ccc;
            margin-bottom: 3rem;
        }
        .now {
            color: #374151;
            font-size: 1.5rem;
            padding-left: 50px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
     @include('include.sidebar', ['scholarshipID' => $scholarshipID])
    <div class="container">
        <h1 class="now">All Activities (Training & Volunteering)</h1>
        
        @foreach ($students as $student)
            <div class="student-box">
                <h2>Student: {{ $student->user->fname ?? 'Unknown Name' }}</h2>

                {{-- Trainings Table --}}
                <h3>Trainings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Certificate</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->trainings as $training)
                            <tr>
                                <td>{{ $training->name }}</td>
                                <td>
                                    @if ($training->certificate)
                                        <a href="{{ asset('storage/certificates/' . $training->certificate) }}"
                                            target="_blank" style="color: #818cf8; text-decoration: underline;">
                                            View Certificate
                                        </a>
                                    @else
                                        Not available
                                    @endif
                                </td>
                                <td>{{ $training->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No trainings available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Volunteering Table --}}
                <h3>Volunteering Activities</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Hours</th>
                            <th>Certificate</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->volunteerings as $vol)
                            <tr>
                                <td>{{ $vol->name }}</td>
                                <td>{{ $vol->total_hours }}</td>
                               <td> @if ($vol->certificate)
                                        <a href="{{ asset('storage/certificates/' . $vol->certificate) }}"
                                            target="_blank" style="color: #818cf8; text-decoration: underline;">
                                            View Certificate
                                        </a>
                                    @else
                                        Not available
                                    @endif</td>
                                <td>{{ $vol->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No volunteering activities available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</body>

</html>
