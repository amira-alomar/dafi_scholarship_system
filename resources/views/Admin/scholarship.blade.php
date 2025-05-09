<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Scholarships</title>
    <link rel="stylesheet" href="{{ asset('css/scholarshipAdmin.css') }}">

</head>

<body>
    <div class="layout">
        @include('include.adminSideBar')
        <div class="container">
            <h2>Manage Scholarships</h2>


            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Add Scholarship Toggle -->
            <button id="toggle-add-btn" class="submit-btn" style="margin-bottom:20px;">
                ➕ Add Scholarship
            </button>

            <!-- Add Scholarship Form -->
            <div class="add-scholarship" id="add-scholarship-form">
                <h3>Add New Scholarship</h3>
                <form method="POST" action="{{ route('scholarships.store') }}">
                    @csrf
                    <!-- Add Scholarship Form -->

                    <div class="form-group">
                        <label for="scholarship-name">Name</label>
                        <input type="text" name="name" id="scholarship-name" />
                        @error('name')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="funding-org">Funding Organization</label>
                        <input type="text" name="funding_organization" id="funding-org" />
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" name="start_date" id="start-date" />
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <input type="date" name="end_date" id="end-date" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="target_group">Target Group</label>
                        <select name="target_group" id="target_group">
                            <option value="Bachelor">Bachelor</option>
                            <option value="Master">Master</option>
                            <option value="PHD">PHD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idUni">University</label>
                        <select name="idUni" id="idUni" required>
                            <option value="">-- Select University --</option>
                            @foreach (\App\Models\University::all() as $uni)
                                <option value="{{ $uni->universityID }}"
                                    {{ old('idUni') == $uni->universityID ? 'selected' : '' }}>
                                    {{ $uni->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('idUni')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn">Add Scholarship</button>
                </form>
            </div>

            @foreach ($scholarships as $scholarship)
                <div class="scholarship-card "id="scholarship-{{ $scholarship->scholarshipID }}">
                    <div class="scholarship-header">
                        <h3>Scholarship Name: {{ $scholarship->name }}</h3>
                        <div class="button-group">
                            <!-- Edit opens modal -->
                            <button class="edit-btn open-modal-btn" data-id="{{ $scholarship->scholarshipID }}">
                                Edit
                            </button>
                            <form
                                action="{{ route('scholarships.destroy', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete it?')">Delete</button>
                            </form>
                        </div>
                    </div>

                    <div class="scholarship-details">
                        <p><strong>Funding Organization:</strong> {{ $scholarship->funding_organization }}</p>
                        <p><strong>Start Date:</strong> {{ $scholarship->start_date }}</p>
                        <p><strong>End Date:</strong> {{ $scholarship->end_date }}</p>
                        <p><strong>Description:</strong> {{ $scholarship->description }}</p>
                    </div>

                    <!-- View Details Toggle -->
                    <button class="toggle-details-btn">View Details</button>

                    <!-- Hidden Sections -->
                    <div class="details-sections">
                        <!-- Criteria -->
                        <div class="relationship-section">
                            <h4>Criteria</h4>
                            <ul class="relationship-list">
                                @foreach ($scholarship->criteria as $item)
                                    <li>
                                        {{ $item->criteria_text }}
                                        <span>
                                            <form
                                                action="{{ route('criteria.delete', $item->criteriaID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="rel-delete-btn">Delete</button>
                                            </form>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="add-relationship">
                                <form
                                    action="{{ route('criteria.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                    method="POST">
                                    @csrf
                                    <input type="text" name="text" placeholder="Add new criteria" />
                                    <button>Add</button>
                                </form>
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div class="relationship-section">
                            <h4>Benefits</h4>
                            <ul class="relationship-list">
                                @foreach ($scholarship->benefits as $benefit)
                                    <li>
                                        {{ $benefit->Benefit_text }}
                                        <span>
                                            <form
                                                action="{{ route('benefit.delete', $benefit->benefitID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="rel-delete-btn">Delete</button>
                                            </form>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="add-relationship">
                                <form
                                    action="{{ route('benefit.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                    method="POST">
                                    @csrf
                                    <input type="text" name="text" placeholder="Add new benefit" />
                                    <button>Add</button>
                                </form>
                            </div>
                        </div>
                        <!-- Application Stages -->
                        <div class="relationship-section">
                            <h4>Application Stages</h4>
                            <ul class="relationship-list">
                                @foreach ($scholarship->applicationStages as $stage)
                                    <li>
                                        <strong>{{ $stage->order }}. {{ $stage->name }}</strong><br>
                                        {{ $stage->description }}<br>
                                        {{ $stage->start_date }} - {{ $stage->end_date ?? 'No End Date' }}
                                        <span>
                                            <form action="{{ route('stage.delete', $stage->applicationStageID) }}"
                                                method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="rel-delete-btn">Delete</button>
                                            </form>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- Add new stage -->
                            <div class="add-relationship">
                                <form action="{{ route('stage.add', $scholarship->scholarshipID) }}" method="POST">
                                    @csrf
                                    <input type="text" name="name" placeholder="Stage name" required />
                                    <input type="text" name="description" placeholder="Description" required />
                                    <input type="number" name="order" placeholder="Order" required />
                                    <input type="date" name="start_date" required />
                                    <input type="date" name="end_date" />
                                    <button>Add</button>
                                </form>
                            </div>
                        </div>
                        <!-- Partners -->
                        <div class="relationship-section">
                            <h4>Partners</h4>
                            <ul class="relationship-list">
                                @foreach ($scholarship->partners as $partner)
                                    <li>
                                        {{ $partner->Partner_name }}
                                        <span>
                                            <form
                                                action="{{ route('partner.delete', [$scholarship->scholarshipID, $partner->partnerID]) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                                method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="rel-delete-btn">Delete</button>
                                            </form>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="add-relationship">
                                <form
                                    action="{{ route('partner.add', $scholarship->scholarshipID) }}#scholarship-{{ $scholarship->scholarshipID }}"
                                    method="POST">
                                    @csrf
                                    <select name="partner_id" required>
                                        <option value="">-- Select a Partner --</option>
                                        @foreach ($allPartners as $p)
                                            <option value="{{ $p->partnerID }}">{{ $p->Partner_name }}</option>
                                        @endforeach
                                    </select>
                                    <button>Add</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for this scholarship -->
                    <div class="modal-backdrop" id="modal-{{ $scholarship->scholarshipID }}">
                        <div class="modal-box">
                            <button class="modal-close" data-id="{{ $scholarship->scholarshipID }}">&times;</button>
                            <h3>Edit Scholarship</h3>
                            <form method="POST"
                                action="{{ route('scholarships.update', $scholarship->scholarshipID) }}#modal-{{ $scholarship->scholarshipID }}">
                                @csrf @method('PUT')
                                <div class="form-group">
                                    <label for="name-{{ $scholarship->scholarshipID }}">Name</label>
                                    <input type="text" id="name-{{ $scholarship->scholarshipID }}" name="name"
                                        value="{{ $scholarship->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="funding-{{ $scholarship->scholarshipID }}">Funding
                                        Organization</label>
                                    <input type="text" id="funding-{{ $scholarship->scholarshipID }}"
                                        name="funding_organization" value="{{ $scholarship->funding_organization }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="start-{{ $scholarship->scholarshipID }}">Start Date</label>
                                    <input type="date" id="start-{{ $scholarship->scholarshipID }}"
                                        name="start_date" value="{{ $scholarship->start_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="end-{{ $scholarship->scholarshipID }}">End Date</label>
                                    <input type="date" id="end-{{ $scholarship->scholarshipID }}" name="end_date"
                                        value="{{ $scholarship->end_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="desc-{{ $scholarship->scholarshipID }}">Description</label>
                                    <textarea id="desc-{{ $scholarship->scholarshipID }}" name="description" rows="3">{{ $scholarship->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status-{{ $scholarship->scholarshipID }}">Status</label>
                                    <select id="status-{{ $scholarship->scholarshipID }}" name="status">
                                        <option value="open" {{ $scholarship->status == 'open' ? 'selected' : '' }}>
                                            Open</option>
                                        <option value="closed" {{ $scholarship->status == 'closed' ? 'selected' : '' }}>
                                            Closed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="target-{{ $scholarship->scholarshipID }}">Target Group</label>
                                    <select id="target-{{ $scholarship->scholarshipID }}" name="target_group"
                                        required>
                                        <option value="Bachelor"
                                            {{ $scholarship->target_group == 'Bachelor' ? 'selected' : '' }}>Bachelor
                                        </option>
                                        <option value="Master"
                                            {{ $scholarship->target_group == 'Master' ? 'selected' : '' }}>Master</option>
                                        <option value="PHD"
                                            {{ $scholarship->target_group == 'PHD' ? 'selected' : '' }}>PHD</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uni-{{ $scholarship->scholarshipID }}">University</label>
                                    <select id="uni-{{ $scholarship->scholarshipID }}" name="idUni" required>
                                        @foreach (\App\Models\University::all() as $uni)
                                            <option value="{{ $uni->universityID }}"
                                                {{ $scholarship->idUni == $uni->universityID ? 'selected' : '' }}>
                                                {{ $uni->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="submit-btn">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        // Toggle Add Scholarship Form
        document.getElementById('toggle-add-btn').addEventListener('click', function() {
            const form = document.getElementById('add-scholarship-form');
            if (form.style.display === 'block') {
                form.style.display = 'none';
                this.textContent = '➕ Add Scholarship';
            } else {
                form.style.display = 'block';
                this.textContent = '❌ Cancel';
            }
        });

        // Toggle each card's details
        document.querySelectorAll('.scholarship-card').forEach(card => {
            const btn = card.querySelector('.toggle-details-btn');
            const sections = card.querySelector('.details-sections');
            btn.addEventListener('click', () => {
                if (sections.style.display === 'block') {
                    sections.style.display = 'none';
                    btn.textContent = 'View Details';
                } else {
                    sections.style.display = 'block';
                    btn.textContent = 'Hide Details';
                }
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            const hash = location.hash; // e.g. "#scholarship-5"
            if (hash) {
                const card = document.querySelector(hash);
                if (card) {
                    const btn = card.querySelector('.toggle-details-btn');
                    const sections = card.querySelector('.details-sections');
                    sections.style.display = 'block';
                    btn.textContent = 'Hide Details';
                    // شلنا السطر:
                    // card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
        // Open & Close modals
        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                document.getElementById(`modal-${id}`).style.display = 'flex';
            });
        });
        document.querySelectorAll('.modal-close').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                document.getElementById(`modal-${id}`).style.display = 'none';
            });
        });
        // also click outside modal-box closes it
        document.querySelectorAll('.modal-backdrop').forEach(back => {
            back.addEventListener('click', e => {
                if (e.target === back) back.style.display = 'none';
            });
        });
        // Open & Close modals
        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                document.getElementById(`modal-${id}`).style.display = 'flex';
            });
        });
    </script>
    <script>
      setTimeout(() => {
          const alert = document.querySelector('.alert');
          if (alert) {
              alert.style.transition = 'opacity 0.5s ease';
              alert.style.opacity = '0';
              setTimeout(() => alert.remove(), 500); // remove after fade
          }
      }, 2000);
  </script>
  
</body>

</html>
