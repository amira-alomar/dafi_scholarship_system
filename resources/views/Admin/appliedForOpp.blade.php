<!DOCTYPE html>
<html lang="en" class="bg-[--background] text-[--foreground]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Applications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --background: #f5f5f5;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --primary: #e05252;
            --primary-foreground: #f8fafc;
            --secondary: #313e53;
            --secondary-foreground: #f8fafc;
            --muted: #f1f5f9;
            --muted-foreground: #64748b;
            --accent: #16a3b8;
            --accent-foreground: #f8fafc;
            --destructive: #ef4444;
            --destructive-foreground: #f8fafc;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --radius: 0.5rem;
            --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            margin: 0px;
            padding: 0px;
        }

        .layout {
            display: flex;
            flex: 1;
        }

        .main {
            width: 100%;
        }
    </style>
</head>

<body class="bg-[--background]  min-h-screen">
    <div class="layout">
        @include('include.adminSideBar')
        <div class="main max-w-5xl mx-auto">
            <div class="bg-[--card] p-6 rounded-[--radius] shadow-md">
                <h2 class="text-2xl font-semibold text-[--foreground] mb-6 border-b border-[--border] pb-2">User
                    Applications
                </h2>

                @php
                    $message = trim(session('success'));
                @endphp

                @if (!empty($message))
                    @php
                        $isRejected = str_contains(strtolower($message), 'rejected');
                    @endphp

                    <div id="success-alert"
                        class="{{ $isRejected ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} p-4 rounded mb-4">
                        {{ $message }}
                    </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-[--border] text-sm">
                            <thead class="bg-[--muted] text-[--muted-foreground]">
                                <tr>
                                    <th class="p-3 text-left border-b border-[--border]">User</th>
                                    <th class="p-3 text-left border-b border-[--border]">Opportunity</th>
                                    <th class="p-3 text-left border-b border-[--border]"> Application Date</th>
                                    <th class="p-3 text-left border-b border-[--border]">Status</th>
                                    <th class="p-3 text-left border-b border-[--border]">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $app)
                                    <tr class="hover:bg-[--muted] transition">
                                        <td class="p-3 border-b border-[--border]">
                                            {{ $app->user ? $app->user->fname . ' ' . $app->user->lname : 'Unknown User' }}
                                        </td>
                                        <td class="p-3 border-b border-[--border]">
                                            {{ $app->opportunity->title ?? 'Unknown Opportunity' }}
                                        </td>
                                        <td class="p-3 border-b border-[--border]">
                                            {{ $app->application_date ?? 'N/A' }}
                                        </td>
                                        <td class="p-3 border-b border-[--border] font-medium capitalize">
                                            <span
                                                class="@if ($app->status == 'pending') text-[--accent] @elseif($app->status == 'accepted') text-green-600 @else text-[--destructive] @endif">
                                                {{ $app->status }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b border-[--border]">
                                            @if ($app->status == 'pending')
                                                <div class="flex space-x-2">
                                                    <form
                                                        action="{{ route('applications.accept', [$app->idUser, $app->idOpportunity]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="bg-[--primary] text-[--primary-foreground] px-3 py-1 rounded hover:bg-red-600 transition">Accept</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('applications.reject', [$app->idUser, $app->idOpportunity]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="bg-[--destructive] text-[--destructive-foreground] px-3 py-1 rounded hover:bg-red-700 transition">Reject</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-[--muted-foreground] italic">No Action</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($applications->isEmpty())
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-gray-500">
                                            No applications found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>

            </div>
        </div>
    </div>
</body>

<script>
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>


</html>
