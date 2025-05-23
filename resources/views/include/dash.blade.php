{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Workflow Dashboard</title> --}}
    <style>
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
            color: #2d3748;
        }

        .dashboard {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        } */

        .workflow-container {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .workflow-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .workflow-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .workflow-title h2 {
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .workflow-title p {
            color: #718096;
            font-size: 1rem;
        }

        .workflow-chain {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 0 2rem;
        }

        .workflow-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 180px;
        }

        .workflow-step:hover {
            transform: translateY(-2px);
        }

        .step-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .step-circle.completed {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .step-circle.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            animation: pulse 2s infinite;
        }

        .step-circle.pending {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            color: #a0aec0;
        }

        @keyframes pulse {
            0% { box-shadow: 0 4px 12px rgba(0,0,0,0.1), 0 0 0 0 rgba(102, 126, 234, 0.7); }
            70% { box-shadow: 0 4px 12px rgba(0,0,0,0.1), 0 0 0 10px rgba(102, 126, 234, 0); }
            100% { box-shadow: 0 4px 12px rgba(0,0,0,0.1), 0 0 0 0 rgba(102, 126, 234, 0); }
        }

        .step-number {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .step-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-label {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .step-helper {
            font-size: 0.85rem;
            color: #718096;
            font-style: italic;
        }

        .workflow-step.active .step-label {
            color: #667eea;
            font-weight: 700;
        }

        .workflow-step.completed .step-label {
            color: #38a169;
        }

        .connection-line {
            position: absolute;
            top: 40px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            z-index: -1;
        }

        .connection-progress {
            height: 100%;
            background: linear-gradient(90deg, #48bb78, #38a169);
            transition: width 0.6s ease;
            border-radius: 1px;
        }

        .management-section {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .management-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .management-title h2 {
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .management-title p {
            color: #718096;
        }

        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .management-card {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            border-radius: 16px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .management-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .management-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.15);
        }

        .management-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 0.9rem;
            color: #718096;
            line-height: 1.5;
        }

        @media (max-width: 1024px) {
            .workflow-chain {
                flex-direction: column;
                gap: 2rem;
                margin: 0;
            }

            .workflow-step {
                flex-direction: row;
                text-align: left;
                max-width: none;
                width: 100%;
                background: #f7fafc;
                padding: 1.5rem;
                border-radius: 16px;
                border: 2px solid transparent;
            }

            .workflow-step.active {
                border-color: #667eea;
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            }

            .workflow-step.completed {
                border-color: #38a169;
                background: linear-gradient(135deg, rgba(72, 187, 120, 0.05), rgba(56, 161, 105, 0.05));
            }

            .step-circle {
                width: 60px;
                height: 60px;
                margin-right: 1.5rem;
                margin-bottom: 0;
            }

            .step-content {
                align-items: flex-start;
                text-align: left;
            }

            .connection-line {
                display: none;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }

            .workflow-container,
            .management-section {
                padding: 2rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .management-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
{{-- </head> --}}
{{-- <body>
    <div class="dashboard">
        <header class="header">
            <h1>Admission Dashboard</h1>
            <p>Guide students through their journey to success</p>
        </header> --}}

        {{-- <div class="workflow-container">
            <div class="workflow-title">
                <h2>Admission Workflow</h2>
                <p>Track and manage each step of the admission process</p>
            </div>

            <div class="workflow-chain">
                <div class="connection-line">
                    <div class="connection-progress" id="progressLine"></div>
                </div>

                <div class="workflow-step completed" data-step="1">
                    <div class="step-circle completed">
                        <div class="step-number">✓</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Form Setup</div>
                        <div class="step-helper">Questions configured ✨</div>
                    </div>
                </div>

                <div class="workflow-step completed" data-step="2">
                    <div class="step-circle completed">
                        <div class="step-number">✓</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Applications</div>
                        <div class="step-helper">Reviews completed 📋</div>
                    </div>
                </div>

                <div class="workflow-step active" data-step="3">
                    <div class="step-circle active">
                        <div class="step-number">3</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Exam</div>
                        <div class="step-helper">Send invitations now →</div>
                    </div>
                </div>

                <div class="workflow-step pending" data-step="4">
                    <div class="step-circle pending">
                        <div class="step-number">4</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Interview</div>
                        <div class="step-helper">Schedule when ready</div>
                    </div>
                </div>

                <div class="workflow-step pending" data-step="5">
                    <div class="step-circle pending">
                        <div class="step-number">5</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Results</div>
                        <div class="step-helper">Publish outcomes</div>
                    </div>
                </div>

                <div class="workflow-step pending" data-step="6">
                    <div class="step-circle pending">
                        <div class="step-number">6</div>
                    </div>
                    <div class="step-content">
                        <div class="step-label">Final Selection</div>
                        <div class="step-helper">Complete the journey</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="management-section">
            <div class="management-title">
                <h2>General Management</h2>
                <p>Platform-wide actions and oversight tools</p>
            </div>

            <div class="management-grid">
                <div class="management-card">
                    <div class="card-icon">👥</div>
                    <div class="card-title">Manage Users</div>
                    <div class="card-description">Add, edit, or remove supervisors, reviewers, and administrators from the platform</div>
                </div>

                <div class="management-card">
                    <div class="card-icon">🎓</div>
                    <div class="card-title">View Accepted Students</div>
                    <div class="card-description">Browse the complete list of students who have been accepted into the program</div>
                </div>

                <div class="management-card">
                    <div class="card-icon">📚</div>
                    <div class="card-title">View Courses</div>
                    <div class="card-description">Manage course offerings, schedules, and curriculum requirements</div>
                </div>

                <div class="management-card">
                    <div class="card-icon">📊</div>
                    <div class="card-title">Analytics & Reports</div>
                    <div class="card-description">Generate insights on application trends, success rates, and process efficiency</div>
                </div>

                <div class="management-card">
                    <div class="card-icon">⚙️</div>
                    <div class="card-title">System Settings</div>
                    <div class="card-description">Configure platform preferences, notifications, and workflow customizations</div>
                </div>

                <div class="management-card">
                    <div class="card-icon">💬</div>
                    <div class="card-title">Communication Hub</div>
                    <div class="card-description">Send announcements, manage templates, and track message delivery</div>
                </div>
            </div>
        </div> --}}
    {{-- </div> --}}

    <script>
        // Initialize progress line
        function updateProgressLine() {
            const completedSteps = document.querySelectorAll('.workflow-step.completed').length;
            const totalSteps = document.querySelectorAll('.workflow-step').length;
            const progressPercentage = (completedSteps / (totalSteps - 1)) * 100;
            
            const progressLine = document.getElementById('progressLine');
            if (progressLine) {
                progressLine.style.width = progressPercentage + '%';
            }
        }

        // Add click handlers for workflow steps
        document.querySelectorAll('.workflow-step').forEach(step => {
            step.addEventListener('click', function() {
                console.log('Clicked step:', this.dataset.step);
                // Add navigation logic here
            });
        });

        // Add click handlers for management cards
        document.querySelectorAll('.management-card').forEach(card => {
            card.addEventListener('click', function() {
                console.log('Clicked management card:', this.querySelector('.card-title').textContent);
                // Add navigation logic here
            });
        });

        // Initialize progress line on load
        updateProgressLine();

        // Add some interactive feedback
        document.querySelectorAll('.workflow-step, .management-card').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
{{-- </body>
</html> --}}