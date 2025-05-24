<header id="header" class="header fixed-top">
    <div class="container">
        <div class="header-container">
            <div class="logo">
                <a href="{{ route('players.index') }}" class="d-flex align-items-center">
                    <img src="{{ asset('img/hero-carousel/logo.png') }}" alt="Field Booking Logo">
                </a>
            </div>
            
            <nav id="main-nav" class="main-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('players.index') }}" class="nav-link {{ Route::currentRouteName() == 'players.index' ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('bookings.history')}}" class="nav-link {{ Route::currentRouteName() == 'bookings.history' ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teams.create') }}" class="nav-link {{ Route::currentRouteName() == 'teams.create' ? 'active' : '' }}">
                            <i class="fas fa-users"></i> My Team
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('players.profile', session('player_id')) }}" class="nav-link {{ Route::currentRouteName() == 'players.profile' ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="header-right">
                <div class="search-icon-mobile">
                    <button type="button" id="mobile-search-toggle">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="notifications">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @php
                                $invitationCount = 0;
                                // Check for team invitations safely (preventing errors if model not found)
                                try {
                                    if (Auth::check() && class_exists('App\Models\TeamInvitation')) {
                                        $invitationCount = \App\Models\TeamInvitation::where('player_id', Auth::id())
                                            ->where('status', 'pending')
                                            ->count();
                                    }
                                } catch (\Exception $e) {
                                    // Silently handle any errors
                                    $invitationCount = 0;
                                }
                            @endphp
                            @if($invitationCount > 0)
                                <span class="badge">{{ $invitationCount }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                            <li class="dropdown-header">
                                <h6>Notifications</h6>
                                @if($invitationCount > 0)
                                    <span>You have {{ $invitationCount }} new invitation{{ $invitationCount > 1 ? 's' : '' }}</span>
                                @else
                                    <span>No new notifications</span>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
                            @if($invitationCount > 0)
                                @php
                                    $pendingInvitations = [];
                                    try {
                                        if (class_exists('App\Models\TeamInvitation')) {
                                            $pendingInvitations = \App\Models\TeamInvitation::where('player_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->with(['team', 'inviter'])
                                                ->orderBy('created_at', 'desc')
                                                ->take(3)
                                                ->get();
                                        }
                                    } catch (\Exception $e) {
                                        // Silently handle any errors
                                    }
                                @endphp
                                
                                @forelse($pendingInvitations as $invitation)
                                    <li>
                                        <a class="dropdown-item notification-item" href="{{ route('invitations.player') }}">
                                            <div class="notification-icon bg-success">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h5>Team Invitation</h5>
                                                <p>You've been invited to join {{ $invitation->team->name }}</p>
                                                <span class="time">{{ $invitation->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @if(!$loop->last)
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                @empty
                                    <li>
                                        <a class="dropdown-item notification-item" href="#">
                                            <div class="notification-icon bg-success">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h5>Team Invitation</h5>
                                                <p>You have pending team invitations</p>
                                                <span class="time">New</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforelse
                                
                                @if($invitationCount > 3)
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                            @else
                                <li>
                                    <div class="dropdown-item text-center py-3">
                                        <p class="text-muted mb-0">No new notifications</p>
                                    </div>
                                </li>
                            @endif
                            
                            @if($invitationCount > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-center view-all" href="{{ route('invitations.player') }}">
                                        View All Notifications
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <div class="user-profile">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/user-avatar.jpg') }}" alt="User Profile" class="avatar">
                            <span class="user-name d-none d-lg-inline-block">{{ session('player_name', 'User') }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('players.profile', session('player_id')) }}">
                                    <i class="fas fa-user me-2"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('bookings.history') }}">
                                    <i class="fas fa-history me-2"></i> Booking History
                                </a>
                            </li>
                           
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout" href="{{ route('players.logout') }}">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="mobile-menu-toggle">
                    <button type="button" id="mobile-nav-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search Bar (hidden by default) -->
    <div class="mobile-search-bar" style="display: none;">
        <div class="container">
            <form action="{{ route('fields.search') }}" method="GET">
                <div class="mobile-search-input">
                    <input type="text" name="query" placeholder="Search for venues...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button type="button" id="mobile-search-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

{{ $slot ?? '' }}

<style>
/* Modern Header Styles */
.header {
    background-color: #fff;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    height: 70px;
    padding: 0;
    transition: all 0.3s ease;
    z-index: 997;
    margin-bottom: 20px;
    position: fixed;
    top: 0;
    
}


.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
}

.logo {
    padding: 0;
    margin-right: 1rem;
}

.logo img {
    max-height: 40px;
    transition: all 0.3s ease;
}

/* Main Navigation */
.main-nav {
    display: flex;
}

.nav-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
    white-space: nowrap;
    padding: 0 15px;
}

.nav-link {
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    font-weight: 500;
    color: #333;
    padding: 25px 0;
    margin: 0 5px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link i {
    margin-right: 5px;
    font-size: 1rem;
    color: #0066cc;
}

.nav-link:hover, 
.nav-link.active {
    color: #0066cc;
}

.nav-link:after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    background: #0066cc;
    bottom: 18px;
    left: 0;
    transition: all 0.3s ease;
}

.nav-link:hover:after, 
.nav-link.active:after {
    width: 100%;
}

/* Header Right Elements */
.header-right {
    display: flex;
    align-items: center;
}

.search-icon-mobile,
.notifications,
.user-profile,
.mobile-menu-toggle {
    margin-left: 15px;
}

.search-icon-mobile button,
.notifications .dropdown-toggle,
.user-profile .dropdown-toggle,
.mobile-menu-toggle button {
    background: transparent;
    border: 0;
    padding: 0;
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #333;
    transition: all 0.3s ease;
}

.search-icon-mobile button:hover,
.notifications .dropdown-toggle:hover,
.user-profile .dropdown-toggle:hover,
.mobile-menu-toggle button:hover {
    color: #0066cc;
}

.notifications .dropdown-toggle {
    position: relative;
}

.notifications .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 0.6rem;
    height: 18px;
    width: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #ff4757;
    color: white;
}

.notifications .dropdown-menu {
    width: 320px;
    padding: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.notifications .dropdown-header {
    background-color: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.notifications .dropdown-header h6 {
    margin-bottom: 2px;
    font-weight: 600;
}

.notifications .dropdown-header span {
    font-size: 0.8rem;
    color: #666;
}

.notification-item {
    display: flex;
    padding: 15px;
    transition: all 0.3s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
}

.notification-content h5 {
    font-size: 0.9rem;
    margin-bottom: 3px;
    font-weight: 600;
}

.notification-content p {
    font-size: 0.8rem;
    margin-bottom: 3px;
    color: #666;
}

.notification-content .time {
    font-size: 0.7rem;
    color: #999;
}

.view-all {
    font-weight: 600;
    padding: 12px;
    background-color: #f8f9fa;
}

.user-profile .avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #eee;
    margin-right: 8px;
}

.user-profile .user-name {
    font-size: 0.9rem;
    font-weight: 500;
}

.user-profile .dropdown-menu {
    min-width: 200px;
    padding: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.user-profile .dropdown-item {
    padding: 12px 15px;
    font-size: 0.9rem;
}

.user-profile .dropdown-item:hover {
    background-color: #f8f9fa;
}

.user-profile .dropdown-item.logout {
    color: #ff4757;
}

.user-profile .dropdown-divider {
    margin: 0;
}

.mobile-menu-toggle,
.search-icon-mobile {
    display: none;
}

/* Mobile Search Bar */
.mobile-search-bar {
    position: absolute;
    top: 70px;
    left: 0;
    right: 0;
    background-color: #f8f9fa;
    padding: 15px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 996;
}

.mobile-search-input {
    display: flex;
    align-items: center;
    background-color: #fff;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.mobile-search-input input {
    flex: 1;
    border: none;
    padding: 12px 15px;
    font-size: 0.9rem;
}

.mobile-search-input input:focus {
    outline: none;
}

.mobile-search-input button {
    background: transparent;
    border: none;
    padding: 0 15px;
    font-size: 1rem;
    color: #666;
}

.mobile-search-input button[type="submit"] {
    background-color: #0066cc;
    color: white;
    padding: 12px 20px;
}

/* Media Queries */
@media (max-width: 1199px) {
    .main-nav {
        position: fixed;
        top: 70px;
        left: -100%;
        width: 280px;
        height: 100vh;
        background-color: #fff;
        overflow-y: auto;
        transition: all 0.3s ease;
        z-index: 995;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    
    .main-nav.active {
        left: 0;
    }
    
    .nav-menu {
        flex-direction: column;
        padding: 20px 0;
    }
    
    .nav-item {
        padding: 0;
    }
    
    .nav-link {
        padding: 15px 20px;
        font-size: 1rem;
        border-bottom: 1px solid #f5f5f5;
        width: 100%;
    }
    
    .nav-link:after {
        display: none;
    }
    
    .nav-link i {
        width: 20px;
        text-align: center;
    }
    
    .mobile-menu-toggle,
    .search-icon-mobile {
        display: block;
    }
    
    .mobile-menu-toggle button i {
        font-size: 1.2rem;
    }
    
    .user-profile .user-name {
        display: none !important;
    }
}

@media (max-width: 575px) {
    .notifications .dropdown-menu {
        width: 290px;
        left: auto !important;
        right: -100px !important;
    }
    
    .logo img {
        max-height: 35px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileNavToggle = document.getElementById('mobile-nav-toggle');
    const mainNav = document.getElementById('main-nav');
    
    if (mobileNavToggle && mainNav) {
        mobileNavToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });
    }
    
    // Mobile Search Toggle
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileSearchClose = document.getElementById('mobile-search-close');
    const mobileSearchBar = document.querySelector('.mobile-search-bar');
    
    if (mobileSearchToggle && mobileSearchBar && mobileSearchClose) {
        mobileSearchToggle.addEventListener('click', function() {
            mobileSearchBar.style.display = 'block';
        });
        
        mobileSearchClose.addEventListener('click', function() {
            mobileSearchBar.style.display = 'none';
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mainNav && mainNav.classList.contains('active') && !e.target.closest('#main-nav') && !e.target.closest('#mobile-nav-toggle')) {
            mainNav.classList.remove('active');
            if (mobileNavToggle && mobileNavToggle.querySelector('i').classList.contains('fa-times')) {
                mobileNavToggle.querySelector('i').classList.remove('fa-times');
                mobileNavToggle.querySelector('i').classList.add('fa-bars');
            }
        }
    });
    
    // Add shadow on scroll
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (header) {
            if (window.scrollY > 10) {
                header.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = 'none';
            }
        }
    });
});
</script>