<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Academic Information</title>
  <link rel="stylesheet" href="{{ asset('css/acadmic.css') }}">
  <script defer src="{{ asset('js/acadmic.js') }}"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Page title -->
    <h1 class="page-title">Academic Information</h1>
    
    <div class="dashboard-grid">
      <!-- Left column - Personal & Academic Details -->
      <div class="content-column">
        
        <!-- Personal & Academic Details Card -->
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-user primary-icon"></i>
                Personal & Academic Details
              </h2>
            </div>
            
            <div class="two-column-grid">
              <div class="personal-details">
                <div class="detail-item">
                  <div class="detail-icon">
                    <i class="bx bx-user gray-icon"></i>
                  </div>
                  <div>
                    <div class="detail-label">Name</div>
                    <div class="detail-value"><span>{{ optional(auth()->user())->fname ?? 'Guest' }}</span></div>
                  </div>
                </div>
                
                <div class="detail-item">
                  <div class="detail-icon">
                    <i class="bx bx-envelope gray-icon"></i>
                  </div>
                  <div>
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><span>{{ optional(auth()->user())->email ?? 'Not Available' }}</span></div>
                  </div>
                </div>
                
                <div class="detail-item">
                  <div class="detail-icon">
                    <i class="bx bx-building gray-icon"></i>
                  </div>
                  <div>
                    <div class="detail-label">University</div>
                    <div class="detail-value"><span>{{ $university ?? 'Not Set' }}</span></div>
                  </div>
                </div>
              </div>
              
              <div class="academic-details">
                <div class="detail-item">
                  <div class="detail-icon">
                    <i class="bx bx-code gray-icon"></i>
                  </div>
                  <div>
                    <div class="detail-label">Major</div>
                    <div class="detail-value"><span>{{ $major ?? 'Not Set' }}</span></div>
                  </div>
                </div>
                
                <div class="detail-item">
                  <div class="detail-icon">
                    <i class="bx bx-star gray-icon"></i>
                  </div>
                  <div>
                    <div class="detail-label">GPA</div>
                    <div class="detail-value"><span>{{ $gpa ?? 'Not Set' }}</span> / 4.00</div>
                  </div>
                </div>
                
                <div class="gpa-container">
                  <div class="detail-label">GPA Progress</div>
                  <div class="gpa-chart">
                    <div class="gpa-progress" style="width: {{ ($gpa ?? 0) * 25 }}%"></div>
                  </div>
                  <div class="gpa-scale">
                    <span>0.00</span>
                    <span>1.00</span>
                    <span>2.00</span>
                    <span>3.00</span>
                    <span>4.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Academic Goals Card -->
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-flag primary-icon"></i>
                Academic Goals
              </h2>
              <button class="icon-button" onclick="document.getElementById('goal-form').style.display='block'">
                <i class="bx bx-plus"></i>
              </button>
            </div>
            <!-- inline Form -->
<div id="goal-form" style="display:none; margin-top: 1rem;" >
  <form method="POST" action="{{ route('goals.store') }} " style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
    @csrf
    <input type="text" name="title" placeholder="Goal title" required class="form-input">
    <input type="date" name="due_date" required class="form-input">
    <textarea name="description" placeholder="Description" class="form-input" style="resize: none;"></textarea>
    <button type="submit" class="primary-button">Add Goal</button>
  </form>
</div>

            
            <div class="goals-container">
                <!-- Goals List -->
               @foreach($goals as $index => $goal)
              
              <div class="goal-card">
                <div class="goal-header">
                  <div class="goal-title">{{ $goal->title }}</div>
                  <div class="goal-date">Due: {{ $goal->due_date->format('M d, Y') }}</div>
                 
                </div>
                <div class="goal-description">{{ $goal->description }}</div>
                <div class="completion-bar">
                  <div class="completion-progress" style="width: {{ $goal->progress }}%; background-color: {{ $goal->completion_color }};"></div>
                </div>
                <div class="goal-stats">
                  <div class="goal-progress">Progress:{{ $goal->progress }}%</div>
                  <div class="days-remaining">{{ $goal->days_remaining }} days remaining</div>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 10px;" >
                  <!-- Mark as Completed -->
    <form method="POST" action="{{ route('goals.update', $goal->goalID) }}">
      @csrf
      @method('PUT')
      <input type="range" name="progress" min="0" max="100" value="{{ $goal->progress }}">
      <button type="submit" class="primary-button" >Update Progress</button>
    </form>

    <!-- Delete Goal -->
    <form method="POST" action="{{ route('goals.destroy', $goal->goalID) }}">
      @csrf
      @method('DELETE')
      <button type="submit" class="primary-button">Delete</button>
    </form>
  </div>
  </div>
  
  @endforeach
