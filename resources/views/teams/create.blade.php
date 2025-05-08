<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sports Team Creation Process</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .step-indicator {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
    }
    .step {
      text-align: center;
      position: relative;
      flex: 1;
    }
    .step:not(:last-child):after {
      content: '';
      position: absolute;
      top: 25px;
      left: 50%;
      width: 100%;
      height: 2px;
      background-color: #e9ecef;
      z-index: 0;
    }
    .step-number {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #e9ecef;
      color: #6c757d;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
      position: relative;
      z-index: 1;
      font-weight: bold;
      font-size: 1.2rem;
      transition: all 0.3s;
    }
    .step.active .step-number {
      background-color: #0d6efd;
      color: white;
    }
    .step.completed .step-number {
      background-color: #198754;
      color: white;
    }
    .step-title {
      font-size: 0.9rem;
      color: #6c757d;
    }
    .step.active .step-title {
      color: #0d6efd;
      font-weight: bold;
    }
    .step.completed .step-title {
      color: #198754;
    }
    .tab-content {
      padding: 1.5rem;
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
    }
    .logo-preview {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      border: 1px dashed #ced4da;
      color: #6c757d;
      overflow: hidden;
    }
    .sport-card {
      cursor: pointer;
      transition: all 0.3s;
    }
    .sport-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .sport-card.selected {
      border: 2px solid #0d6efd;
    }
    .sport-icon {
      width: 120px;
      height: 120px;
      border-radius: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      cursor: pointer;
      transition: all 0.3s;
    }
    .sport-icon:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body>
  <!-- Main Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-xl-10">
        @if(session('info'))
          <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @if(!auth()->check())
          <!-- User not logged in -->
          <div class="text-center py-5">
            <div class="mb-4">
              <i class="fas fa-lock fa-4x text-secondary"></i>
            </div>
            <h2>Authentication Required</h2>
            <p class="text-muted mb-4">You need to log in to create a team.</p>
            <a href="" class="btn btn-primary btn-lg px-4">
              <i class="fas fa-sign-in-alt me-2"></i> Log In
            </a>
            <p class="mt-3">
              Don't have an account? <a href="">Register now</a>
            </p>
          </div>
         <!-- Replace the existing elseif condition with this updated code -->
@elseif(auth()->user()->hasTeam())
<!-- Check if user is team captain -->
@if(auth()->user()->isCaptainOfCurrentTeam())
  <script>
    // Immediately redirect to team show page if user is team captain
    window.location.href = "{{ route('teams.show', auth()->user()->team) }}";
  </script>
@else
  <!-- User already has a team but is not the captain -->
  <div class="text-center py-5">
    <div class="mb-4">
      <i class="fas fa-users fa-4x text-primary"></i>
    </div>
    <h2>You Already Have a Team</h2>
    <p class="text-muted mb-4">You've already created or joined a team.</p>
    <a href="{{ route('teams.show', auth()->user()->team) }}" class="btn btn-primary btn-lg px-4">
      <i class="fas fa-arrow-right me-2"></i> Go to My Team
    </a>
  </div>
