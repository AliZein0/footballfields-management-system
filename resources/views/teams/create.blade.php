<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    .color-preview {
      width: 100%;
      height: 100px;
      border-radius: 0.5rem;
      margin-top: 1rem;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
    }
    .player-template {
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      padding: 1rem;
      margin-bottom: 1rem;
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
    .jersey-preview {
      width: 100px;
      height: 150px;
      background-color: #f8f9fa;
      margin: 0 auto;
      position: relative;
      border-radius: 15px 15px 0 0;
    }
    .jersey-number {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2rem;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-trophy me-2"></i>TeamBuilder</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">Create Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">My Teams</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Help</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-xl-10">
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
            <div class="step-title">Roster Setup</div>
          </div>
          <div class="step">
            <div class="step-number">5</div>
            <div class="step-title">Review & Finish</div>
          </div>
        </div>
        
        <!-- Steps Content -->
        <div class="tab-content">
          <!-- Step 1: Select Sport -->
          <div id="step1" class="tab-pane fade show active">
            <h4 class="mb-4">Select Your Sport</h4>
            <div class="row g-4">
              <div class="col-md-4 col-6">
                <div class="card sport-card selected h-100 text-center">
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
                <div class="card sport-card h-100 text-center">
                  <div class="card-body">
                    <div class="sport-icon bg-success text-white">
                      <i class="fas fa-futbol fa-3x"></i>
                    </div>
                    <h5 class="card-title">Soccer</h5>
                    <p class="card-text small text-muted">11 players on field</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card sport-card h-100 text-center">
                  <div class="card-body">
                    <div class="sport-icon bg-danger text-white">
                      <i class="fas fa-football fa-3x"></i>
                    </div>
                    <h5 class="card-title">Football</h5>
                    <p class="card-text small text-muted">11 players per side</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card sport-card h-100 text-center">
                  <div class="card-body">
                    <div class="sport-icon bg-warning text-dark">
                      <i class="fas fa-baseball-ball fa-3x"></i>
                    </div>
                    <h5 class="card-title">Baseball</h5>
                    <p class="card-text small text-muted">9 players on field</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card sport-card h-100 text-center">
                  <div class="card-body">
                    <div class="sport-icon bg-info text-white">
                      <i class="fas fa-hockey-puck fa-3x"></i>
                    </div>
                    <h5 class="card-title">Hockey</h5>
                    <p class="card-text small text-muted">6 players on ice</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="card sport-card h-100 text-center">
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
              <button class="btn btn-primary px-4" id="step1Next">Continue</button>
            </div>
          </div>
          
          <!-- Step 2: Team Details -->
          <div id="step2" class="tab-pane fade">
            <h4 class="mb-4">Enter Team Details</h4>
            <form>
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="teamName" placeholder="Team Name">
                    <label for="teamName">Team Name *</label>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <select class="form-select" id="teamSize">
                        <option>5 players (minimum)</option>
                        <option>10 players</option>
                        <option>12 players</option>
                        <option>15 players</option>
                        <option>18 players</option>
                        <option>20+ players</option>
                      </select>
                      <label for="teamSize">Team Size *</label>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <textarea class="form-control" id="teamDescription" style="height: 100px" placeholder="Team Description"></textarea>
                    <label for="teamDescription">Team Description</label>
                  </div>
                </div>
                <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="homeVenue" placeholder="Home Venue">
                    <label for="homeVenue">Home Venue</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="foundingDate">
                    <label for="foundingDate">Founded Date</label>
                  </div>
                </div>
            </div>
              <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-outline-secondary px-4" id="step2Prev">Back</button>
                <button class="btn btn-primary px-4" id="step2Next">Continue</button>
              </div>
            </form>
          </div>
          
          <!-- Step 3: Team Identity -->
          <div id="step3" class="tab-pane fade">
            <h4 class="mb-4">Create Team Identity</h4>
            <div class="row g-4">
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title">Team Logo</h5>
                    <div class="logo-preview mb-3">
                      <i class="fas fa-cloud-upload-alt fa-3x"></i>
                    </div>
                    <div class="d-grid">
                      <button class="btn btn-outline-primary">Upload Logo</button>
                    </div>
                    <p class="small text-muted mt-2">
                      Recommended size: at least 500x500 pixels. Max file size: 5MB.
                    </p>
                  </div>
                </div>
              </div>
             
             
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title">Team Motto & Social</h5>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="teamMotto" placeholder="Team Motto">
                      <label for="teamMotto">Team Motto/Slogan</label>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Social Media Handles</label>
                      <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                        <input type="text" class="form-control" placeholder="Twitter handle">
                      </div>
                      <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                        <input type="text" class="form-control" placeholder="Instagram handle">
                      </div>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                        <input type="text" class="form-control" placeholder="Facebook page">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
              <button class="btn btn-outline-secondary px-4" id="step3Prev">Back</button>
              <button class="btn btn-primary px-4" id="step3Next">Continue</button>
            </div>
          </div>
          
        <!-- Step 4: Roster Setup -->
<div id="step4" class="tab-pane fade">
    <h4 class="mb-4">Setup Your Roster</h4>
    <div class="alert alert-info">
      <i class="fas fa-info-circle me-2"></i> Start by setting your roster structure. You can then browse and invite registered players to join your team.
    </div>
    
    <div class="card mb-4">
      <div class="card-header bg-light">
        <h5 class="mb-0">Roster Structure</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <div class="form-floating">
              <select class="form-select" id="totalPlayers">
                <option>12 players</option>
                <option>15 players</option>
                <option>18 players</option>
                <option>20 players</option>
                <option>Custom</option>
              </select>
              <label for="totalPlayers">Total Players</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating">
              <select class="form-select" id="startingPlayers">
                <option>5 players</option>
                <option>6 players</option>
                <option>7 players</option>
                <option>9 players</option>
                <option>11 players</option>
              </select>
              <label for="startingPlayers">Starting Players</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating">
              <select class="form-select" id="captainNumber">
                <option>1 captain</option>
                <option>2 co-captains</option>
                <option>3 captains</option>
                <option>No captains</option>
              </select>
              <label for="captainNumber">Team Captain(s)</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0">Position Requirements</h5>
          </div>
          <div class="card-body">
            <p class="text-muted mb-3">Define positions for your basketball team:</p>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-2">
                <label>Point Guards (PG)</label>
                <div class="input-group input-group-sm" style="width: 120px">
                  <button class="btn btn-outline-secondary">-</button>
                  <input type="text" class="form-control text-center" value="2">
                  <button class="btn btn-outline-secondary">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <label>Shooting Guards (SG)</label>
                <div class="input-group input-group-sm" style="width: 120px">
                  <button class="btn btn-outline-secondary">-</button>
                  <input type="text" class="form-control text-center" value="2">
                  <button class="btn btn-outline-secondary">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <label>Small Forwards (SF)</label>
                <div class="input-group input-group-sm" style="width: 120px">
                  <button class="btn btn-outline-secondary">-</button>
                  <input type="text" class="form-control text-center" value="2">
                  <button class="btn btn-outline-secondary">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <label>Power Forwards (PF)</label>
                <div class="input-group input-group-sm" style="width: 120px">
                  <button class="btn btn-outline-secondary">-</button>
                  <input type="text" class="form-control text-center" value="3">
                  <button class="btn btn-outline-secondary">+</button>
                </div>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <label>Centers (C)</label>
                <div class="input-group input-group-sm" style="width: 120px">
                  <button class="btn btn-outline-secondary">-</button>
                  <input type="text" class="form-control text-center" value="3">
                  <button class="btn btn-outline-secondary">+</button>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <span>Total:</span>
              <span class="fw-bold">12 players</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0">Player Requirements</h5>
          </div>
          <div class="card-body">
            <p class="text-muted mb-3">Set minimum requirements for players:</p>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqExp">
              <label class="form-check-label" for="reqExp">Minimum 1 year experience</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqHeight">
              <label class="form-check-label" for="reqHeight">Minimum height requirement</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqAge">
              <label class="form-check-label" for="reqAge">Age range (18-40)</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqLocation">
              <label class="form-check-label" for="reqLocation">Within 25 miles of home venue</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqAvailability">
              <label class="form-check-label" for="reqAvailability">Available for weekend games</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="reqVerified">
              <label class="form-check-label" for="reqVerified">Verified players only</label>
            </div>
            <button class="btn btn-sm btn-outline-primary mt-2">Add Custom Requirement</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mt-4">
      <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Browse Registered Players</h5>
        <div class="input-group" style="max-width: 300px;">
          <input type="text" class="form-control" placeholder="Search players...">
          <button class="btn btn-outline-secondary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="form-floating">
              <select class="form-select" id="positionFilter">
                <option value="">All Positions</option>
                <option>Point Guard</option>
                <option>Shooting Guard</option>
                <option>Small Forward</option>
                <option>Power Forward</option>
                <option>Center</option>
              </select>
              <label for="positionFilter">Position</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select class="form-select" id="locationFilter">
                <option value="">All Locations</option>
                <option>Within 5 miles</option>
                <option>Within 10 miles</option>
                <option>Within 25 miles</option>
                <option>Within 50 miles</option>
              </select>
              <label for="locationFilter">Location</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select class="form-select" id="experienceFilter">
                <option value="">Any Experience</option>
                <option>Beginner (0-1 years)</option>
                <option>Intermediate (2-5 years)</option>
                <option>Advanced (5+ years)</option>
                <option>Professional</option>
              </select>
              <label for="experienceFilter">Experience</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating">
              <select class="form-select" id="sortBy">
                <option value="rating">Rating (High to Low)</option>
                <option value="experience">Experience (Most first)</option>
                <option value="name">Name (A to Z)</option>
                <option value="age">Age (Youngest first)</option>
              </select>
              <label for="sortBy">Sort By</label>
            </div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Player</th>
                <th>Position</th>
                <th>Height</th>
                <th>Experience</th>
                <th>Rating</th>
                <th>Location</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div style="width: 40px; height: 40px; background-color: #0d6efd; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                      MJ
                    </div>
                    <div>
                      <div class="fw-bold">Michael Johnson</div>
                      <small class="text-muted">Age: 26</small>
                    </div>
                  </div>
                </td>
                <td>Point Guard</td>
                <td>6'2"</td>
                <td>5 years</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">4.8</div>
                    <div>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                  </div>
                </td>
                <td>2.4 miles away</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Send Invite</button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div style="width: 40px; height: 40px; background-color: #198754; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                      JD
                    </div>
                    <div>
                      <div class="fw-bold">James Davis</div>
                      <small class="text-muted">Age: 24</small>
                    </div>
                  </div>
                </td>
                <td>Center</td>
                <td>6'10"</td>
                <td>3 years</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">4.5</div>
                    <div>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                  </div>
                </td>
                <td>5.7 miles away</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Send Invite</button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div style="width: 40px; height: 40px; background-color: #dc3545; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                      SL
                    </div>
                    <div>
                      <div class="fw-bold">Sarah Lee</div>
                      <small class="text-muted">Age: 23</small>
                    </div>
                  </div>
                </td>
                <td>Small Forward</td>
                <td>5'11"</td>
                <td>4 years</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">4.2</div>
                    <div>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="far fa-star text-warning"></i>
                    </div>
                  </div>
                </td>
                <td>3.2 miles away</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Send Invite</button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div style="width: 40px; height: 40px; background-color: #6610f2; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                      TW
                    </div>
                    <div>
                      <div class="fw-bold">Tyler Wong</div>
                      <small class="text-muted">Age: 28</small>
                    </div>
                  </div>
                </td>
                <td>Power Forward</td>
                <td>6'7"</td>
                <td>7 years</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">4.9</div>
                    <div>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                    </div>
                  </div>
                </td>
                <td>1.8 miles away</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Send Invite</button>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div style="width: 40px; height: 40px; background-color: #fd7e14; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                      BP
                    </div>
                    <div>
                      <div class="fw-bold">Brian Peters</div>
                      <small class="text-muted">Age: 22</small>
                    </div>
                  </div>
                </td>
                <td>Shooting Guard</td>
                <td>6'4"</td>
                <td>2 years</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-2">3.8</div>
                    <div>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star text-warning"></i>
                      <i class="fas fa-star-half-alt text-warning"></i>
                      <i class="far fa-star text-warning"></i>
                    </div>
                  </div>
                </td>
                <td>7.3 miles away</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary">Send Invite</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <nav aria-label="Player search results pagination">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    
    <div class="card mt-4">
      <div class="card-header bg-light">
        <h5 class="mb-0">Sent Invitations (3)</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div style="width: 50px; height: 50px; background-color: #0d6efd; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                    RB
                  </div>
                  <div>
                    <div class="fw-bold">Robert Brown</div>
                    <div class="small text-muted">Point Guard</div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Status:</span>
                  <span class="badge bg-warning text-dark">Pending</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Sent:</span>
                  <span class="small">1 day ago</span>
                </div>
                <hr>
                <div class="d-grid">
                  <button class="btn btn-sm btn-outline-danger">Cancel Invitation</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div style="width: 50px; height: 50px; background-color: #198754; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                    KJ
                  </div>
                  <div>
                    <div class="fw-bold">Kelly Johnson</div>
                    <div class="small text-muted">Shooting Guard</div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Status:</span>
                  <span class="badge bg-success">Accepted</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Sent:</span>
                  <span class="small">2 days ago</span>
                </div>
                <hr>
                <div class="d-grid">
                  <button class="btn btn-sm btn-success disabled">Invitation Accepted</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div style="width: 50px; height: 50px; background-color: #dc3545; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                    MT
                  </div>
                  <div>
                    <div class="fw-bold">Mark Thompson</div>
                    <div class="small text-muted">Center</div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Status:</span>
                  <span class="badge bg-danger">Declined</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Sent:</span>
                  <span class="small">3 days ago</span>
                </div>
                <hr>
                <div class="d-grid">
                  <button class="btn btn-sm btn-outline-primary">Send New Invitation</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
      <button class="btn btn-outline-secondary px-4" id="step4Prev">Back</button>
      <button class="btn btn-primary px-4" id="step4Next">Continue</button>
    </div>
  </div>
          
           <!-- Step 5: Review & Finish -->
           <div id="step5" class="tab-pane fade show active">
            <h4 class="mb-4">Review Your Team</h4>
            <div class="alert alert-success mb-4">
              <i class="fas fa-check-circle me-2"></i> Your team setup is almost complete! Review the details below and finish the creation process.
            </div>
            
            <div class="row g-4">
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Team Summary</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex mb-4">
                      <div style="width: 80px; height: 80px; background-color: #0d6efd; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; margin-right: 15px;">
                        TB
                      </div>
                      <div>
                        <h4 class="mb-1">The Bulldogs</h4>
                        <div class="text-muted">Basketball | Professional</div>
                        <div class="small text-muted">Washington, DC</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center">
                      <div class="summary-icon bg-light">
                        <i class="fas fa-users text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Team Size</div>
                        <div>12 Players</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center">
                      <div class="summary-icon bg-light">
                        <i class="fas fa-user-tie text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Captain</div>
                        <div>Mike Johnson</div>
                      </div>
                    </div>
                    
                    <div class="team-summary-item d-flex align-items-center">
                      <div class="summary-icon bg-light">
                        <i class="fas fa-building text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Home Venue</div>
                        <div>Capital Arena</div>
                      </div>
                    </div>
                    
                   
                    
                    <div class="team-summary-item d-flex align-items-center">
                      <div class="summary-icon bg-light">
                        <i class="fas fa-bullhorn text-primary"></i>
                      </div>
                      <div>
                        <div class="text-muted small">Team Motto</div>
                        <div>"Hustle, Heart, and Hardwood"</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Roster Summary</h5>
                  </div>
                  <div class="card-body">
                    <div class="mb-4">
                      <h6>Position Breakdown</h6>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Point Guards (PG)</span>
                        <span>2 players</span>
                      </div>
                      <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 17%"></div>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-2">
                        <span>Shooting Guards (SG)</span>
                        <span>2 players</span>
                      </div>
                      <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 17%"></div>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-2">
                        <span>Small Forwards (SF)</span>
                        <span>2 players</span>
                      </div>
                      <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 17%"></div>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-2">
                        <span>Power Forwards (PF)</span>
                        <span>3 players</span>
                      </div>
                      <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"></div>
                      </div>
                      
                      <div class="d-flex justify-content-between mb-2">
                        <span>Centers (C)</span>
                        <span>3 players</span>
                      </div>
                      <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"></div>
                      </div>
                    </div>
                    
                    <h6>Player Information Requirements</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                      <span class="badge bg-primary">Full Name</span>
                      <span class="badge bg-primary">Jersey Number</span>
                      <span class="badge bg-primary">Position</span>
                      <span class="badge bg-primary">Height</span>
                      <span class="badge bg-secondary">Weight</span>
                      <span class="badge bg-secondary">Age</span>
                      <span class="badge bg-secondary">Experience</span>
                      <span class="badge bg-secondary">Photo</span>
                    </div>
                    
                    <div class="alert alert-info small">
                      <i class="fas fa-info-circle me-2"></i> After completing team creation, you'll be directed to the team management dashboard where you can add individual players.
                    </div>
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
              <button class="btn btn-outline-secondary px-4" id="step5Prev">Back</button>
              <button class="btn btn-success px-5" id="createTeamBtn">
                <i class="fas fa-check me-2"></i> Create Team
              </button>
            </div>
          </div>

          <!-- Success Modal -->
          <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title">Team Created Successfully!</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                  <div class="mb-4">
                    <i class="fas fa-check-circle text-success fa-5x"></i>
                  </div>
                  <h4>Congratulations!</h4>
                  <p class="mb-4">Your team "The Bulldogs" has been created successfully.</p>
                  <div class="d-grid">
                    <a href="team-dashboard.html" class="btn btn-primary">
                      <i class="fas fa-arrow-right me-2"></i> Go to Team Dashboard
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white mt-5 py-4">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5>TeamBuilder</h5>
          <p class="small">The ultimate platform for creating and managing your sports teams.</p>
        </div>
        <div class="col-md-3">
          <h6>Links</h6>
          <ul class="list-unstyled small">
            <li><a href="#" class="text-white-50">Help Center</a></li>
            <li><a href="#" class="text-white-50">Pricing</a></li>
            <li><a href="#" class="text-white-50">Contact Us</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Connect</h6>
          <div class="d-flex gap-2">
            <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="border-top border-secondary mt-3 pt-3 d-flex justify-content-between">
        <div class="small text-muted">© 2025 TeamBuilder. All rights reserved.</div>
        <div class="small text-muted">Terms | Privacy</div>
      </div>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
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
        tabPanes[currentStep - 1].classList.remove('show', 'active');
        tabPanes[nextStep - 1].classList.add('show', 'active');
        updateStepIndicator(nextStep);
      }
  
      // Step 1 navigation
      document.getElementById('step1Next').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(1, 2);
      });
  
      // Step 2 navigation
      document.getElementById('step2Prev').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(2, 1);
      });
      document.getElementById('step2Next').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(2, 3);
      });
  
      // Step 3 navigation
      document.getElementById('step3Prev').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(3, 2);
      });
      document.getElementById('step3Next').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(3, 4);
      });
  
      // Step 4 navigation
      document.getElementById('step4Prev').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(4, 3);
      });
      document.getElementById('step4Next').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(4, 5);
      });
  
      // Step 5 navigation
      document.getElementById('step5Prev').addEventListener('click', function (e) {
        e.preventDefault();
        navigateToStep(5, 4);
      });
  
      // Color pickers
      const primaryColorPicker = document.getElementById('primaryColor');
      const secondaryColorPicker = document.getElementById('secondaryColor');
      const colorPreview = document.querySelector('.color-preview');
      const homeJersey = document.querySelector('.jersey-preview:first-child');
      const awayJersey = document.querySelector('.jersey-preview:last-child');
  
      primaryColorPicker.addEventListener('input', function () {
        colorPreview.style.backgroundColor = this.value;
        homeJersey.style.backgroundColor = this.value;
      });
  
      secondaryColorPicker.addEventListener('input', function () {
        awayJersey.style.backgroundColor = this.value;
      });
  
      // Team creation button
      document.getElementById('createTeamBtn').addEventListener('click', function () {
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
      });
  
      // Sport selection
      const sportCards = document.querySelectorAll('.sport-card');
      sportCards.forEach((card) => {
        card.addEventListener('click', function () {
          sportCards.forEach((c) => c.classList.remove('selected'));
          this.classList.add('selected');
        });
      });
      
    });
  </script>
</body>
</html>