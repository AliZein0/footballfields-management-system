<x-layout title="Player Profile" bodyClass="player-profile-page bg-light">
    <x-player_header />
    
    <!-- Navbar Separator -->
    <div class="navbar-separator"></div>
    
    <!-- Content spacer -->
    <div class="content-spacer"></div>
    
    <!-- Main Content -->
    <main class="container py-4">
        <div class="row g-4">
            <!-- Profile Sidebar -->
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm">
                    <div class="card-header bg-primary text-white p-3 border-0">
                        <h5 class="mb-0 fw-semibold">Player Profile</h5>
                    </div>
                    <div class="card-body text-center bg-white p-4">
                        <div class="position-relative mb-4">
                            <img 
                                src="{{ $player->user->profile_photo_url ?? 'https://th.bing.com/th/id/OIP.k6-0bR_5ijgMASJ1yl_NiQHaHa?w=250&h=250&c=8&rs=1&qlt=90&o=6&dpr=1.1&pid=3.1&rm=2' }}" 
                                alt="Player profile" 
                                class="rounded-circle profile-img border border-3 border-white mb-3"
                                style="width: 120px; height: 120px; object-fit: cover;"
                            />
                            <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1" 
                                  style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                        <h2 class="h5 fw-bold mb-1">{{ $player->user->name }}</h2>
                        <p class="text-muted small mb-3">Member since {{ $player->member_since_formatted }}</p>
                        <div class="d-grid">
                            <button id="edit-profile-btn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </button>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="profile-nav">
                            <div class="nav flex-column" id="profile-tabs">
                                <a href="#profile-tab" class="nav-link active text-start mb-2 d-flex align-items-center" data-tab="profile">
                                    <i class="fas fa-user me-3"></i> <span>Profile</span>
                                </a>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="col-md-8 col-lg-9">
                <div class="card border-0 rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Profile Tab -->
                        <div id="profile-tab" class="tab-content active">
                            <!-- View Mode -->
                            <div id="profile-view-mode" class="profile-mode active">
                                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                    <h3 class="card-title h4 mb-0 fw-bold">Personal Information</h3>
                                    <div>
                                        <button id="toggle-edit-mode" class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-pencil-alt me-2"></i>Edit Profile
                                        </button>
                                        <button id="toggle-password-modal" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                            <i class="fas fa-lock me-2"></i>Change Password
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Full Name</label>
                                            <p class="mb-0 fw-medium">{{ $player->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Phone Number</label>
                                            <p class="mb-0 fw-medium">{{ $player->user->phone_number ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Member Since</label>
                                            <p class="mb-0 fw-medium">{{ $player->member_since_formatted }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Account Status</label>
                                            <p class="mb-0 fw-medium">
                                                <span class="badge bg-success">Active</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Location</label>
                                            <p class="mb-0 fw-medium">{{ $player->user->address ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <label class="form-label text-muted small mb-1">Preferred Sports</label>
                                            <p class="mb-0 fw-medium">
                                                {{$player->sport ?? 'Not provided'}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Edit Mode -->
                            <div id="profile-edit-mode" class="profile-mode">
                                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                    <h3 class="card-title h4 mb-0 fw-bold">Edit Profile</h3>
                                    <div>
                                        <button id="save-profile" class="btn btn-success btn-sm me-2">
                                            <i class="fas fa-save me-2"></i>Save Changes
                                        </button>
                                        <button id="cancel-edit" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </button>
                                    </div>
                                </div>
                                
                                <form id="profile-edit-form" class="needs-validation" novalidate>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="edit-name" name="name" placeholder="Full Name" value="{{ $player->user->name }}" required>
                                                <label for="edit-name">Full Name</label>
                                                <div class="invalid-feedback">Please provide your name.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="tel" class="form-control" id="edit-phone" name="phone_number" placeholder="Phone Number" value="{{ $player->user->phone_number }}">
                                                <label for="edit-phone">Phone Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="edit-address" name="address" placeholder="Address" value="{{ $player->user->address }}">
                                                <label for="edit-address">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Preferred Sports</label>
                                            <div class="row g-2">
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sport-football" name="sports[]" value="Football" {{ str_contains($player->sport ?? '', 'Football') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sport-football">Football</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sport-basketball" name="sports[]" value="Basketball" {{ str_contains($player->sport ?? '', 'Basketball') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sport-basketball">Basketball</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sport-tennis" name="sports[]" value="Tennis" {{ str_contains($player->sport ?? '', 'Tennis') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sport-tennis">Tennis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sport-volleyball" name="sports[]" value="Volleyball" {{ str_contains($player->sport ?? '', 'Volleyball') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sport-volleyball">Volleyball</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="sport-futsal" name="sports[]" value="Futsal" {{ str_contains($player->sport ?? '', 'Futsal') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sport-futsal">Futsal</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="edit-photo" name="photo">
                                                <label class="input-group-text" for="edit-photo">Upload</label>
                                            </div>
                                            <div class="form-text">Upload a new profile photo (optional)</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Change Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="password-change-form" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current-password" required>
                            <div class="invalid-feedback">Please enter your current password.</div>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new-password" required>
                            <div class="form-text">
                                Password must be at least 8 characters and include uppercase, lowercase, number, and special character.
                            </div>
                            <div class="invalid-feedback">Please enter a valid new password.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" required>
                            <div class="invalid-feedback">Passwords do not match.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-password">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h6 class="mb-3">Stay Connected</h6>
                    <div class="d-flex gap-3 mb-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f fs-5"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fs-5"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fs-5"></i></a>
                    </div>
                    <form class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between">
                <p>&copy; 2023 SportBooker. All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="text-muted" href="">Privacy Policy</a></li>
                    <li class="ms-3"><a class="text-muted" href="">Terms of Use</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Add the navbar separator and spacing styles -->
    <style>
    /* Navbar Separator - Creates a visible line between navbar and content */
    .navbar-separator {
        position: fixed;
        top: 70px; /* Same as navbar height */
        left: 0;
        right: 0;
        height: 1px;
        background-color: #e0e0e0;
        z-index: 999;
    }

    /* Content spacer - Creates space between navbar and content */
    .content-spacer {
        height: 80px; /* Navbar height + extra space */
        width: 100%;
    }
    
    /* Profile Image Styles */
    .profile-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Profile Nav Styling - Fixed blue line issue */
    .profile-nav .nav-link {
        color: #6c757d;
        border-radius: 0.5rem;
        padding: 0.7rem 1rem;
        transition: all 0.3s ease;
        position: relative;
        border: none !important;
    }
    
    .profile-nav .nav-link:hover {
        background-color: rgba(0, 102, 204, 0.05);
        color: #0066cc;
    }
    
    .profile-nav .nav-link.active {
        background-color: rgba(0, 102, 204, 0.1);
        color: #0066cc;
        font-weight: 500;
        border: none !important;
    }
    
    .profile-nav .nav-link.active:after {
        display: none !important;
    }
    .profile-nav .nav .nav-link:after {
        display: none !important;
    }
    
    
    .profile-nav .nav-link i {
        width: 20px;
        text-align: center;
    }
    
    /* Tab Content Styling */
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* Profile Mode Styling */
    .profile-mode {
        display: none;
    }
    
    .profile-mode.active {
        display: block;
    }
    
    /* Card Styling */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 767px) {
        .content-spacer {
            height: 70px;
        }
        
        main.container {
            padding-bottom: 80px; /* Space for bottom nav on mobile */
        }
    }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabLinks = document.querySelectorAll('[data-tab]');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');
                    
                    // Update active tab button
                    tabLinks.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show selected tab content
                    tabContents.forEach(content => content.classList.remove('active'));
                    document.getElementById(tabName + '-tab').classList.add('active');
                });
            });
            
            // Profile edit mode toggle
            const viewMode = document.getElementById('profile-view-mode');
            const editMode = document.getElementById('profile-edit-mode');
            const toggleEditBtn = document.getElementById('toggle-edit-mode');
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const saveProfileBtn = document.getElementById('save-profile');
            const cancelEditBtn = document.getElementById('cancel-edit');
            
            function showEditMode() {
                viewMode.classList.remove('active');
                editMode.classList.add('active');
            }
            
            function showViewMode() {
                editMode.classList.remove('active');
                viewMode.classList.add('active');
            }
            
            if (toggleEditBtn) toggleEditBtn.addEventListener('click', showEditMode);
            if (editProfileBtn) editProfileBtn.addEventListener('click', showEditMode);
            if (cancelEditBtn) cancelEditBtn.addEventListener('click', showViewMode);
            
            // Form submission handling
            if (saveProfileBtn) {
                saveProfileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Validate form
                    const form = document.getElementById('profile-edit-form');
                    if (!form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }
                    
                    // Simulate AJAX form submission
                    const formData = new FormData(form);
                    
                    // Show loading state
                    saveProfileBtn.disabled = true;
                    saveProfileBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                    
                    // Simulate server delay
                    setTimeout(function() {
                        // Update profile data in view mode
                        const name = formData.get('name');
                        const phone = formData.get('phone_number');
                        const address = formData.get('address');
                        
                        // Update profile view with new data
                        document.querySelector('.profile-img').parentElement.nextElementSibling.textContent = name;
                        
                        const profileInfoEls = document.querySelectorAll('#profile-view-mode .fw-medium');
                        profileInfoEls[0].textContent = name;
                        profileInfoEls[1].textContent = phone || 'Not provided';
                        profileInfoEls[4].textContent = address || 'Not provided';
                        
                        // Show success message
                        const toast = document.createElement('div');
                        toast.className = 'position-fixed bottom-0 end-0 p-3';
                        toast.style.zIndex = '9999';
                        toast.innerHTML = `
                            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-success text-white">
                                    <strong class="me-auto">Success</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Your profile has been updated successfully.
                                </div>
                            </div>
                        `;
                        document.body.appendChild(toast);
                        
                        // Return to view mode
                        showViewMode();
                        
                        // Reset form state
                        saveProfileBtn.disabled = false;
                        saveProfileBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Changes';
                        
                        // Remove toast after 3 seconds
                        setTimeout(function() {
                            toast.remove();
                        }, 3000);
                    }, 1000);
                });
            }
            
            // Password change handling
            const savePasswordBtn = document.getElementById('save-password');
            if (savePasswordBtn) {
                savePasswordBtn.addEventListener('click', function() {
                    const form = document.getElementById('password-change-form');
                    if (!form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }
                    
                    const newPassword = document.getElementById('new-password').value;
                    const confirmPassword = document.getElementById('confirm-password').value;
                    
                    if (newPassword !== confirmPassword) {
                        document.getElementById('confirm-password').setCustomValidity('Passwords do not match');
                        form.classList.add('was-validated');
                        return;
                    }
                    
                    // Simulate AJAX password change
                    savePasswordBtn.disabled = true;
                    savePasswordBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                    
                    setTimeout(function() {
                        // Hide modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('passwordModal'));
                        modal.hide();
                        
                        // Show success message
                        const toast = document.createElement('div');
                        toast.className = 'position-fixed bottom-0 end-0 p-3';
                        toast.style.zIndex = '9999';
                        toast.innerHTML = `
                            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-success text-white">
                                    <strong class="me-auto">Success</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Your password has been changed successfully.
                                </div>
                            </div>
                        `;
                        document.body.appendChild(toast);
                        
                        // Reset form
                        form.reset();
                        form.classList.remove('was-validated');
                        savePasswordBtn.disabled = false;
                        savePasswordBtn.innerHTML = 'Save Changes';
                        
                        // Remove toast after 3 seconds
                        setTimeout(function() {
                            toast.remove();
                        }, 3000);
                    }, 1000);
                });
            }
        });
    </script>
</x-layout>