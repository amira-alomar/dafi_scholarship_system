<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Opportunities Manager</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/jobAdmin.css') }}" />
</head>

<body>
    <!-- Header -->
    <div class="layout">
        @include('include.adminSideBar')
        <div class="container">
            <h2>Manage Jobs</h2>
            <button class="btn-primary" onclick="openAddModal()">+ Add Job</button>
            <!-- Main Content -->
            <main class="main">
                <div class="container">
                    <!-- Jobs Grid -->
                    <div class="jobs-grid">
                        @foreach ($jobs as $job)
                            <a href="#" class="job-card">
                                <div class="job-card-header">
                                    <h2 class="job-title">{{ $job->title }}</h2>
                                    <span class="deadline-badge">
                                        {{ \Carbon\Carbon::parse($job->application_deadline)->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="job-company">
                                    <i class="ri-building-line"></i>
                                    <span>{{ $job->company_name }}</span>
                                </div>
                                <div class="job-location">
                                    <i class="ri-map-pin-line"></i>
                                    <span>{{ $job->location }}</span>
                                </div>
                                <div class="job-description">
                                    <p>{{ $job->details }}</p>
                                </div>
                                <div class="job-apply-method">
                                    <i class="ri-mail-send-line"></i>
                                    <span>{{ $job->application_method }}</span>
                                </div>
                                <div class="job-footer">
                                    <div class="job-deadline">
                                        <i class="ri-calendar-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($job->posting_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="job-actions">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn-secondary" onclick="openEditModal(this)"
                                            data-job-id="{{ $job->jobID }}" data-job-title="{{ $job->title }}"
                                            data-job-company="{{ $job->company_name }}"
                                            data-job-location="{{ $job->location }}"
                                            data-job-details="{{ $job->details }}"
                                            data-job-method="{{ $job->application_method }}"
                                            data-job-deadline="{{ $job->application_deadline }}"
                                            data-update-url="{{ route('admin.jobs.update', $job->jobID) }}">
                                            <i class="ri-edit-line"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn-danger" onclick="openDeleteModal(this)"
                                            data-delete-url="{{ route('admin.jobs.destroy', $job->jobID) }}">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </button>

                                    </div>

                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </main>
            <!-- Edit Modal -->
            <div id="editModal" class="modal hidden">
                <div class="modal-content">
                    <h3>Edit Job</h3>
                    <form method="POST" action="" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="text" name="title" placeholder="Job Title" required>
                        <input type="text" name="company_name" placeholder="Company Name" required>
                        <input type="text" name="location" placeholder="Location" required>
                        <textarea name="details" placeholder="Job Details" required></textarea>
                        <input type="text" name="application_method" placeholder="Application Method" required>
                        <input type="date" name="application_deadline" required>
                        <button type="submit" class="btn-secondary">Save</button>
                        <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div id="deleteModal" class="modal hidden">
                <div class="modal-content">
                    <h3>Are you sure you want to delete this job?</h3>
                    <form method="POST" action="" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Yes, Delete</button>
                        <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Add Modal -->
            <div id="addModal" class="modal hidden">
                <div class="modal-content">
                    <h3>Add Job</h3>
                    <form method="POST" action="{{ route('admin.jobs.store') }}">
                        @csrf
                        <input type="text" name="title" placeholder="Job Title" required>
                        <input type="text" name="company_name" placeholder="Company Name" required>
                        <input type="text" name="location" placeholder="Location" required>
                        <textarea name="details" placeholder="Job Details" required></textarea>
                        <input type="text" name="application_method" placeholder="Application Method" required>
                        <input type="date" name="application_deadline" required>
                        <button type="submit" class="btn-primary">Add</button>
                        <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Cancel</button>
                    </form>
                </div>
            </div>

        </div>

        <script>
            function openEditModal(btn) {
                // إظهر المودال
                const modal = document.getElementById('editModal');
                modal.classList.remove('hidden');

                // استخرج الداتا من الزر
                const {
                    jobId,
                    jobTitle,
                    jobCompany,
                    jobLocation,
                    jobDetails,
                    jobMethod,
                    jobDeadline,
                    updateUrl
                } = btn.dataset;

                // عيّن action للفورم
                const form = document.getElementById('editForm');
                form.action = updateUrl;

                // عبّي الحقول
                form.elements['title'].value = jobTitle;
                form.elements['company_name'].value = jobCompany;
                form.elements['location'].value = jobLocation;
                form.elements['details'].value = jobDetails;
                form.elements['application_method'].value = jobMethod;
                form.elements['application_deadline'].value = jobDeadline;
            }

            function openDeleteModal(btn) {
                // إظهر المودال
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');

                // عيّن action للفورم
                const form = document.getElementById('deleteForm');
                form.action = btn.dataset.deleteUrl;
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function openAddModal() {
                const modal = document.getElementById('addModal');
                modal.classList.remove('hidden');
            }
        </script>


</body>

</html>
