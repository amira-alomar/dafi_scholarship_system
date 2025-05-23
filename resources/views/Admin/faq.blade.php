<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add FAQ</title>
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
            background-color: var(--background);
            color: var(--foreground);
            margin: 0;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .card-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }


        h2 {
            margin-bottom: 1rem;
            color: var(--primary);
        }

        label {
            display: block;
            margin-bottom: 0.25rem;
            color: var(--secondary);
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--input);
            border-radius: var(--radius);
            margin-bottom: 1rem;
            background-color: var(--muted);
            color: var(--foreground);
        }

        button {
            background-color: var(--primary);
            color: var(--primary-foreground);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: bold;
        }

        .success {
            background-color: var(--accent);
            color: var(--accent-foreground);
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: var(--radius);
        }
    </style>
</head>

<body>
    <div class="layout">
        @include('include.adminSideBar')
        <div class="card-wrapper">
            <div class="card">
                <h2>Add FAQ</h2>

                @if (session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('faqs.store') }}" method="POST">
                    @csrf
                    <label for="question">Question</label>
                    <input type="text" name="question" id="question" required>

                    <label for="answer">Answer</label>
                    <textarea name="answer" id="answer" rows="4" required></textarea>

                    <button type="submit">Save FAQ</button>
                </form>
            </div>
            </div>
        </div>
</body>

</html>