@endif
          <!-- User logged in and doesn't have a team -->
          <h2 class="text-center mb-4">Create Your Sports Team</h2>
          <p class="text-center text-muted mb-5">Follow the steps below to set up your team from scratch</p>
          
          <!-- Step Indicator -->
          <div class="step-indicator mb-5">
            <div class="step active">
              <div class="step-number">1</div>
              <div class="step-title">Select Sport</div>
            </div>
            <div class="step">
              <div class="step-number">2</div>
              <div class="step-title">Team Details</div>
            </div>
            <div class="step">
              <div class="step-number">3</div>
              <div class="step-title">Team Identity</div>
            </div>
            <div class="step">
              <div class="step-number">4</div>
              <div class="step-title">Review & Finish</div>
            </div>
          </div>
          
          <!-- Steps Content -->
          <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data" id="teamCreationForm">
            @csrf
            <input type="hidden" name="sportType" id="sportType" value="basketball">
            
            <div class="tab-content">
              <!-- Step 1: Select Sport -->
              <div id="step1" class="tab-pane fade show active">
                <h4 class="mb-4">Select Your Sport</h4>
                <div class="row g-4">
                  <div class="col-md-4 col-6">
                    <div class="card sport-card selected h-100 text-center" data-sport="basketball">
                      <div class="card-body">
                        <div class="sport-icon bg-primary text-white">
                          <i class="fas fa-basketball fa-3x"></i>
                        </div>
                        <h5 class="card-title">Basketball</h5>
                        <p class="card-text small text-muted">5 players on court</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-6">
                    <div class="card sport-card h-100 text-center" data-sport="football">
                      <div class="card-body">
                        <div class="sport-icon bg-success text-white">
                          <i class="fas fa-futbol fa-3x"></i>
                        </div>
                        <h5 class="card-title">Football</h5>
                        <p class="card-text small text-muted">11 players on field</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-6">
                    <div class="card sport-card h-100 text-center" data-sport="tennis">
                      <div class="card-body">
                        <div class="sport-icon bg-warning text-white">
                          <i class="fas fa-table-tennis fa-3x"></i>
                        </div>
                        <h5 class="card-title">Tennis</h5>
                        <p class="card-text small text-muted">2/4 players on field</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-6">
                    <div class="card sport-card h-100 text-center" data-sport="volleyball">
                      <div class="card-body">
                        <div class="sport-icon bg-secondary text-white">
                          <i class="fas fa-volleyball-ball fa-3x"></i>
                        </div>
                        <h5 class="card-title">Volleyball</h5>
                        <p class="card-text small text-muted">6 players on court</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn btn-primary px-4" id="step1Next">Continue</button>
                </div>
              </div>
              
              <!-- Step 2: Team Details -->
              <div id="step2" class="tab-pane fade">
                <h4 class="mb-4">Enter Team Details</h4>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control @error('teamName') is-invalid @enderror" id="teamName" name="teamName" placeholder="Team Name" value="{{ old('teamName') }}" required>
                      <label for="teamName">Team Name *</label>
                      @error('teamName')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <select class="form-select @error('teamSize') is-invalid @enderror" id="teamSize" name="teamSize" required>
                        <option value="5" {{ old('teamSize') == 5 ? 'selected' : '' }}>5 players (minimum)</option>
                        <option value="10" {{ old('teamSize') == 10 ? 'selected' : '' }}>10 players</option>
                        <option value="12" {{ old('teamSize') == 12 ? 'selected' : '' }}>12 players</option>
                        <option value="15" {{ old('teamSize') == 15 ? 'selected' : '' }}>15 players</option>
                        <option value="18" {{ old('teamSize') == 18 ? 'selected' : '' }}>18 players</option>
                        <option value="20" {{ old('teamSize') == 20 ? 'selected' : '' }}>20+ players</option>
                      </select>
                      <label for="teamSize">Team Size *</label>
                      @error('teamSize')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <textarea class="form-control @error('teamDescription') is-invalid @enderror" id="teamDescription" name="teamDescription" style="height: 100px" placeholder="Team Description">{{ old('teamDescription') }}</textarea>
                    <label for="teamDescription">Team Description</label>
                    @error('teamDescription')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control @error('homeVenue') is-invalid @enderror" id="homeVenue" name="homeVenue" placeholder="Home Venue" value="{{ old('homeVenue') }}">
                      <label for="homeVenue">Home Venue</label>
                      @error('homeVenue')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="date" class="form-control @error('foundingDate') is-invalid @enderror" id="foundingDate" name="foundingDate" value="{{ old('foundingDate') }}">
                      <label for="foundingDate">Founded Date</label>
                      @error('foundingDate')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-outline-secondary px-4" id="step2Prev">Back</button>
                  <button type="button" class="btn btn-primary px-4" id="step2Next">Continue</button>
                </div>
              </div>
              
              <!-- Step 3: Team Identity -->
              <div id="step3" class="tab-pane fade">
                <h4 class="mb-4">Create Team Identity</h4>
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="card h-100">
                      <div class="card-body">
                        <h5 class="card-title">Team Logo</h5>
                        <div class="logo-preview mb-3" id="logoPreview">
                          <i class="fas fa-cloud-upload-alt fa-3x"></i>
                        </div>
                        <div class="d-grid">
                          <input type="file" class="form-control @error('teamLogo') is-invalid @enderror" id="teamLogo" name="teamLogo" accept="image/*" style="display: none">
                          <button type="button" class="btn btn-outline-primary" id="uploadLogoBtn">Upload Logo</button>
                        </div>
                        <p class="small text-muted mt-2">
                          Recommended size: at least 500x500 pixels. Max file size: 5MB.
                        </p>
                        @error('teamLogo')
                          <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card h-100">
                      <div class="card-body">
                        <h5 class="card-title">Team Motto & Social</h5>
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control @error('teamMotto') is-invalid @enderror" id="teamMotto" name="teamMotto" placeholder="Team Motto" value="{{ old('teamMotto') }}">
                          <label for="teamMotto">Team Motto/Slogan</label>
                          @error('teamMotto')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Social Media Handles</label>
                          <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                            <input type="text" class="form-control" name="twitterHandle" placeholder="Twitter handle" value="{{ old('twitterHandle') }}">
                          </div>
                          <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                            <input type="text" class="form-control" name="instagramHandle" placeholder="Instagram handle" value="{{ old('instagramHandle') }}">
                          </div>
                          <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                            <input type="text" class="form-control" name="facebookPage" placeholder="Facebook page" value="{{ old('facebookPage') }}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-outline-secondary px-4" id="step3Prev">Back</button>
                  <button type="button" class="btn btn-primary px-4" id="step3Next">Continue</button>
                </div>
              </div>
              
              <!-- Step 4: Review & Finish -->
              <div id="step4" class="tab-pane fade">
                <h4 class="mb-4">Review Your Team</h4>
                <div class="alert alert-success mb-4">
                  <i class="fas fa-check-circle me-2"></i> Your team setup is almost complete! Review the details below and finish the creation process.
                </div>
                
                <div class="card h-100 mb-4">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Team Summary</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex mb-4">
                      <div id="reviewLogo" style="width: 80px; height: 80px; background-color: #0d6efd; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; margin-right: 15px;">
                        TB
                      </div>
                      <div>
                        <h4 class="mb-1" id="reviewTeamName">Team Name</h4>
                        <div class="text-muted" id="reviewSportType">Basketball</div>
                        <div class="small text-muted" id="reviewHomeVenue">Home Venue</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center mb-3">
                      <div class="summary-icon bg-light me-3 p-2 rounded">
                        <i class="fas fa-users text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Team Size</div>
                        <div id="reviewTeamSize">5 Players</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center mb-3">
                      <div class="summary-icon bg-light me-3 p-2 rounded">
                        <i class="fas fa-building text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Home Venue</div>
                        <div id="reviewVenue">Venue Name</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center">
                      <div class="summary-icon bg-light me-3 p-2 rounded">
                        <i class="fas fa-bullhorn text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Team Motto</div>
                        <div id="reviewMotto">Team Motto</div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="card mt-4">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Next Steps</h5>
                  </div>
                  <div class="card-body">
                    <div class="row g-4">
                      <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                          <div class="me-3 text-primary">
                            <i class="fas fa-user-plus fa-2x"></i>
                          </div>
                          <h6 class="mb-0">Add Players</h6>
                        </div>
                        <p class="small text-muted">Start adding players to your roster with detailed profiles and statistics</p>
                      </div>
                      <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                          <div class="me-3 text-primary">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                          </div>
                          <h6 class="mb-0">Schedule Games</h6>
                        </div>
                        <p class="small text-muted">Create your season schedule with upcoming games and practice sessions</p>
                      </div>
                      <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                          <div class="me-3 text-primary">
                            <i class="fas fa-chart-line fa-2x"></i>
                          </div>
                          <h6 class="mb-0">Track Stats</h6>
                        </div>
                        <p class="small text-muted">Record game statistics and track player development over time</p>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-outline-secondary px-4" id="step4Prev">Back</button>
                  <button type="submit" class="btn btn-success px-5" id="createTeamBtn">
                    <i class="fas fa-check me-2"></i> Create Team
                  </button>
                </div>
              </div>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
 document.addEventListener('DOMContentLoaded', function() {
  // Step navigation
  const steps = document.querySelectorAll('.step');
  const tabPanes = document.querySelectorAll('.tab-pane');

  function updateStepIndicator(currentStep) {
    steps.forEach((step, index) => {
      step.classList.remove('active', 'completed');
      if (index + 1 === currentStep) {
        step.classList.add('active');
      } else if (index + 1 < currentStep) {
        step.classList.add('completed');
      }
    });
  }
  
  function navigateToStep(currentStep, nextStep) {
    // First remove active classes from current step
    tabPanes[currentStep - 1].classList.remove('show', 'active');
    // Then add active classes to next step
    tabPanes[nextStep - 1].classList.add('show', 'active');
    updateStepIndicator(nextStep);
  }

  // Step navigation handlers
  const step1Next = document.getElementById('step1Next');
  const step2Prev = document.getElementById('step2Prev');
  const step2Next = document.getElementById('step2Next');
  const step3Prev = document.getElementById('step3Prev');
  const step3Next = document.getElementById('step3Next');
  const step4Prev = document.getElementById('step4Prev');
  
  if (step1Next) step1Next.addEventListener('click', e => { e.preventDefault(); navigateToStep(1, 2); });
  if (step2Prev) step2Prev.addEventListener('click', e => { e.preventDefault(); navigateToStep(2, 1); });
  if (step2Next) step2Next.addEventListener('click', e => { 
    e.preventDefault(); 
    // Basic validation for step 2
    const teamName = document.getElementById('teamName').value;
    if (!teamName) {
      alert('Team name is required!');
      return;
    }
    navigateToStep(2, 3); 
  });
  if (step3Prev) step3Prev.addEventListener('click', e => { e.preventDefault(); navigateToStep(3, 2); });
  if (step3Next) step3Next.addEventListener('click', e => { 
    e.preventDefault(); 
    updateReviewData();
    navigateToStep(3, 4); 
  });
  if (step4Prev) step4Prev.addEventListener('click', e => { e.preventDefault(); navigateToStep(4, 3); });

  // Sport selection
  const sportCards = document.querySelectorAll('.sport-card');
  if (sportCards) {
    sportCards.forEach((card) => {
      card.addEventListener('click', function() {
        sportCards.forEach((c) => c.classList.remove('selected'));
        this.classList.add('selected');
        
        // Update hidden sport type input
        const sportTypeInput = document.getElementById('sportType');
        if (sportTypeInput) {
          sportTypeInput.value = this.dataset.sport;
        }
        
        // Update review sport type
        const reviewSportType = document.getElementById('reviewSportType');
        if (reviewSportType) {
          const sportTitle = this.querySelector('.card-title');
          if (sportTitle) {
            reviewSportType.textContent = sportTitle.textContent;
          }
        }
      });
    });
  }
  
  // Logo upload handling
  const logoInput = document.getElementById('teamLogo');
  const uploadLogoBtn = document.getElementById('uploadLogoBtn');
  const logoPreview = document.getElementById('logoPreview');
  
  if (uploadLogoBtn && logoInput) {
    uploadLogoBtn.addEventListener('click', function() {
      logoInput.click();
    });
  }
  
  if (logoInput && logoPreview) {
    logoInput.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          // Clear existing content
          logoPreview.innerHTML = '';
          
          // Create image element
          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.width = '100%';
          img.style.height = '100%';
          img.style.objectFit = 'cover';
          logoPreview.appendChild(img);
          
          // Update review logo
          const reviewLogo = document.getElementById('reviewLogo');
          if (reviewLogo) {
            reviewLogo.innerHTML = '';
            const reviewImg = document.createElement('img');
            reviewImg.src = e.target.result;
            reviewImg.style.width = '100%';
            reviewImg.style.height = '100%';
            reviewImg.style.objectFit = 'cover';
            reviewImg.style.borderRadius = '50%';
            reviewLogo.appendChild(reviewImg);
          }
        };
        
        reader.readAsDataURL(this.files[0]);
      }
    });
  }
  
  // Update review data when going to step 4
  function updateReviewData() {
    const teamNameInput = document.getElementById('teamName');
    const teamSizeInput = document.getElementById('teamSize');
    const homeVenueInput = document.getElementById('homeVenue');
    const teamMottoInput = document.getElementById('teamMotto');
    
    const teamName = teamNameInput ? teamNameInput.value : '';
    const teamSize = teamSizeInput ? teamSizeInput.value : '5';
    const homeVenue = homeVenueInput ? homeVenueInput.value : '';
    const teamMotto = teamMottoInput ? teamMottoInput.value : '';
    
    // Update review screen with collected data
    const reviewTeamName = document.getElementById('reviewTeamName');
    const reviewTeamSize = document.getElementById('reviewTeamSize');
    const reviewVenue = document.getElementById('reviewVenue');
    const reviewMotto = document.getElementById('reviewMotto');
    
    if (reviewTeamName) reviewTeamName.textContent = teamName || 'Team Name';
    if (reviewTeamSize) reviewTeamSize.textContent = teamSize + ' Players';
    if (reviewVenue) reviewVenue.textContent = homeVenue || 'Not specified';
    if (reviewMotto) reviewMotto.textContent = teamMotto || 'No motto specified';
  }
  
  // Form validation before submission
  const teamForm = document.getElementById('teamCreationForm');
  const createTeamBtn = document.getElementById('createTeamBtn');
  
  if (createTeamBtn && teamForm) {
    teamForm.addEventListener('submit', function(e) {
      // Prevent the default form submission
      e.preventDefault();
      
      // Basic form validation
      const teamName = document.getElementById('teamName').value;
      if (!teamName) {
        alert('Team name is required!');
        navigateToStep(4, 2); // Go back to team details step
        return false;
      }
      
      // If validation passes, submit the form
      this.submit();
    });
  }
  
  // Initialize the first step
  updateStepIndicator(1);
});
    </script>
</body>
</html>  