</div>            
</div>
</div>    
        <!-- Training Form Card -->
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-spreadsheet primary-icon"></i>
                Training
              </h2>
            </div>
            
            <form class="training-form"  action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
              <div class="form-group">
                <label for="training-name" class="form-label">Training Name</label>
                <input 
                  id="training-name" 
                  type="text" 
                  class="form-input" 
                  placeholder="Enter training name"
                  name="name" 
                >
              </div>
              
              <div class="form-group">
                <label for="training-file" class="form-label">Upload Certificate</label>
                <div class="file-upload-container">
                  <label for="training-file" class="file-upload-area">
                    <div class="upload-content">
                      <i class="bx bx-upload upload-icon"></i>
                      <p class="upload-text">
                        <span class="upload-bold">Click to upload</span> or drag and drop
                      </p>
                      <p class="upload-formats">PDF, PNG, JPG or JPEG (MAX. 2MB)</p>
                    </div>
                    <input 
                      id="training-file" 
                      type="file" 
                      class="hidden-input" 
                      accept=".pdf,.png,.jpg,.jpeg"
                      name="certificate" 
                    >
                  </label>
                </div>
              </div>
              
              <div class="form-actions">
                <button type="submit" class="primary-button">
                  <i class="bx bx-plus"></i>
                  Add Training
                </button>
              </div>
            </form>
            
       <div id="preview-image"></div>
          </div>
        </div>
      </div>
      
      <!-- Right column - Certificates, Progress, Timeline -->
      <div class="sidebar-column">
        <!-- Certificates Card -->
        
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-award primary-icon"></i>
                My Training Certificates
              </h2>
            </div>
            
            <div class="certificates-container">
            @foreach($trainings as $index => $training)
        <div class="certificate-card {{ $index >= 3 ? 'hidden-certificate' : '' }}">
                <div class="certificate-content">
                  <div class="certificate-icon">
                    <i class="bx bx-award accent-icon"></i>
                  </div>
                  <div class="certificate-details">
                    <h3 class="certificate-title">{{ $training->name }} </h3>
                    <p class="certificate-date">Added: {{ $training->created_at->format('M d, Y') }}</p>
                  </div>
                  
                  <a href="{{ asset('storage/'.$training->certificate) }}" target="_blank" class="certificate-link">View Certificate</a>
                </div>
              </div>
              @endforeach
              
              <div class="view-all">
                <a href="#" id="toggleCertificates"  class="link-button">View All Certificates</a>
              </div>
            </div>
          </div>
        </div>
           <!-- Volunteering Form Card -->
           <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-spreadsheet primary-icon"></i>
                Volunteering
              </h2>
            </div>
            
            <form class="training-form"  action="{{ route('volunteerings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
              <div class="form-group">
                <label for="training-name" class="form-label">Volunteering Name</label>
                <input 
                  id="training-name" 
                  type="text" 
                  class="form-input" 
                  placeholder="Enter volunteering name"
                  name="name" 
                >
              </div>
              <div class="form-group">
                <label for="training-name" class="form-label">Volunteering hours </label>
                <input 
                  id="training-name" 
                  type="text" 
                  class="form-input" 
                  placeholder="Enter volunteering hours"
                  name="name" 
                >
              </div>
              
              <div class="form-group">
                <label for="training-file" class="form-label">Upload Certificate</label>
                <div class="file-upload-container">
                  <label for="training-file" class="file-upload-area">
                    <div class="upload-content">
                      <i class="bx bx-upload upload-icon"></i>
                      <p class="upload-text">
                        <span class="upload-bold">Click to upload</span> or drag and drop
                      </p>
                      <p class="upload-formats">PDF, PNG, JPG or JPEG (MAX. 2MB)</p>
                    </div>
                    <input 
                      id="training-file" 
                      type="file" 
                      class="hidden-input" 
                      accept=".pdf,.png,.jpg,.jpeg"
                      name="certificate" 
                    >
                  </label>
                </div>
              </div>
              
              <div class="form-actions">
                <button type="submit" class="primary-button">
                  <i class="bx bx-plus"></i>
                  Add Volunteering
                </button>
              </div>
            </form>
            
       <div id="preview-image"></div>
          </div>
        </div>
      </div>
      
      <!-- Right column - Certificates, Progress, Timeline -->
      <div class="sidebar-column">
        <!-- Certificates Card -->
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-award primary-icon"></i>
                My  Volunteering Certificates
              </h2>
              <button class="icon-button">
                <i class="bx bx-dots-horizontal-rounded"></i>
              </button>
            </div>
            
            <div class="certificates-container">
            @foreach($volunteerings as $index => $volunteering)
            <div class="certificate-card {{ $index >= 3 ? 'hidden-certificate' : '' }}">
                <div class="certificate-content">
                  <div class="certificate-icon">
                    <i class="bx bx-award accent-icon"></i>
                  </div>
                  <div class="certificate-details">
                    <h3 class="certificate-title">{{ $volunteering->name }}</h3>
                    <p class="certificate-date">Added: {{ $volunteering->created_at->format('M d, Y') }}</p>
                  </div>
                  <a href="{{ asset('storage/'.$volunteering->certificate) }}" target="_blank" class="certificate-link">View Certificate</a>
                </div>
              </div>
              @endforeach
              
              <div class="view-all">
                <a href="#" id="toggleCertificates" class="link-button">View All Certificates</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Upcoming Events Card -->
        <div class="card scale-hover">
          <div class="card-content">
            <div class="card-header">
              <h2 class="card-title">
                <i class="bx bx-calendar primary-icon"></i>
                Upcoming Events
              </h2>
            </div>
            
            <div class="events-container">
              <div class="event-card event-exam">
                <div class="event-title">Final Exam: Database Systems</div>
                <div class="event-datetime">May 28, 2023 • 10:00 AM</div>
              </div>
              
              <div class="event-card event-project">
                <div class="event-title">Project Submission: Web Development</div>
                <div class="event-datetime">June 5, 2023 • 11:59 PM</div>
              </div>
              
              <div class="event-card event-workshop">
                <div class="event-title">Career Workshop</div>
                <div class="event-datetime">June 10, 2023 • 2:00 PM</div>
              </div>
              
              <div class="view-all">
                <a href="#" class="link-button">View All Events</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(session('success'))
  <div id="success-toast" class="toast">
    {{ session('success') }}
  </div>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const toast = document.getElementById('success-toast');
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 4000); // visible for 4 seconds
    });
  </script>
@endif

</body>

</html>
