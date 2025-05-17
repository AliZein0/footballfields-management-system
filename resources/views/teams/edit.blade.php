<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Your Team</title>
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
      --warning-color: #ff9f1c;
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

    /* Tab Navigation */
    .nav-tabs {
      border: none;
      margin-bottom: 1.5rem;
      gap: 0.5rem;
    }

    .nav-tabs .nav-link {
      border: none;
      background-color: var(--gray-light);
      color: var(--text-color);
      font-weight: 600;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      transition: var(--transition);
    }

    .nav-tabs .nav-link:hover {
      background-color: #e9ecef;
    }

    .nav-tabs .nav-link.active {
      background-color: var(--primary-color);
      color: var(--white);
      box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    }

    .nav-tabs .nav-link i {
      margin-right: 0.5rem;
    }

    /* Card Styling */
    .content-card {
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

    .btn-danger {
      background-color: var(--danger-color);
      border-color: var(--danger-color);
    }

    .btn-danger:hover {
      background-color: #d62b39;
      border-color: #d62b39;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
    }

    .btn-warning {
      background-color: var(--warning-color);
      border-color: var(--warning-color);
      color: var(--white);
    }

    .btn-warning:hover {
      background-color: #f09000;
      border-color: #f09000;
      color: var(--white);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(255, 159, 28, 0.3);
    }

    .btn-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.5rem;
    }

    /* Team Member Cards */
    .team-member-card {
      border-radius: 10px;
      border: 1px solid rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 1.5rem;
      transition: var(--transition);
    }

    .team-member-card:hover {
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transform: translateY(-3px);
    }

    .member-header {
      display: flex;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .member-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: var(--primary-light);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.2rem;
      margin-right: 1rem;
    }

    .member-info {
      flex: 1;
    }

    .member-name {
      font-weight: 600;
      margin-bottom: 0.2rem;
    }

    .member-role {
      font-size: 0.85rem;
      color: var(--text-light);
    }

    .member-actions {
      margin-left: auto;
    }

    .member-body {
      padding: 1rem;
      background-color: var(--gray-light);
    }

    .member-stat {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
    }

    .member-stat-label {
      color: var(--text-light);
      font-size: 0.85rem;
    }

    .member-stat-value {
      font-weight: 600;
    }

    /* Pending Invitations */
    .invitation-card {
      border-radius: 10px;
      border: 1px solid rgba(0,0,0,0.1);
      padding: 1rem;
      margin-bottom: 1rem;
      background-color: var(--white);
      display: flex;
      align-items: center;
      transition: var(--transition);
    }

    .invitation-card:hover {
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .invitation-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--warning-color);
      opacity: 0.2;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
    }

    .invitation-icon i {
      color: var(--warning-color);
      opacity: 1;
    }

    .invitation-info {
      flex: 1;
    }

    .invitation-email {
      font-weight: 600;
      margin-bottom: 0.2rem;
    }

    .invitation-date {
      font-size: 0.8rem;
      color: var(--text-light);
    }

    .invitation-actions {
      margin-left: 1rem;
    }

    /* Team Stats */
    .team-stat-card {
      border-radius: 10px;
      padding: 1.5rem;
      text-align: center;
      height: 100%;
      background-color: var(--white);
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transition: var(--transition);
    }

    .team-stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    .stat-icon-wrapper {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      background-color: var(--primary-light);
    }

    .stat-icon {
      font-size: 1.5rem;
      color: var(--primary-color);
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      color: var(--text-light);
      font-size: 0.9rem;
    }

    /* Danger Zone */
    .danger-zone {
      background-color: rgba(230, 57, 70, 0.05);
      border: 1px solid rgba(230, 57, 70, 0.2);
      border-radius: 10px;
      padding: 1.5rem;
      margin-top: 2rem;
    }

    .danger-zone-header {
      color: var(--danger-color);
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }

    /* Save changes notification */
    .save-notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: var(--success-color);
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      z-index: 1050;
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s ease;
    }

    .save-notification.show {
      transform: translateY(0);
      opacity: 1;
    }

    .save-notification i {
      margin-right: 0.8rem;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <section class="hero-section text-center">
    <div class="container">
      <h1 class="hero-heading">Manage Your Team</h1>
      <p class="hero-text">Update your team's information, manage players, and track performance.</p>
    </div>
  </section>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- Team Name and Info Header -->
        <div class="mb-4 d-flex align-items-center">
          <div class="me-3" style="width: 80px; height: 80px; border-radius: 50%; background-color: var(--primary-light); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; color: var(--primary-color);">
            <span id="team-initial">T</span>
            <img id="team-logo-header" src="#" alt="Team logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: none;">
          </div>
          <div>
            <h2 class="mb-1">The Wildcats</h2>
            <p class="mb-0 text-muted"><i class="fas fa-basketball-ball me-2"></i>Basketball • <span id="team-size-display">12</span> Players</p>
          </div>
          <div class="ms-auto">
            <a href="/teams" class="btn btn-outline-primary">
              <i class="fas fa-arrow-left btn-icon"></i> Back to Teams
            </a>
          </div>
        </div>
        
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="teamTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">
              <i class="fas fa-info-circle"></i> Team Details
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button" role="tab" aria-controls="members" aria-selected="false">
              <i class="fas fa-users"></i> Members
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="false">
              <i class="fas fa-chart-line"></i> Statistics
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
              <i class="fas fa-cog"></i> Settings
            </button>
          </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content" id="teamTabsContent">
          <!-- Team Details Tab -->
          <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
            <div class="content-card">
              <form id="team-details-form">
                <div class="card-header">
                  <h4 class="card-title">Team Information</h4>
                  <p class="card-subtitle">Update your team's basic information and appearance.</p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <!-- Team Logo -->
                      <div class="form-group">
                        <label class="form-label d-block text-center mb-3">Team Logo</label>
                        
                        <label for="teamLogo" class="logo-upload-label">
                          <div class="logo-upload-container">
                            <div id="logo-placeholder" class="logo-placeholder" style="display: none;">
                              <i class="fas fa-cloud-upload-alt upload-icon"></i>
                              <span class="upload-text">Upload Logo</span>
                            </div>
                            <img id="logo-preview" class="logo-preview" src="https://via.placeholder.com/180" alt="Logo preview">
                          </div>
                          <input type="file" class="custom-file-input" id="teamLogo" name="teamLogo" accept="image/*">
                        </label>
                        
                        <div class="form-text text-center mt-2">Recommended: Square image, max 5MB</div>
                      </div>

                      <!-- Social Media Links -->
                      <h5 class="mt-4 mb-3">Social Media</h5>
                      
                      <div class="form-group">
                        <div class="social-input-group">
                          <i class="fab fa-twitter social-icon"></i>
                          <input type="text" class="form-control social-input" id="twitterHandle" name="twitterHandle" placeholder="Twitter handle (without @)" value="wildcats_team">
                        </div>
                        
                        <div class="social-input-group">
                          <i class="fab fa-instagram social-icon"></i>
                          <input type="text" class="form-control social-input" id="instagramHandle" name="instagramHandle" placeholder="Instagram handle (without @)" value="thewildcats">
                        </div>
                        
                        <div class="social-input-group">
                          <i class="fab fa-facebook social-icon"></i>
                          <input type="text" class="form-control social-input" id="facebookPage" name="facebookPage" placeholder="Facebook page name" value="TheWildcatsTeam">
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-8">
                      <!-- Team Name -->
                      <div class="form-group">
                        <label for="teamName" class="form-label">Team Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="teamName" name="teamName" value="The Wildcats" required>
                      </div>
                      
                      <!-- Sport Type -->
                      <div class="form-group">
                        <label for="sportType" class="form-label">Sport Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="sportType" name="sportType" required>
                          <option value="">Select Sport</option>
                          <option value="football">Football</option>
                          <option value="basketball" selected>Basketball</option>
                          <option value="tennis">Tennis</option>
                          <option value="volleyball">Volleyball</option>
                        </select>
                      </div>
                      
                      <!-- Team Size -->
                      <div class="form-group">
                        <label for="teamSize" class="form-label">Team Size <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="teamSize" name="teamSize" value="12" min="2" max="50" required>
                      </div>
                      
                      <!-- Team Description -->
                      <div class="form-group">
                        <label for="teamDescription" class="form-label">Team Description</label>
                        <textarea class="form-control" id="teamDescription" name="teamDescription" rows="3">The Wildcats are a competitive basketball team focused on skill development and teamwork. Founded in 2023, we aim to create a positive environment for players to grow and achieve their potential.</textarea>
                      </div>
                      
                      <!-- Home Venue -->
                      <div class="form-group">
                        <label for="homeVenue" class="form-label">Home Venue</label>
                        <input type="text" class="form-control" id="homeVenue" name="homeVenue" value="Central Sports Complex, Court 3">
                      </div>
                      
                      <!-- Founded Date -->
                      <div class="form-group">
                        <label for="foundingDate" class="form-label">Founded Date</label>
                        <input type="date" class="form-control" id="foundingDate" name="foundingDate" value="2023-06-15">
                      </div>
                      
                      <!-- Team Motto -->
                      <div class="form-group">
                        <label for="teamMotto" class="form-label">Team Motto</label>
                        <input type="text" class="form-control" id="teamMotto" name="teamMotto" value="Together we rise, together we conquer">
                      </div>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save btn-icon"></i> Save Changes
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Members Tab -->
          <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
            <div class="content-card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="card-title">Team Members</h4>
                  <p class="card-subtitle">Manage your roster and player roles.</p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invitePlayerModal">
                  <i class="fas fa-user-plus btn-icon"></i> Invite Player
                </button>
              </div>
              <div class="card-body">
                <div class="mb-4">
                  <h5 class="mb-3">Current Roster (8 of 12 filled)</h5>
                  
                  <!-- Team Members List -->
                  <div class="row">
                    <!-- Captain -->
                    <div class="col-lg-6">
                      <div class="team-member-card">
                        <div class="member-header">
                          <div class="member-avatar">JD</div>
                          <div class="member-info">
                            <h6 class="member-name">John Doe</h6>
                            <div class="member-role text-primary">Team Captain</div>
                          </div>
                          <div class="member-actions">
                            <div class="dropdown">
                              <button class="btn btn-sm btn-outline-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Message</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i> Edit Role</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="member-body">
                          <div class="member-stat">
                            <span class="member-stat-label">Position</span>
                            <span class="member-stat-value">Point Guard</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Jersey Number</span>
                            <span class="member-stat-value">#23</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Joined</span>
                            <span class="member-stat-value">June 15, 2023</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Regular players -->
                    <div class="col-lg-6">
                      <div class="team-member-card">
                        <div class="member-header">
                          <div class="member-avatar">JS</div>
                          <div class="member-info">
                            <h6 class="member-name">Jane Smith</h6>
                            <div class="member-role">Player</div>
                          </div>
                          <div class="member-actions">
                            <div class="dropdown">
                              <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Message</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i> Edit Role</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star me-2"></i> Make Captain</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-minus me-2"></i> Remove</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="member-body">
                          <div class="member-stat">
                            <span class="member-stat-label">Position</span>
                            <span class="member-stat-value">Shooting Guard</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Jersey Number</span>
                            <span class="member-stat-value">#10</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Joined</span>
                            <span class="member-stat-value">June 18, 2023</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="team-member-card">
                        <div class="member-header">
                          <div class="member-avatar">MJ</div>
                          <div class="member-info">
                            <h6 class="member-name">Mike Johnson</h6>
                            <div class="member-role">Player</div>
                          </div>
                          <div class="member-actions">
                            <div class="dropdown">
                              <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Message</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i> Edit Role</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star me-2"></i> Make Captain</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-minus me-2"></i> Remove</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="member-body">
                          <div class="member-stat">
                            <span class="member-stat-label">Position</span>
                            <span class="member-stat-value">Power Forward</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Jersey Number</span>
                            <span class="member-stat-value">#34</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Joined</span>
                            <span class="member-stat-value">June 20, 2023</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="team-member-card">
                        <div class="member-header">
                          <div class="member-avatar">KP</div>
                          <div class="member-info">
                            <h6 class="member-name">Kelly Peterson</h6>
                            <div class="member-role">Player</div>
                          </div>
                          <div class="member-actions">
                            <div class="dropdown">
                              <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i> Message</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i> Edit Role</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star me-2"></i> Make Captain</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-minus me-2"></i> Remove</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="member-body">
                          <div class="member-stat">
                            <span class="member-stat-label">Position</span>
                            <span class="member-stat-value">Small Forward</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Jersey Number</span>
                            <span class="member-stat-value">#7</span>
                          </div>
                          <div class="member-stat">
                            <span class="member-stat-label">Joined</span>
                            <span class="member-stat-value">July 2, 2023</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Pending Invitations -->
                  <h5 class="mb-3 mt-4">Pending Invitations</h5>
                  
                  <div class="invitation-card">
                    <div class="invitation-icon">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="invitation-info">
                      <div class="invitation-email">alex.rodriguez@example.com</div>
                      <div class="invitation-date">Sent on May 2, 2025</div>
                    </div>
                    <div class="invitation-actions">
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel
                      </button>
                      <button class="btn btn-sm btn-outline-primary ms-2">
                        <i class="fas fa-paper-plane"></i> Resend
                      </button>
                    </div>
                  </div>
                  
                  <div class="invitation-card">
                    <div class="invitation-icon">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="invitation-info">
                      <div class="invitation-email">sarah.wilson@example.com</div>
                      <div class="invitation-date">Sent on May 8, 2025</div>
                    </div>
                    <div class="invitation-actions">
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel
                      </button>
                      <button class="btn btn-sm btn-outline-primary ms-2">
                        <i class="fas fa-paper-plane"></i> Resend
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Statistics Tab -->
          <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
            <div class="content-card">
              <div class="card-header">
                <h4 class="card-title">Team Statistics</h4>
                <p class="card-subtitle">View your team's performance metrics and season history.</p>
              </div>
              <div class="card-body">
                <!-- Team Stats Overview -->
                <div class="row g-4 mb-5">
                  <div class="col-md-3">
                    <div class="team-stat-card">
                      <div class="stat-icon-wrapper">
                        <i class="fas fa-trophy stat-icon"></i>
                      </div>
                      <div class="stat-value">12</div>
                      <div class="stat-label">Games Won</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-stat-card">
                      <div class="stat-icon-wrapper">
                        <i class="fas fa-times-circle stat-icon"></i>
                      </div>
                      <div class="stat-value">4</div>
                      <div class="stat-label">Games Lost</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-stat-card">
                      <div class="stat-icon-wrapper">
                        <i class="fas fa-percentage stat-icon"></i>
                      </div>
                      <div class="stat-value">75%</div>
                      <div class="stat-label">Win Rate</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="team-stat-card">
                      <div class="stat-icon-wrapper">
                        <i class="fas fa-medal stat-icon"></i>
                      </div>
                      <div class="stat-value">2</div>
                      <div class="stat-label">Tournaments Won</div>
                    </div>
                  </div>
                </div>
                
                <!-- Recent Games -->
                <h5 class="mb-3">Recent Games</h5>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Opponent</th>
                        <th>Location</th>
                        <th>Result</th>
                        <th>Score</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>May 5, 2025</td>
                        <td>Eagles</td>
                        <td>Home</td>
                        <td><span class="badge bg-success">Win</span></td>
                        <td>86 - 72</td>
                      </tr>
                      <tr>
                        <td>April 28, 2025</td>
                        <td>Rockets</td>
                        <td>Away</td>
                        <td><span class="badge bg-success">Win</span></td>
                        <td>92 - 88</td>
                      </tr>
                      <tr>
                        <td>April 15, 2025</td>
                        <td>Lightning</td>
                        <td>Home</td>
                        <td><span class="badge bg-danger">Loss</span></td>
                        <td>78 - 85</td>
                      </tr>
                      <tr>
                        <td>April 8, 2025</td>
                        <td>Titans</td>
                        <td>Away</td>
                        <td><span class="badge bg-success">Win</span></td>
                        <td>95 - 80</td>
                      </tr>
                      <tr>
                        <td>March 30, 2025</td>
                        <td>Dragons</td>
                        <td>Home</td>
                        <td><span class="badge bg-success">Win</span></td>
                        <td>88 - 74</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                <!-- Top Performers -->
                <h5 class="mb-3 mt-4">Top Performers</h5>
                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-3">
                      <div class="card-body">
                        <h6 class="card-title text-center">Points per Game</h6>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">MJ</div>
                          <div>
                            <div class="fw-bold">Mike Johnson</div>
                            <div class="text-muted small">Power Forward</div>
                          </div>
                          <div class="ms-auto fw-bold">18.5</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">JD</div>
                          <div>
                            <div class="fw-bold">John Doe</div>
                            <div class="text-muted small">Point Guard</div>
                          </div>
                          <div class="ms-auto fw-bold">16.2</div>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">JS</div>
                          <div>
                            <div class="fw-bold">Jane Smith</div>
                            <div class="text-muted small">Shooting Guard</div>
                          </div>
                          <div class="ms-auto fw-bold">14.8</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-3">
                      <div class="card-body">
                        <h6 class="card-title text-center">Assists per Game</h6>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">JD</div>
                          <div>
                            <div class="fw-bold">John Doe</div>
                            <div class="text-muted small">Point Guard</div>
                          </div>
                          <div class="ms-auto fw-bold">7.3</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">JS</div>
                          <div>
                            <div class="fw-bold">Jane Smith</div>
                            <div class="text-muted small">Shooting Guard</div>
                          </div>
                          <div class="ms-auto fw-bold">5.1</div>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">KP</div>
                          <div>
                            <div class="fw-bold">Kelly Peterson</div>
                            <div class="text-muted small">Small Forward</div>
                          </div>
                          <div class="ms-auto fw-bold">3.8</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-3">
                      <div class="card-body">
                        <h6 class="card-title text-center">Rebounds per Game</h6>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">MJ</div>
                          <div>
                            <div class="fw-bold">Mike Johnson</div>
                            <div class="text-muted small">Power Forward</div>
                          </div>
                          <div class="ms-auto fw-bold">9.8</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">KP</div>
                          <div>
                            <div class="fw-bold">Kelly Peterson</div>
                            <div class="text-muted small">Small Forward</div>
                          </div>
                          <div class="ms-auto fw-bold">6.5</div>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="member-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">JS</div>
                          <div>
                            <div class="fw-bold">Jane Smith</div>
                            <div class="text-muted small">Shooting Guard</div>
                          </div>
                          <div class="ms-auto fw-bold">4.2</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="text-center mt-4">
                  <a href="#" class="btn btn-outline-primary">
                    <i class="fas fa-chart-bar btn-icon"></i> View Full Statistics
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Settings Tab -->
          <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <div class="content-card">
              <div class="card-header">
                <h4 class="card-title">Team Settings</h4>
                <p class="card-subtitle">Configure team privacy, notifications, and other settings.</p>
              </div>
              <div class="card-body">
                <!-- Privacy Settings -->
                <h5 class="mb-3">Privacy Settings</h5>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="publicTeamProfile" checked>
                    <label class="form-check-label" for="publicTeamProfile">Public Team Profile</label>
                  </div>
                  <div class="form-text">When enabled, your team profile will be visible to anyone using the platform.</div>
                </div>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="showMemberList" checked>
                    <label class="form-check-label" for="showMemberList">Display Member List</label>
                  </div>
                  <div class="form-text">When enabled, your team's member list will be visible to non-members.</div>
                </div>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="allowTeamJoinRequests">
                    <label class="form-check-label" for="allowTeamJoinRequests">Allow Join Requests</label>
                  </div>
                  <div class="form-text">When enabled, other players can request to join your team without an invitation.</div>
                </div>
                
                <div class="form-group mb-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="showTeamStatistics" checked>
                    <label class="form-check-label" for="showTeamStatistics">Public Team Statistics</label>
                  </div>
                  <div class="form-text">When enabled, your team's game statistics will be publicly visible.</div>
                </div>
                
                <!-- Notification Settings -->
                <h5 class="mb-3">Notification Settings</h5>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                    <label class="form-check-label" for="emailNotifications">Email Notifications</label>
                  </div>
                  <div class="form-text">Receive email notifications about team activities and updates.</div>
                </div>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="gameReminders" checked>
                    <label class="form-check-label" for="gameReminders">Game Reminders</label>
                  </div>
                  <div class="form-text">Receive notifications about upcoming games and practices.</div>
                </div>
                
                <div class="form-group mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="memberActivityNotifications" checked>
                    <label class="form-check-label" for="memberActivityNotifications">Member Activity</label>
                  </div>
                  <div class="form-text">Receive notifications when team members join, leave, or update their profiles.</div>
                </div>
                
                <div class="form-group mb-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="tournamentNotifications" checked>
                    <label class="form-check-label" for="tournamentNotifications">Tournament Announcements</label>
                  </div>
                  <div class="form-text">Receive notifications about tournament opportunities relevant to your team.</div>
                </div>
                
                <!-- Danger Zone -->
                <div class="danger-zone">
                  <h5 class="danger-zone-header">Danger Zone</h5>
                  <p>These actions can't be undone, so please proceed with caution.</p>
                  
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                      <h6 class="mb-1">Transfer Ownership</h6>
                      <p class="mb-0 small">Transfer team ownership to another member</p>
                    </div>
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#transferOwnershipModal">
                      Transfer
                    </button>
                  </div>
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="mb-1">Delete Team</h6>
                      <p class="mb-0 small">Permanently delete this team and all its data</p>
                    </div>
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTeamModal">
                      Delete
                    </button>
                  </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                  <button type="button" class="btn btn-primary" id="saveSettingsBtn">
                    <i class="fas fa-save btn-icon"></i> Save Changes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Invite Player Modal -->
  <div class="modal fade" id="invitePlayerModal" tabindex="-1" aria-labelledby="invitePlayerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="invitePlayerModalLabel">Invite Player</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <form id="invite-player-form">
            <div class="mb-3">
              <label for="playerEmail" class="form-label">Player Email</label>
              <input type="email" class="form-control" id="playerEmail" placeholder="Enter email address" required>
              <div class="form-text">An invitation link will be sent to this email address.</div>
            </div>
            <div class="mb-3">
              <label for="playerPosition" class="form-label">Position</label>
              <select class="form-select" id="playerPosition">
                <option value="">Unspecified</option>
                <option value="point_guard">Point Guard</option>
                <option value="shooting_guard">Shooting Guard</option>
                <option value="small_forward">Small Forward</option>
                <option value="power_forward">Power Forward</option>
                <option value="center">Center</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="playerNote" class="form-label">Personal Note (Optional)</label>
              <textarea class="form-control" id="playerNote" rows="3" placeholder="Add a personal message to the invitation"></textarea>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i> Send Invitation
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Transfer Ownership Modal -->
  <div class="modal fade" id="transferOwnershipModal" tabindex="-1" aria-labelledby="transferOwnershipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="transferOwnershipModalLabel">Transfer Team Ownership</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Warning:</strong> Transferring ownership will make the selected player the new team captain and remove your captain privileges.
          </div>
          
          <form id="transfer-ownership-form">
            <div class="mb-3">
              <label for="newOwner" class="form-label">Select New Team Captain</label>
              <select class="form-select" id="newOwner" required>
                <option value="">Choose a player</option>
                <option value="jane_smith">Jane Smith</option>
                <option value="mike_johnson">Mike Johnson</option>
                <option value="kelly_peterson">Kelly Peterson</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="transferReason" class="form-label">Reason (Optional)</label>
              <textarea class="form-control" id="transferReason" rows="2" placeholder="Provide a reason for the transfer"></textarea>
            </div>
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmTransfer" required>
                <label class="form-check-label" for="confirmTransfer">
                  I understand that I will lose captain privileges for this team
                </label>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-warning">Transfer Ownership</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Delete Team Modal -->
  <div class="modal fade" id="deleteTeamModal" tabindex="-1" aria-labelledby="deleteTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteTeamModalLabel">Delete Team</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Warning:</strong> This action cannot be undone. All team data, including member records, game statistics, and history will be permanently deleted.
          </div>
          
          <form id="delete-team-form">
            <div class="mb-3">
              <label for="deleteConfirmation" class="form-label">Please type "<strong>DELETE</strong>" to confirm</label>
              <input type="text" class="form-control" id="deleteConfirmation" required placeholder="Type DELETE here">
            </div>
            <div class="mb-3">
              <label for="deleteReason" class="form-label">Reason (Optional)</label>
              <textarea class="form-control" id="deleteReason" rows="2" placeholder="Provide a reason for deleting the team"></textarea>
            </div>
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                <label class="form-check-label" for="confirmDelete">
                  I understand that all team data will be permanently deleted
                </label>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" disabled id="finalDeleteBtn">Delete Team</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Save Notification -->
  <div class="save-notification" id="saveNotification">
    <i class="fas fa-check-circle"></i>
    <span>Changes saved successfully!</span>
  </div>

  <!-- JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle form submissions
      document.getElementById('team-details-form').addEventListener('submit', function(e) {
        e.preventDefault();
        showSaveNotification();
        updateTeamHeaderInfo();
      });
      
      // Handle settings form
      document.getElementById('saveSettingsBtn').addEventListener('click', function() {
        showSaveNotification();
      });
      
      // Handle invite player form
      document.getElementById('invite-player-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // In a real implementation, this would send an AJAX request to your server
        const playerEmail = document.getElementById('playerEmail').value;
        
        // Close modal and show notification
        const modal = bootstrap.Modal.getInstance(document.getElementById('invitePlayerModal'));
        modal.hide();
        
        // Create a new pending invitation and add it to the list
        addPendingInvitation(playerEmail);
        
        showSaveNotification('Invitation sent successfully!');
      });
      
      // Handle transfer ownership form
      document.getElementById('transfer-ownership-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // In a real implementation, this would send an AJAX request to your server
        
        // Close modal and redirect to teams page (since user would no longer be captain)
        const modal = bootstrap.Modal.getInstance(document.getElementById('transferOwnershipModal'));
        modal.hide();
        
        // Show notification
        showSaveNotification('Team ownership transferred successfully!');
        
        // In a real implementation, we would redirect after a short delay
        // setTimeout(() => window.location.href = '/teams', 2000);
      });
      
      // Handle delete team form
      document.getElementById('delete-team-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // In a real implementation, this would send an AJAX request to your server
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteTeamModal'));
        modal.hide();
        
        // Show notification
        showSaveNotification('Team deleted successfully!', 'danger');
        
        // In a real implementation, we would redirect after a short delay
        // setTimeout(() => window.location.href = '/teams', 2000);
      });
      
      // Enable/disable delete button based on confirmation text
      document.getElementById('deleteConfirmation').addEventListener('input', function() {
        const deleteBtn = document.getElementById('finalDeleteBtn');
        if (this.value === 'DELETE') {
          deleteBtn.disabled = false;
        } else {
          deleteBtn.disabled = true;
        }
      });
      
      // Logo preview handling
      const logoInput = document.getElementById('teamLogo');
      const logoPreview = document.getElementById('logo-preview');
      const logoPlaceholder = document.getElementById('logo-placeholder');
      const teamLogoHeader = document.getElementById('team-logo-header');
      const teamInitial = document.getElementById('team-initial');
      
      logoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
            logoPreview.src = e.target.result;
            logoPreview.style.display = 'block';
            logoPlaceholder.style.display = 'none';
            
            // Update header logo as well
            teamLogoHeader.src = e.target.result;
            teamLogoHeader.style.display = 'block';
            teamInitial.style.display = 'none';
          }
          
          reader.readAsDataURL(this.files[0]);
        }
      });
      
      // Function to update team header info when form is saved
      function updateTeamHeaderInfo() {
        const teamName = document.getElementById('teamName').value;
        const sportType = document.getElementById('sportType').options[document.getElementById('sportType').selectedIndex].text;
        const teamSize = document.getElementById('teamSize').value;
        
        // Update header info
        document.querySelector('h2.mb-1').textContent = teamName;
        document.getElementById('team-size-display').textContent = teamSize;
        
        // Update sport icon
        let sportIcon = 'basketball-ball';
        if (sportType === 'Football') sportIcon = 'futbol';
        else if (sportType === 'Tennis') sportIcon = 'table-tennis';
        else if (sportType === 'Volleyball') sportIcon = 'volleyball-ball';
        
        document.querySelector('p.mb-0.text-muted i').className = `fas fa-${sportIcon} me-2`;
        document.querySelector('p.mb-0.text-muted').innerHTML = `<i class="fas fa-${sportIcon} me-2"></i>${sportType} • <span id="team-size-display">${teamSize}</span> Players`;
        
        // Update team initial in header logo
        teamInitial.textContent = teamName.charAt(0);
      }
      
      // Function to add a new pending invitation to the list
      function addPendingInvitation(email) {
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        
        const invitationList = document.querySelector('#members .card-body');
        const newInvitation = document.createElement('div');
        newInvitation.className = 'invitation-card';
        newInvitation.innerHTML = `
          <div class="invitation-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="invitation-info">
            <div class="invitation-email">${email}</div>
            <div class="invitation-date">Sent on ${formattedDate}</div>
          </div>
          <div class="invitation-actions">
            <button class="btn btn-sm btn-outline-danger">
              <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn btn-sm btn-outline-primary ms-2">
              <i class="fas fa-paper-plane"></i> Resend
            </button>
          </div>
        `;
        
        // Insert the new invitation after the "Pending Invitations" heading
        const pendingInvitationsHeading = document.querySelector('#members .card-body h5.mb-3.mt-4');
        pendingInvitationsHeading.insertAdjacentElement('afterend', newInvitation);
        
        // Add event listeners to the new buttons
        const cancelButton = newInvitation.querySelector('.btn-outline-danger');
        cancelButton.addEventListener('click', function() {
          newInvitation.remove();
          showSaveNotification('Invitation cancelled');
        });
        
        const resendButton = newInvitation.querySelector('.btn-outline-primary');
        resendButton.addEventListener('click', function() {
          showSaveNotification('Invitation resent successfully!');
        });
      }
      
      // Function to show save notification
      function showSaveNotification(message = 'Changes saved successfully!', type = 'success') {
        const notification = document.getElementById('saveNotification');
        notification.textContent = '';
        
        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        notification.appendChild(icon);
        
        const span = document.createElement('span');
        span.textContent = message;
        notification.appendChild(span);
        
        notification.style.backgroundColor = type === 'success' ? 'var(--success-color)' : 'var(--danger-color)';
        
        notification.classList.add('show');
        
        setTimeout(() => {
          notification.classList.remove('show');
        }, 3000);
      }
    });
  </script>
</body>
</html>