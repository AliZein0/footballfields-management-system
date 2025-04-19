<header id="header" class="header fixed-top ">
   

    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('players.index') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('img/hero-carousel/logo.png') }}" alt="Field Booking Logo">
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                
                    <li><a href="{{ route('players.index') }}" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="{{ route('teams.create') }}">Manage Team</a></li>
                    <li><a href="#book-a-table">Fields</a></li>
                    <li><a href="{{ route('players.profile') }}">Profile</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>
</header>