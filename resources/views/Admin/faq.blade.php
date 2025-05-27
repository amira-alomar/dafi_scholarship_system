<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add FAQ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8fafc;
            color: #111827;
            line-height: 1.7;
            font-size: 16px;
            letter-spacing: 0.02em;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 3rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
            color: #FFFFFF;
            padding: 3rem 3rem;
            margin: -3rem -3rem 3rem -3rem;
            border-bottom: 4px solid #B91C1C;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: #B91C1C;
            box-shadow: 0 2px 8px rgba(129, 140, 248, 0.3);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 400;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            font-family: 'Georgia', serif;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            letter-spacing: 0.03em;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.8rem;
            color: #111827;
            font-weight: 400;
            margin-bottom: 0.75rem;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            letter-spacing: 0.02em;
        }

        .section-description {
            color: #4b5563;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .add-faq-section {
            margin-bottom: 4rem;
            text-align: center;
        }

        .toggle-form-btn {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            color: #FFFFFF;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
            letter-spacing: 0.02em;
            font-family: 'Segoe UI', sans-serif;
        }

        .toggle-form-btn:hover {
            background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
        }

        .form-container {
            display: none;
            max-width: 700px;
            margin: 2rem auto 0;
            animation: slideDown 0.4s ease-out;
        }

        .form-container.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            background: #FFFFFF;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-top: 4px solid #B91C1C;
        }

        .form-card h2 {
            color: #111827;
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2rem;
            text-align: center;
            font-family: 'Georgia', serif;
            letter-spacing: 0.02em;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 1.05rem;
            letter-spacing: 0.01em;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            line-height: 1.5;
        }

        .form-control:focus {
            outline: none;
            border-color: #B91C1C;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.1);
            background-color: #FFFFFF;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 140px;
            font-family: 'Segoe UI', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            color: #FFFFFF;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
            letter-spacing: 0.02em;
            font-family: 'Segoe UI', sans-serif;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
        }

        .faq-section {
            background: #FFFFFF;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-top: 4px solid #B91C1C;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .faq-title {
            font-size: 1.6rem;
            color: #111827;
            font-weight: 400;
            margin-bottom: 0.5rem;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            letter-spacing: 0.02em;
        }

        .faq-count {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
            font-family: 'Segoe UI', sans-serif;
        }

        .faq-list {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .faq-list::-webkit-scrollbar {
            width: 6px;
        }

        .faq-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .faq-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .faq-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .faq-item {
            margin-bottom: 2rem;
            padding: 2rem;
            background: #fafbfc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            border-left: 5px solid #B91C1C;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            background: #f8fafc;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .faq-question {
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.5;
            font-family: 'Segoe UI', sans-serif;
            letter-spacing: 0.01em;
        }

        .faq-answer {
            color: #4b5563;
            line-height: 1.7;
            font-size: 1rem;
            font-family: 'Segoe UI', sans-serif;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }

        .empty-state-title {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #374151;
            font-family: 'Georgia', serif;
        }

        .empty-state-text {
            font-size: 1rem;
            line-height: 1.6;
        }

        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #FFFFFF;
            padding: 1.25rem 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s ease;
            z-index: 1000;
            max-width: 350px;
            font-family: 'Segoe UI', sans-serif;
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .notification.hide {
            transform: translateY(100px);
            opacity: 0;
        }

        @media (max-width: 1024px) {
            .main-content {
                padding: 2rem;
            }

            .header {
                margin: -2rem -2rem 2rem -2rem;
                padding: 2rem;
            }

            .header h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

            .header {
                margin: -1.5rem -1.5rem 2rem -1.5rem;
                padding: 2rem 1.5rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .form-card,
            .faq-section {
                padding: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem;
            }

            .header {
                margin: -1rem -1rem 1.5rem -1rem;
                padding: 1.5rem 1rem;
            }

            .form-card,
            .faq-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        @include('include.adminSideBar')

        <div class="main-content">

            <div class="page-container">
                <div class="add-faq-section">
                    <div class="section-header">
                        <h2 class="section-title">Frequently Asked Questions</h2>
                        <p class="section-description">Manage and organize educational content to provide comprehensive
                            answers to common inquiries from students and educators.</p>
                    </div>

                    <button type="button" class="toggle-form-btn" onclick="toggleForm()">
                        <span id="btn-text">Add New FAQ Entry</span>
                    </button>

                    <div class="form-container" id="form-container">
                        <div class="form-card">
                            <h2>Create New FAQ Entry</h2>

                            <form action="{{ route('faqs.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input type="text" name="question" id="question" class="form-control" required
                                        placeholder="Enter the frequently asked question...">
                                </div>

                                <div class="form-group">
                                    <label for="answer">Answer</label>
                                    <textarea name="answer" id="answer" class="form-control" required
                                        placeholder="Provide a comprehensive and helpful answer..."></textarea>
                                </div>

                                <button type="submit" class="btn-primary">Save FAQ Entry</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="faq-section">
                    <div class="faq-header">
                        <h3 class="faq-title">Knowledge Base Repository</h3>
                        @if ($faqs->count())
                            <div class="faq-count">{{ $faqs->count() }} {{ $faqs->count() === 1 ? 'Entry' : 'Entries' }}
                                Available</div>
                        @endif
                    </div>

                    @if ($faqs->count())
                        <div class="faq-list">
                            @foreach ($faqs as $faq)
                                <div class="faq-item">
                                    <div class="faq-question">Q: {{ $faq->question }}</div>
                                    <div class="faq-answer">A: {{ $faq->answer }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📚</div>
                            <div class="empty-state-title">No FAQ Entries Available</div>
                            <div class="empty-state-text">Begin building your knowledge base by adding the first FAQ
                                entry using the button above.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="notification" id="notification">
            <strong>Success!</strong> {{ session('success') }}
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notification = document.getElementById('notification');
                if (notification) {
                    setTimeout(() => {
                        notification.classList.add('show');
                    }, 100);

                    setTimeout(() => {
                        notification.classList.add('hide');
                        setTimeout(() => {
                            notification.remove();
                        }, 400);
                    }, 4000);
                }
            });
        </script>
    @endif

    <script>
        function toggleForm() {
            const formContainer = document.getElementById('form-container');
            const btnText = document.getElementById('btn-text');

            if (formContainer.classList.contains('show')) {
                formContainer.classList.remove('show');
                btnText.textContent = 'Add New FAQ Entry';
            } else {
                formContainer.classList.add('show');
                btnText.textContent = 'Hide Form';
                // Scroll to form after a short delay to allow animation
                setTimeout(() => {
                    formContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 200);
            }
        }
    </script>
</body>

</html>
