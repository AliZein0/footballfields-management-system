<x-layout title="Player-Profile">
<body class="d-flex flex-column min-vh-100 player-profile-page bg-light" >
  <!-- Original Navbar - Left untouched -->
<x-player_header></x-player_header>

  <!-- Main Content - Added padding-top to prevent navbar overlap -->
  <main class="container py-5 flex-grow-1 mt-5" >
    <div class="row g-4">
      <!-- Profile Sidebar -->
      <div class="col-md-4 col-lg-3">
        <div class="card shadow border-0 rounded-3">
          <div class="card-header bg-success text-white p-3">
            <h5 class="mb-0">Player Profile</h5>
          </div>
          <div class="card-body text-center bg-white">
            <div class="position-relative mb-4">
              <img 
                src="https://th.bing.com/th/id/OIP.k6-0bR_5ijgMASJ1yl_NiQHaHa?w=250&h=250&c=8&rs=1&qlt=90&o=6&dpr=1.1&pid=3.1&rm=2" 
                alt="Player profile" 
                class="rounded-circle profile-img border border-4 border-white mb-3"
                style="width: 120px; height: 120px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
              />
              <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1" 
                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                <i class="bi bi-check"></i>
              </span>
            </div>
            <h2 class="h5 fw-bold">Alex Johnson</h2>
            <p class="text-muted small mb-3">Member since March 2024</p>
            <div class="d-grid">
              <button class="btn btn-outline-success btn-sm">
                <i class="bi bi-pencil-square me-2"></i>Edit Profile
              </button>
            </div>
            
            <hr class="my-4">
            
            <div class="nav nav-pills flex-column" id="profile-tabs" role="tablist">
              <button 
                class="nav-link active text-start mb-2 d-flex align-items-center" 
                data-tab="profile"
                type="button"
              >
                <i class="bi bi-person me-3"></i> <span>Profile</span>
              </button>
              <button 
                class="nav-link text-start mb-2 d-flex align-items-center" 
                data-tab="bookings"
                type="button"
              >
                <i class="bi bi-calendar me-3"></i> <span>My Bookings</span>
              </button>
              <button 
                class="nav-link text-start mb-2 d-flex align-items-center" 
                data-tab="venues"
                type="button"
              >
                <i class="bi bi-geo-alt me-3"></i> <span>Favorite Venues</span>
              </button>
              <button 
                class="nav-link text-start mb-2 d-flex align-items-center" 
                data-tab="stats"
                type="button"
              >
                <i class="bi bi-graph-up me-3"></i> <span>My Statistics</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Area -->
      <div class="col-md-8 col-lg-9">
        <div class="card shadow border-0 rounded-3">
          <div class="card-body p-4">
            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content active">
              <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h3 class="card-title fs-4 mb-0">Personal Information</h3>
                <div>
                  <button class="btn btn-success me-2">
                    <i class="bi bi-pencil me-2"></i>Edit Profile
                  </button>
                  <button class="btn btn-outline-secondary">
                    <i class="bi bi-lock me-2"></i>Change Password
                  </button>
                </div>
              </div>
              
              <div class="row g-4">
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Full Name</label>
                    <p class="mb-0 fw-medium">Alex Johnson</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Email Address</label>
                    <p class="mb-0 fw-medium">alex.johnson@example.com</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Phone Number</label>
                    <p class="mb-0 fw-medium">(555) 123-4567</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Member Since</label>
                    <p class="mb-0 fw-medium">March 2024</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Location</label>
                    <p class="mb-0 fw-medium">New York, NY</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="p-3 bg-light rounded-3">
                    <label class="form-label text-muted small mb-1">Preferred Sports</label>
                    <p class="mb-0 fw-medium">
                      <span class="badge bg-success me-1">Soccer</span>
                      <span class="badge bg-info me-1">Tennis</span>
                      <span class="badge bg-success">Basketball</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bookings Tab -->
            <div id="bookings-tab" class="tab-content">
              <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h3 class="card-title fs-4 mb-0">My Bookings</h3>
                <button class="btn btn-success">
                  <i class="bi bi-calendar-plus me-2"></i>Book a Venue
                </button>
              </div>
              
              <div class="mb-4">
                <h5 class="text-muted mb-3">Upcoming Bookings</h5>
                <div class="list-group">
                  <div class="list-group-item list-group-item-action border-0 shadow-sm rounded-3 p-3 mb-3">
                    <div class="row align-items-center">
                      <div class="col-md-1 text-center text-success mb-3 mb-md-0">
                        <i class="bi bi-calendar-event fs-3"></i>
                      </div>
                      <div class="col-md-3 mb-3 mb-md-0">
                        <span class="badge bg-success mb-2">Soccer</span>
                        <h6 class="mb-1">Riverside Soccer Complex</h6>
                        <p class="text-muted mb-0 small">Field #3</p>
                      </div>
                      <div class="col-md-5 mb-3 mb-md-0">
                        <div class="d-flex align-items-center small text-muted mb-2">
                          <i class="bi bi-calendar me-2"></i>
                          <span class="me-3">April 15, 2025</span>
                        </div>
                        <div class="d-flex align-items-center small text-muted">
                          <i class="bi bi-clock me-2"></i>
                          <span>6:00 PM - 8:00 PM</span>
                        </div>
                      </div>
                      <div class="col-md-3 text-md-end">
                        <button class="btn btn-sm btn-outline-success me-1">
                          <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-x-circle"></i> Cancel
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="list-group-item list-group-item-action border-0 shadow-sm rounded-3 p-3">
                    <div class="row align-items-center">
                      <div class="col-md-1 text-center text-info mb-3 mb-md-0">
                        <i class="bi bi-calendar-event fs-3"></i>
                      </div>
                      <div class="col-md-3 mb-3 mb-md-0">
                        <span class="badge bg-info mb-2">Tennis</span>
                        <h6 class="mb-1">Central Tennis Courts</h6>
                        <p class="text-muted mb-0 small">Court #2</p>
                      </div>
                      <div class="col-md-5 mb-3 mb-md-0">
                        <div class="d-flex align-items-center small text-muted mb-2">
                          <i class="bi bi-calendar me-2"></i>
                          <span class="me-3">April 18, 2025</span>
                        </div>
                        <div class="d-flex align-items-center small text-muted">
                          <i class="bi bi-clock me-2"></i>
                          <span>4:30 PM - 6:00 PM</span>
                        </div>
                      </div>
                      <div class="col-md-3 text-md-end">
                        <button class="btn btn-sm btn-outline-success me-1">
                          <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                          <i class="bi bi-x-circle"></i> Cancel
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="text-center mt-4">
                <button class="btn btn-outline-success">
                  <i class="bi bi-clock-history me-2"></i>View Booking History
                </button>
              </div>
            </div>

            <!-- Venues Tab -->
            <div id="venues-tab" class="tab-content">
              <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h3 class="card-title fs-4 mb-0">Favorite Venues</h3>
                <button class="btn btn-success">
                  <i class="bi bi-search me-2"></i>Find New Venues
                </button>
              </div>
              
              <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                  <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                      <img src="/api/placeholder/400/200" class="card-img-top" alt="Riverside Soccer Complex">
                      <span class="position-absolute top-0 end-0 bg-white m-2 p-2 rounded-circle">
                        <i class="bi bi-star-fill text-warning"></i>
                      </span>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Riverside Soccer Complex</h5>
                      </div>
                      <p class="card-text text-muted small mb-3">
                        <i class="bi bi-geo-alt me-1"></i>123 River Rd
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">Last visited: 2 days ago</p>
                        <button class="btn btn-success btn-sm">Book Now</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                  <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                      <img src="/api/placeholder/400/200" class="card-img-top" alt="Central Tennis Courts">
                      <span class="position-absolute top-0 end-0 bg-white m-2 p-2 rounded-circle">
                        <i class="bi bi-star-fill text-warning"></i>
                      </span>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Central Tennis Courts</h5>
                      </div>
                      <p class="card-text text-muted small mb-3">
                        <i class="bi bi-geo-alt me-1"></i>45 Park Ave
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">Last visited: 1 week ago</p>
                        <button class="btn btn-success btn-sm">Book Now</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                  <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                      <img src="/api/placeholder/400/200" class="card-img-top" alt="Westside Basketball Courts">
                      <span class="position-absolute top-0 end-0 bg-white m-2 p-2 rounded-circle">
                        <i class="bi bi-star-fill text-warning"></i>
                      </span>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Westside Basketball Courts</h5>
                      </div>
                      <p class="card-text text-muted small mb-3">
                        <i class="bi bi-geo-alt me-1"></i>78 West Blvd
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">Last visited: 2 weeks ago</p>
                        <button class="btn btn-success btn-sm">Book Now</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Stats Tab -->
            <div id="stats-tab" class="tab-content">
              <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h3 class="card-title fs-4 mb-0">My Statistics</h3>
                <div class="btn-group btn-group-sm">
                  <button class="btn btn-outline-success active">All Time</button>
                  <button class="btn btn-outline-success">This Month</button>
                  <button class="btn btn-outline-success">This Week</button>
                </div>
              </div>
              
              <div class="row g-4 mb-4">
                <div class="col-md-3">
                  <div class="card bg-success bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body text-center p-4">
                      <i class="bi bi-calendar-check text-success fs-3 mb-3"></i>
                      <h2 class="display-6 fw-bold mb-1">37</h2>
                      <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card bg-success bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body text-center p-4">
                      <i class="bi bi-calendar text-success fs-3 mb-3"></i>
                      <h2 class="display-6 fw-bold mb-1">5</h2>
                      <p class="text-muted mb-0">Bookings This Month</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card bg-info bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body text-center p-4">
                      <i class="bi bi-building text-info fs-3 mb-3"></i>
                      <h2 class="display-6 fw-bold mb-1">3</h2>
                      <p class="text-muted mb-0">Favorite Venues</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="card bg-warning bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body text-center p-4">
                      <i class="bi bi-stopwatch text-warning fs-3 mb-3"></i>
                      <h2 class="display-6 fw-bold mb-1">1.5</h2>
                      <p class="text-muted mb-0">Average Play Time</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row g-4">
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                      <h5 class="card-title mb-0">Sport Preferences</h5>
                    </div>
                    <div class="card-body">
                      <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                          <span>Soccer</span>
                          <span class="text-muted">65%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                          <span>Tennis</span>
                          <span class="text-muted">25%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-info" role="progressbar" style="width: 25%"></div>
                        </div>
                      </div>
                      <div>
                        <div class="d-flex justify-content-between mb-1">
                          <span>Basketball</span>
                          <span class="text-muted">10%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 10%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0">
                      <h5 class="card-title mb-0">Most Visited Venues</h5>
                    </div>
                    <div class="card-body">
                      <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                          <span>Riverside Soccer Complex</span>
                          <span class="text-muted">18 visits</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                          <span>Central Tennis Courts</span>
                          <span class="text-muted">12 visits</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-info" role="progressbar" style="width: 50%"></div>
                        </div>
                      </div>
                      <div>
                        <div class="d-flex justify-content-between mb-1">
                          <span>Westside Basketball Courts</span>
                          <span class="text-muted">7 visits</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 30%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="mt-4">
                <h5 class="text-muted mb-3">Achievements</h5>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="card border-0 bg-success bg-opacity-10 rounded-3">
                      <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle bg-white p-3 me-3 shadow-sm">
                          <i class="bi bi-award text-success fs-4"></i>
                        </div>
                        <div>
                          <h6 class="card-title fw-bold mb-1">Regular Player</h6>
                          <p class="card-text small text-muted mb-0">5+ bookings per month</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card border-0 bg-success bg-opacity-10 rounded-3">
                      <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle bg-white p-3 me-3 shadow-sm">
                          <i class="bi bi-trophy text-success fs-4"></i>
                        </div>
                        <div>
                          <h6 class="card-title fw-bold mb-1">Venue Explorer</h6>
                          <p class="card-text small text-muted mb-0">Visited 5+ different venues</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
 
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Tab switching functionality
      const tabButtons = document.querySelectorAll('[data-tab]');
      const tabContents = document.querySelectorAll('.tab-content');
      
      tabButtons.forEach(button => {
        button.addEventListener('click', function() {
          const tabName = this.getAttribute('data-tab');
          
          // Update active tab button
          tabButtons.forEach(btn => {
            btn.classList.remove('active');
          });
          this.classList.add('active');
          
          // Show active tab content
          tabContents.forEach(content => {
            content.classList.remove('active');
          });
          document.getElementById(`${tabName}-tab`).classList.add('active');
        });
      });
      
      // Mobile navigation toggle
      const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
      const navmenu = document.querySelector('.navmenu ul');
      
      if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function() {
          navmenu.classList.toggle('d-block');
          this.classList.toggle('bi-list');
          this.classList.toggle('bi-x');
        });
      }
    });
  </script>


</x-layout>