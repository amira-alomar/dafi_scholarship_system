<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details</title>
    <link rel="stylesheet" href="{{ asset('css/applicationDetails.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

</head>

<body>
    <div class="layout">
        @include('include.sidebar')
        <div class="container">
            <h2>Application Details</h2>

            <!-- Application Answers -->
            <div class="application-answers">
                <h3>Application Answers</h3>

                @foreach ($application->answers as $answer)
                    <p><strong>{{ $answer->question->question_text }}</strong></p>
                    <p>{{ $answer->answer_text }}</p>
                @endforeach
            </div>

            <!-- Uploaded Documents -->
            <div class="documents">
                <h3>Uploaded Documents</h3>

                @forelse ($requiredDocuments as $requiredDoc)
                    <div style="margin-bottom: 10px;">
                        <strong>{{ $requiredDoc->name }} ({{ $requiredDoc->type }})</strong>
                        <ul>
                            @forelse ($requiredDoc->documents as $doc)
                                <li>
                                    <a href="{{ route('download.document.view', ['path' => basename($doc->document_path)]) }}"
                                        target="_blank">
                                        {{ $doc->document_name }}
                                    </a>
                                    <a href="{{ route('download.document', ['path' => basename($doc->document_path)]) }}"
                                        download style="margin-left: 10px; color: blue; text-decoration: underline;">
                                        [Download]
                                    </a>
                                </li>

                            @empty
                                <li><em>No document uploaded</em></li>
                            @endforelse
                        </ul>
                    </div>
                @empty
                    <p>No required documents found for this application.</p>
                @endforelse
            </div>



            <!-- Admin Actions (Approve / Reject) -->
            <div class="admin-actions">
                @if ($application->applicationForm->status === 'submitted')
                    <form
                        action="{{ route('application.approve', ['scholarshipId' => $scholarshipId, 'applicationID' => $application->applicationID]) }}"
                        method="POST">
                        @csrf
                        <button type="submit">Approve</button>
                    </form>
                    <form
                        action="{{ route('application.reject', ['scholarshipId' => $scholarshipId, 'applicationID' => $application->applicationID]) }}"
                        method="POST">
                        @csrf
                        <button type="submit">Reject</button>
                    </form>
                @elseif ($application->applicationForm->status === 'approved')
                    <button class="approve" disabled>Accepted</button>
                @elseif ($application->applicationForm->status === 'rejected')
                    <button class="reject" disabled>Rejected</button>
                @endif
            </div>


        </div>
</body>

</html>
