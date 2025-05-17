<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Your Team</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
  <!-- Custom Styling -->
  <style>
    :root {
      --primary-color: #4361ee;
      --primary-light: #eef2ff;
      --primary-dark: #3a56d4;
      --success-color: #2ec4b6;
      --danger-color: #e63946;
      --accent-color: #ff9f1c;
      --text-color: #2b2d42;
      --text-light: #8d99ae;
      --gray-light: #f8f9fa;
      --white: #ffffff;
      --border-radius: 12px;
      --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f9fafb;
      color: var(--text-color);
    }

    /* Header Styling */
    .hero-section {
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
      padding: 3rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 20px 20px;
      box-shadow: var(--box-shadow);
    }

    .hero-heading {
      color: var(--white);
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .hero-text {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.1rem;
      max-width: 80%;
      margin: 0 auto;
    }

    /* Step Progress Styling */
    .step-progress {
      margin-bottom: 3rem;
      position: relative;
      padding: 0 1rem;
    }

    .progress-container {
      background: var(--gray-light);
      height: 8px;
      border-radius: 4px;
      margin-bottom: 1.5rem;
      overflow: hidden;
      position: relative;
    }

    .progress-bar {
      background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
      height: 100%;
      border-radius: 4px;
      transition: width 0.5s ease;
    }

    .step-indicators {
      display: flex;
      justify-content: space-between;
      position: absolute;
      width: calc(100% - 2rem);
      top: -10px;
      left: 1rem;
    }

    .step-indicator {
      position: relative;
      z-index: 2;
    }

    .step-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
      transition: var(--transition);
      background-color: var(--white);
      color: var(--text-light);
      border: 2px solid var(--gray-light);
    }

    .step-btn.active {
      background-color: var(--primary-color);
      color: var(--white);
      border-color: var(--primary-light);
      transform: scale(1.1);
    }

    .step-btn.completed {
      background-color: var(--success-color);
      color: var(--white);
      border-color: var(--success-color);
    }

    .step-labels {
      display: flex;
      justify-content: space-between;
    }

    .step-label {
      font-size: 0.9rem;
      font-weight: 600;
      text-align: center;
      color: var(--text-light);
      transition: var(--transition);
      width: 25%;
    }

    .step-label.active {
      color: var(--primary-dark);
    }

    .step-label.completed {
      color: var(--success-color);
    }

    /* Card Styling */
    .form-card {
      background: var(--white);
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      border: none;
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .card-header {
      background-color: var(--white);
      border-bottom: 1px solid rgba(0,0,0,0.1);
      padding: 1.5rem 2rem;
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 0;
    }

    .card-subtitle {
      color: var(--text-light);
      font-size: 1rem;
      margin-top: 0.5rem;
    }

    .card-body {
      padding: 2rem;
    }

    /* Form Styling */
    .form-label {
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      padding: 0.8rem 1.2rem;
      border-radius: 8px;
      border: 1px solid rgba(0,0,0,0.12);
      box-shadow: none;
      transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    .form-text {
      color: var(--text-light);
      font-size: 0.85rem;
      margin-top: 0.5rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    /* Logo Upload Styling */
    .logo-upload-container {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto 1.5rem;
      background-color: var(--primary-light);
      position: relative;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border: 3px solid var(--white);
      transition: var(--transition);
    }

    .logo-upload-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .logo-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      color: var(--primary-color);
    }

    .logo-preview {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .upload-icon {
      font-size: 2.5rem;
      margin-bottom: 0.8rem;
    }

    .upload-text {
      font-size: 0.9rem;
      font-weight: 600;
    }

    .custom-file-input {
      display: none;
    }

    .logo-upload-label {
      display: block;
      margin: 0;
      cursor: pointer;
    }

    /* Social Media Inputs */
    .social-input-group {
      margin-bottom: 1rem;
      position: relative;
    }

    .social-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.2rem;
      color: var(--text-light);
      z-index: 10;
    }

    .social-input {
      padding-left: 3rem;
    }

    /* Button Styling */
    .btn {
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    .btn-secondary {
      background-color: #f0f2f5;
      border-color: #f0f2f5;
      color: var(--text-color);
    }

    .btn-secondary:hover {
      background-color: #e2e6ea;
      border-color: #e2e6ea;
      color: var(--text-color);
    }

    .btn-success {
      background-color: var(--success-color);
      border-color: var(--success-color);
    }

    .btn-success:hover {
      background-color: #25b0a3;
      border-color: #25b0a3;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(46, 196, 182, 0.3);
    }

    .btn-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 0.5rem;
    }

    .btn-lg {
      padding: 1rem 2rem;
      font-size: 1.1rem;
    }

    /* Review Section Styling */
    .team-profile {
      display: flex;
      align-items: center;
      border-radius: 12px;
      padding: 1.5rem;
      background-color: var(--primary-light);
      margin-bottom: 1.5rem;
    }

    .team-logo-large {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-right: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .team-info h3 {
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 0.3rem;
    }

    .team-info p {
      margin-bottom: 0.5rem;
      color: var(--text-color);
      display: flex;
      align-items: center;
    }

    .team-info .team-motto {
      font-style: italic;
      color: var(--text-light);
      margin-top: 0.5rem;
    }

    .info-icon {
      margin-right: 0.5rem;
      color: var(--primary-color);
    }

    .review-section {
      margin-bottom: 1.5rem;
    }

    .review-header {
      font-size: 1rem;
      font-weight: 600;
      color: var(--text-light);
      margin-bottom: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .review-content {
      background-color: var(--gray-light);
      border-radius: 8px;
      padding: 1.2rem;
    }

    .review-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .review-list li {
      margin-bottom: 0.8rem;
      display: flex;
      align-items: center;
    }

    .review-list li:last-child {
      margin-bottom: 0;
    }

    .review-list-label {
      font-weight: 600;
      margin-right: 0.5rem;
      min-width: 100px;
    }

    .social-review-item {
      display: flex;
      align-items: center;
    }

    .social-review-icon {
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      color: var(--white);
      margin-right: 0.5rem;
    }

    .twitter-bg {
      background-color: #1DA1F2;
    }

    .instagram-bg {
      background-color: #E1306C;
    }

    .facebook-bg {
      background-color: #4267B2;
    }

    /* Benefit Cards */
    .benefits-section {
      margin-top: 3rem;
    }

    .benefit-card {
      height: 100%;
      border-radius: var(--border-radius);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border: none;
      transition: var(--transition);
      overflow: hidden;
    }

    .benefit-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .benefit-icon-wrapper {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.2rem;
      background-color: var(--primary-light);
    }

    .benefit-icon {
      font-size: 1.8rem;
      color: var(--primary-color);
    }

    .benefit-title {
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0.8rem;
      color: var(--text-color);
    }

    .benefit-text {
      color: var(--text-light);
      margin-bottom: 0;
      font-size: 0.95rem;
    }

    /* Animation Effects */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .step-content {
      animation: fadeInUp 0.5s ease forwards;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .hero-section {
        padding: 2rem 0;
      }

      .hero-text {
        max-width: 100%;
      }

      .card-body {
        padding: 1.5rem;
      }

      .team-profile {
        flex-direction: column;
        text-align: center;
      }

      .team-logo-large {
        margin-right: 0;
        margin-bottom: 1rem;
      }

      .step-btn {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
      }

      .step-label {
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <section class="hero-section text-center">
    <div class="container">
      <h1 class="hero-heading">Create Your Dream Team</h1>
      <p class="hero-text">Set up your team profile, invite players, and start competing in just a few simple steps.</p>
    </div>
  </section>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- Team Status Check -->
        <div id="team-status-check" style="display: none;">
          <div class="alert alert-info mb-4" style="border-radius: 12px; border-left: 4px solid var(--primary-color);">
            <div class="d-flex align-items-center">
              <div class="me-3">
                <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
              </div>
              <div>
                <h5 class="alert-heading mb-1">Checking your team status...</h5>
                <p class="mb-0">Please wait while we redirect you to the appropriate page.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Step Progress -->
        <div id="create-team-form-wrapper">
          <div class="step-progress">
          <div class="progress-container">
            <div class="progress-bar" id="progress-bar" style="width: 0%"></div>
          </div>
          <div class="step-indicators">
            <div class="step-indicator">
              <button class="step-btn active" data-step="1">1</button>
            </div>
            <div class="step-indicator">
              <button class="step-btn" data-step="2">2</button>
            </div>
            <div class="step-indicator">
              <button class="step-btn" data-step="3">3</button>
            </div>
            <div class="step-indicator">
              <button class="step-btn" data-step="4">4</button>
            </div>
          </div>
          <div class="step-labels">
            <div class="step-label active">Basics</div>
            <div class="step-label">Details</div>
            <div class="step-label">Identity</div>
            <div class="step-label">Review</div>
          </div>
        </div>
      
        <!-- Form Card -->
        <div class="form-card">
          <form action="{{ route('teams.store') }}" method="POST" id="create-team-form" enctype="multipart/form-data">
            @csrf
            
            <!-- Step 1: Basic Information -->
            <div class="step-content" id="step-1">
              <div class="card-header">
                <h4 class="card-title">Team Basics</h4>
                <p class="card-subtitle">Let's start with some fundamental information about your team.</p>
              </div>
              <div class="card-body">
                <!-- Team Name -->
                <div class="form-group">
                  <label for="teamName" class="form-label">Team Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('teamName') is-invalid @enderror" id="teamName" name="teamName" value="{{ old('teamName') }}" placeholder="Enter your team name" required>
                  <div class="form-text">Choose a unique and memorable name that represents your team</div>
                  @error('teamName')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Sport Type -->
                <div class="form-group">
                  <label for="sportType" class="form-label">Sport Type <span class="text-danger">*</span></label>
                  <select class="form-select @error('sportType') is-invalid @enderror" id="sportType" name="sportType" required>
                    <option value="">Select Sport</option>
                    <option value="football" {{ old('sportType') == 'football' ? 'selected' : '' }}>Football</option>
                    <option value="basketball" {{ old('sportType') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                    <option value="tennis" {{ old('sportType') == 'tennis' ? 'selected' : '' }}>Tennis</option>
                    <option value="volleyball" {{ old('sportType') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                  </select>
                  <div class="form-text">What sport will your team play?</div>
                  @error('sportType')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Team Size -->
                <div class="form-group">
                  <label for="teamSize" class="form-label">Team Size <span class="text-danger">*</span></label>
                  <input type="number" class="form-control @error('teamSize') is-invalid @enderror" id="teamSize" name="teamSize" value="{{ old('teamSize') }}" min="2" max="50" placeholder="Number of players" required>
                  <div class="form-text">How many players do you need for your team?</div>
                  @error('teamSize')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn btn-primary next-btn" data-step="1">
                    Continue <i class="fas fa-arrow-right btn-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Step 2: Additional Details -->
            <div class="step-content d-none" id="step-2">
              <div class="card-header">
                <h4 class="card-title">Team Details</h4>
                <p class="card-subtitle">Tell us more about your team's story and goals.</p>
              </div>
              <div class="card-body">
                <!-- Team Description -->
                <div class="form-group">
                  <label for="teamDescription" class="form-label">Team Description</label>
                  <textarea class="form-control @error('teamDescription') is-invalid @enderror" id="teamDescription" name="teamDescription" rows="3" placeholder="Describe your team's goals, playing style, and values">{{ old('teamDescription') }}</textarea>
                  <div class="form-text">Help others understand what makes your team special</div>
                  @error('teamDescription')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Home Venue -->
                <div class="form-group">
                  <label for="homeVenue" class="form-label">Home Venue</label>
                  <input type="text" class="form-control @error('homeVenue') is-invalid @enderror" id="homeVenue" name="homeVenue" value="{{ old('homeVenue') }}" placeholder="Where does your team practice/play?">
                  <div class="form-text">Where does your team typically practice or play?</div>
                  @error('homeVenue')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Founded Date -->
                <div class="form-group">
                  <label for="foundingDate" class="form-label">Founded Date</label>
                  <div class="input-group">
                    <input type="date" class="form-control @error('foundingDate') is-invalid @enderror" id="foundingDate" name="foundingDate" value="{{ old('foundingDate') }}">
                    <button type="button" class="btn btn-outline-primary" id="setTodayBtn">Set Today</button>
                  </div>
                  <div class="form-text">When was your team established? Default is today's date.</div>
                  @error('foundingDate')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Team Motto -->
                <div class="form-group">
                  <label for="teamMotto" class="form-label">Team Motto</label>
                  <input type="text" class="form-control @error('teamMotto') is-invalid @enderror" id="teamMotto" name="teamMotto" value="{{ old('teamMotto') }}" placeholder="A phrase that represents your team spirit">
                  <div class="form-text">A slogan or phrase that represents your team spirit</div>
                  @error('teamMotto')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-btn" data-step="2">
                    <i class="fas fa-arrow-left btn-icon"></i> Back
                  </button>
                  <button type="button" class="btn btn-primary next-btn" data-step="2">
                    Continue <i class="fas fa-arrow-right btn-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Step 3: Team Identity -->
            <div class="step-content d-none" id="step-3">
              <div class="card-header">
                <h4 class="card-title">Team Identity</h4>
                <p class="card-subtitle">Add visual elements and online presence to your team profile.</p>
              </div>
              <div class="card-body">
                <!-- Team Logo -->
                <div class="form-group text-center">
                  <label class="form-label d-block text-center mb-3">Team Logo</label>
                  
                  <label for="teamLogo" class="logo-upload-label">
                    <div class="logo-upload-container">
                      <div id="logo-placeholder" class="logo-placeholder">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <span class="upload-text">Upload Logo</span>
                      </div>
                      <img id="logo-preview" class="logo-preview" src="#" alt="Logo preview" style="display: none;">
                    </div>
                    <input type="file" class="custom-file-input @error('teamLogo') is-invalid @enderror" id="teamLogo" name="teamLogo" accept="image/*">
                  </label>
                  
                  <div class="form-text text-center mt-2">Recommended: Square image, max 5MB</div>
                  @error('teamLogo')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
                
                <!-- Social Media Links -->
                <h5 class="mt-4 mb-3">Social Media Presence</h5>
                
                <div class="form-group">
                  <div class="social-input-group">
                    <i class="fab fa-twitter social-icon twitter-text"></i>
                    <input type="text" class="form-control social-input @error('twitterHandle') is-invalid @enderror" id="twitterHandle" name="twitterHandle" placeholder="Twitter handle (without @)" value="{{ old('twitterHandle') }}">
                  </div>
                  
                  <div class="social-input-group">
                    <i class="fab fa-instagram social-icon instagram-text"></i>
                    <input type="text" class="form-control social-input @error('instagramHandle') is-invalid @enderror" id="instagramHandle" name="instagramHandle" placeholder="Instagram handle (without @)" value="{{ old('instagramHandle') }}">
                  </div>
                  
                  <div class="social-input-group">
                    <i class="fab fa-facebook social-icon facebook-text"></i>
                    <input type="text" class="form-control social-input @error('facebookPage') is-invalid @enderror" id="facebookPage" name="facebookPage" placeholder="Facebook page name" value="{{ old('facebookPage') }}">
                  </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-btn" data-step="3">
                    <i class="fas fa-arrow-left btn-icon"></i> Back
                  </button>
                  <button type="button" class="btn btn-primary next-btn" data-step="3">
                    Continue <i class="fas fa-arrow-right btn-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Step 4: Review -->
            <div class="step-content d-none" id="step-4">
              <div class="card-header">
                <h4 class="card-title">Review & Create Team</h4>
                <p class="card-subtitle">Let's make sure everything looks right before finishing.</p>
              </div>
              <div class="card-body">
                <!-- Team Profile Preview -->
                <div class="team-profile">
                  <div class="team-logo-large" id="review-logo-container">
                    <span id="default-logo">T</span>
                    <img id="custom-logo" src="#" alt="Team logo" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                  </div>
                  <div class="team-info">
                    <h3 id="review-team-name">Team Name</h3>
                    <p id="review-sport"><i class="fas fa-basketball-ball info-icon"></i>Basketball</p>
                    <p id="review-size"><i class="fas fa-users info-icon"></i><span id="team-size-value">10</span> Players</p>
                    <p id="review-motto" class="team-motto" style="display: none;">"Team motto will appear here"</p>
                  </div>
                </div>

                <div class="row">
                  <!-- Team Details Review -->
                  <div class="col-md-6">
                    <div class="review-section">
                      <h6 class="review-header">Team Details</h6>
                      <div class="review-content">
                        <ul class="review-list">
                          <li>
                            <span class="review-list-label">Home Venue:</span>
                            <span id="review-venue">Not specified</span>
                          </li>
                          <li>
                            <span class="review-list-label">Founded:</span>
                            <span id="review-founded">Not specified</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Social Media Review -->
                  <div class="col-md-6">
                    <div class="review-section">
                      <h6 class="review-header">Social Media</h6>
                      <div class="review-content">
                        <ul class="review-list">
                          <li class="social-review-item">
                            <span class="social-review-icon twitter-bg"><i class="fab fa-twitter"></i></span>
                            <span id="review-twitter">Not specified</span>
                          </li>
                          <li class="social-review-item">
                            <span class="social-review-icon instagram-bg"><i class="fab fa-instagram"></i></span>
                            <span id="review-instagram">Not specified</span>
                          </li>
                          <li class="social-review-item">
                            <span class="social-review-icon facebook-bg"><i class="fab fa-facebook"></i></span>
                            <span id="review-facebook">Not specified</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Team Description Review -->
                <div class="review-section">
                  <h6 class="review-header">Team Description</h6>
                  <div class="review-content">
                    <p id="review-description" class="mb-0">No description provided</p>
                  </div>
                </div>
                
                <div class="alert alert-info mt-4" style="border-radius: 8px; border-left: 4px solid var(--primary-color);">
                  <i class="fas fa-info-circle me-2"></i> You'll be registered as the team captain. After creating your team, you can invite players to join.
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                  <button type="button" class="btn btn-secondary prev-btn" data-step="4">
                    <i class="fas fa-arrow-left btn-icon"></i> Back
                  </button>
                  <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check-circle me-2"></i> Create Team
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <!-- Benefits Section -->
        <div class="benefits-section">
          <div class="row g-4">
            <div class="col-md-4">
              <div class="card benefit-card">
                <div class="card-body text-center p-4">
                  <div class="benefit-icon-wrapper">
                    <i class="fas fa-users benefit-icon"></i>
                  </div>
                  <h5 class="benefit-title">Team Management</h5>
                  <p class="benefit-text">Easily add players, assign roles, and keep everyone organized.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card benefit-card">
                <div class="card-body text-center p-4">
                  <div class="benefit-icon-wrapper">
                    <i class="fas fa-trophy benefit-icon"></i>
                  </div>
                  <h5 class="benefit-title">Join Tournaments</h5>
                  <p class="benefit-text">Discover and register for competitions in your area.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card benefit-card">
                <div class="card-body text-center p-4">
                  <div class="benefit-icon-wrapper">
                    <i class="fas fa-calendar-check benefit-icon"></i>
                  </div>
                  <h5 class="benefit-title">Schedule Games</h5>
                  <p class="benefit-text">Book venues and organize matches with other teams.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Team Status Modal -->
  <div class="modal fade" id="teamStatusModal" tabindex="-1" aria-labelledby="teamStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="teamStatusModalLabel">Team Status</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div id="captain-message" style="display: none;">
            <div class="text-center mb-4">
              <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                <i class="fas fa-user-tie fa-3x text-primary"></i>
              </div>
              <h4>You're a Team Captain!</h4>
            </div>
            <p>You already have a team that you're managing. Would you like to:</p>
            <div class="d-grid gap-2">
              <a href="#" id="manage-team-link" class="btn btn-primary">
                <i class="fas fa-cogs me-2"></i> Manage Your Team
              </a>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="fas fa-plus me-2"></i> Create Another Team
              </button>
            </div>
          </div>
          
          <div id="member-message" style="display: none;">
            <div class="text-center mb-4">
              <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                <i class="fas fa-users fa-3x text-primary"></i>
              </div>
              <h4>You're Already on a Team!</h4>
            </div>
            <p>You're currently a member of a team. Would you like to:</p>
            <div class="d-grid gap-2">
              <a href="#" id="view-team-link" class="btn btn-primary">
                <i class="fas fa-eye me-2"></i> View Your Team
              </a>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="fas fa-plus me-2"></i> Create a New Team
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Check if user already has a team and redirect accordingly
      checkTeamStatus();
      
      // Set today's date as default for founding date
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('foundingDate').value = today;
      
      // Set Today button functionality
      document.getElementById('setTodayBtn').addEventListener('click', function() {
        document.getElementById('foundingDate').value = today;
      });
      
      // Function to check team status and show appropriate content
      function checkTeamStatus() {
        // In a real implementation, this would be an AJAX call to the server
        // For demonstration, we're using a simulated check with a timeout
        
        // Check if there's a URL parameter to bypass the check (for testing)
        const urlParams = new URLSearchParams(window.location.search);
        const bypassCheck = urlParams.get('bypass_check');
        
        if (bypassCheck === 'true') {
          document.getElementById('create-team-form-wrapper').style.display = 'block';
          return; // Skip the check and show the form
        }
        
        // Show loading spinner
        document.getElementById('team-status-check').style.display = 'block';
        document.getElementById('create-team-form-wrapper').style.display = 'none';
        
        // Simulate AJAX call (replace with real AJAX in production)
        setTimeout(function() {
          // This would be the server response
          const userStatus = {
            // Change these values for testing different scenarios
            hasTeam: false,          // Set to true to simulate user already having a team
            isCaptain: false,        // Set to true to simulate user being a team captain
            teamId: 123              // This would be the team ID returned from the server
          };
          
          if (userStatus.hasTeam) {
            // Show the appropriate modal based on user status
            if (userStatus.isCaptain) {
              document.getElementById('captain-message').style.display = 'block';
              document.getElementById('member-message').style.display = 'none';
              document.getElementById('manage-team-link').href = '/teams/manage/' + userStatus.teamId;
            } else {
              document.getElementById('captain-message').style.display = 'none';
              document.getElementById('member-message').style.display = 'block';
              document.getElementById('view-team-link').href = '/teams/member/' + userStatus.teamId;
            }
            
            // Show the modal
            const teamStatusModal = new bootstrap.Modal(document.getElementById('teamStatusModal'));
            teamStatusModal.show();
            
            // Hide loading spinner
            document.getElementById('team-status-check').style.display = 'none';
            document.getElementById('create-team-form-wrapper').style.display = 'block';
          } else {
            // User doesn't have a team, show the creation form
            document.getElementById('team-status-check').style.display = 'none';
            document.getElementById('create-team-form-wrapper').style.display = 'block';
          }
        }, 1500); // Simulate 1.5 second delay for the check
      }
      
      // Step navigation
      const progressBar = document.getElementById('progress-bar');
      const nextButtons = document.querySelectorAll('.next-btn');
      const prevButtons = document.querySelectorAll('.prev-btn');
      const stepButtons = document.querySelectorAll('.step-btn');
      const stepContents = document.querySelectorAll('.step-content');
      const stepIndicators = document.querySelectorAll('.step-indicator');
      const stepLabels = document.querySelectorAll('.step-label');
      
      // Initialize form for validation
      const form = document.getElementById('create-team-form');
      
      // Logo preview handling
      const logoInput = document.getElementById('teamLogo');
      const logoPreview = document.getElementById('logo-preview');
      const logoPlaceholder = document.getElementById('logo-placeholder');
      const customLogo = document.getElementById('custom-logo');
      
      // Handle next button clicks
      nextButtons.forEach(button => {
        button.addEventListener('click', function() {
          const currentStep = parseInt(this.getAttribute('data-step'));
          const nextStep = currentStep + 1;
          
          // Simple form validation for required fields
          if (currentStep === 1) {
            const teamName = document.getElementById('teamName').value;
            const sportType = document.getElementById('sportType').value;
            const teamSize = document.getElementById('teamSize').value;
            
            if (!teamName || !sportType || !teamSize) {
              alert('Please fill in all required fields');
              return;
            }
          }
          
          // Update review info if going to step 4
          if (nextStep === 4) {
            updateReviewInfo();
          }
          
          // Hide current step and show next
          document.getElementById(`step-${currentStep}`).classList.add('d-none');
          document.getElementById(`step-${nextStep}`).classList.remove('d-none');
          
          // Update progress bar and indicators
          updateProgress(nextStep);
        });
      });
      
      // Handle previous button clicks
      prevButtons.forEach(button => {
        button.addEventListener('click', function() {
          const currentStep = parseInt(this.getAttribute('data-step'));
          const prevStep = currentStep - 1;
          
          // Hide current step and show previous
          document.getElementById(`step-${currentStep}`).classList.add('d-none');
          document.getElementById(`step-${prevStep}`).classList.remove('d-none');
          
          // Update progress bar and indicators
          updateProgress(prevStep);
        });
      });
      
      // Handle step indicator clicks
      stepButtons.forEach(button => {
        button.addEventListener('click', function() {
          const targetStep = parseInt(this.getAttribute('data-step'));
          const currentStep = getCurrentStep();
          
          // Don't allow skipping ahead without completing previous steps
          if (targetStep > currentStep) {
            return;
          }
          
          // Hide current step and show target
          document.getElementById(`step-${currentStep}`).classList.add('d-none');
          document.getElementById(`step-${targetStep}`).classList.remove('d-none');
          
          // Update progress bar and indicators
          updateProgress(targetStep);
        });
      });
      
      // Function to update progress bar and indicators
      function updateProgress(step) {
        // Update progress bar - each step is 33.33% except the last
        const progressPercentage = (step - 1) * 33.33;
        progressBar.style.width = `${progressPercentage}%`;
        
        // Update step indicators
        stepButtons.forEach((button, index) => {
          const stepNum = index + 1;
          
          // Reset all buttons first
          button.classList.remove('active', 'completed');
          
          if (stepNum === step) {
            // Current step
            button.classList.add('active');
          } else if (stepNum < step) {
            // Completed step
            button.classList.add('completed');
          }
        });
        
        // Update step labels
        stepLabels.forEach((label, index) => {
          const stepNum = index + 1;
          
          // Reset all labels first
          label.classList.remove('active', 'completed');
          
          if (stepNum === step) {
            // Current step
            label.classList.add('active');
          } else if (stepNum < step) {
            // Completed step
            label.classList.add('completed');
          }
        });
      }
      
      // Function to get current step
      function getCurrentStep() {
        for (let i = 0; i < stepContents.length; i++) {
          if (!stepContents[i].classList.contains('d-none')) {
            return i + 1;
          }
        }
        return 1;
      }
      
      // Handle logo preview
      logoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
            logoPreview.src = e.target.result;
            logoPreview.style.display = 'block';
            logoPlaceholder.style.display = 'none';
            
            // Update the review logo as well
            customLogo.src = e.target.result;
            customLogo.style.display = 'block';
            document.getElementById('default-logo').style.display = 'none';
          }
          
          reader.readAsDataURL(this.files[0]);
        }
      });
      
      // Function to update review info
      function updateReviewInfo() {
        const teamName = document.getElementById('teamName').value;
        const sportType = document.getElementById('sportType').value;
        const teamSize = document.getElementById('teamSize').value;
        const teamMotto = document.getElementById('teamMotto').value;
        const teamDescription = document.getElementById('teamDescription').value;
        const homeVenue = document.getElementById('homeVenue').value;
        const foundingDate = document.getElementById('foundingDate').value;
        const twitterHandle = document.getElementById('twitterHandle').value;
        const instagramHandle = document.getElementById('instagramHandle').value;
        const facebookPage = document.getElementById('facebookPage').value;
        
        // Update team name, sport type, and size
        document.getElementById('review-team-name').textContent = teamName || 'Team Name';
        
        // Update sport icon and text
        let sportIcon = 'basketball-ball';
        let sportText = 'Basketball';
        
        if (sportType === 'football') {
          sportIcon = 'futbol';
          sportText = 'Football';
        } else if (sportType === 'tennis') {
          sportIcon = 'table-tennis';
          sportText = 'Tennis';
        } else if (sportType === 'volleyball') {
          sportIcon = 'volleyball-ball';
          sportText = 'Volleyball';
        }
        
        document.getElementById('review-sport').innerHTML = `<i class="fas fa-${sportIcon} info-icon"></i>${sportText}`;
        
        // Update team size
        document.getElementById('team-size-value').textContent = teamSize || '0';
        
        // Update team motto if provided
        if (teamMotto) {
          document.getElementById('review-motto').textContent = `"${teamMotto}"`;
          document.getElementById('review-motto').style.display = 'block';
        } else {
          document.getElementById('review-motto').style.display = 'none';
        }
        
        // Update home venue
        document.getElementById('review-venue').textContent = homeVenue || 'Not specified';
        
        // Update founding date
        if (foundingDate) {
          const formattedDate = new Date(foundingDate).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
          });
          document.getElementById('review-founded').textContent = formattedDate;
        } else {
          document.getElementById('review-founded').textContent = 'Not specified';
        }
        
        // Update social media
        document.getElementById('review-twitter').textContent = twitterHandle || 'Not specified';
        document.getElementById('review-instagram').textContent = instagramHandle || 'Not specified';
        document.getElementById('review-facebook').textContent = facebookPage || 'Not specified';
        
        // Update description
        document.getElementById('review-description').textContent = teamDescription || 'No description provided';
        
        // Update default logo (first letter of team name)
        if (!logoInput.files || !logoInput.files[0]) {
          document.getElementById('default-logo').textContent = teamName ? teamName.charAt(0).toUpperCase() : 'T';
          document.getElementById('default-logo').style.display = 'block';
          document.getElementById('custom-logo').style.display = 'none';
        }
      }
    });
  </script>
</body>
</html>