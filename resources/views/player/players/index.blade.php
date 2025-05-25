<x-layout title="Find Your Field - Book Sports Venues Easily">
   <link rel="stylesheet" href="{{ asset('css/player-index.css') }}">
    
    
    <x-player_header>
        
    </x-player_header>

    <main class="main">
        <!-- Simplified Search Section -->
        <section id="search-section" class="search-section py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search-card">
                            <h2 class="search-title">Find Your Perfect Venue</h2>
                            <p class="search-subtitle">Book courts and fields for any sport, any time</p>
                            
                           <form id="field-search-form" action="{{ route('fields.search') }}" method="GET">
    <div class="search-row">
        <div class="search-input-group">
            <i class="fas fa-map-marker-alt input-icon"></i>
            <select name="city" class="form-select" aria-label="Select City">
                <option value="" selected>All Cities</option>
                @foreach(App\Models\SportField::LOCATIONS as $value => $label)
                    <option value="{{ $value }}" {{ request('city') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="search-input-group">
            <i class="fas fa-basketball-ball input-icon"></i>
            <select name="type" class="form-select" aria-label="Select Sport">
                <option value="" selected>All Sports</option>
                <option value="Football">Football</option>
                <option value="Basketball">Basketball</option>
                <option value="Tennis">Tennis</option>
                <option value="Volleyball">Volleyball</option>
                <option value="Futsal">Futsal</option>
            </select>
        </div>
        
        <div class="search-input-group">
            <i class="fas fa-search input-icon"></i>
            <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request('name') }}" aria-label="Search by name">
        </div>
        
        <div class="search-button-container">
            <button type="submit" class="btn btn-primary search-button">
                <i class="fas fa-search"></i> Find Venues
            </button>
        </div>
    </div>
    
    <div class="advanced-toggle">
        <a href="#" id="toggle-advanced" aria-expanded="false" aria-controls="advanced-options">More filters <i class="fas fa-chevron-down"></i></a>
    </div>
    
    <div id="advanced-options" class="advanced-options" style="display: none;">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="size"><i class="fas fa-ruler"></i> Size</label>
                    <select id="size" name="size" class="form-select">
                        <option value="" selected>Any Size</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="fees"><i class="fas fa-dollar-sign"></i> Price Range</label>
                    <select id="fees" name="fees" class="form-select">
                        <option value="" selected>Any Price</option>
                        <option value="0-50">$0 - $50</option>
                        <option value="50-100">$50 - $100</option>
                        <option value="100-200">$100 - $200</option>
                        <option value="200+">$200+</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="is_covered"><i class="fas fa-warehouse"></i> Venue Type</label>
                    <select id="is_covered" name="is_covered" class="form-select">
                        <option value="" selected>Indoor or Outdoor</option>
                        <option value="1">Indoor</option>
                        <option value="0">Outdoor</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="min_rating"><i class="fas fa-star"></i> Rating</label>
                    <select id="min_rating" name="min_rating" class="form-select">
                        <option value="" selected>Any Rating</option>
                        <option value="4">4+ Stars</option>
                        <option value="4.5">4.5+ Stars</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Error-Safe Team Invitations Section (displayed only when user has pending invitations) -->
        @php
            $invitationCount = 0;
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
        <section id="team-invitations" class="py-3">
            <div class="container">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0"><i class="fas fa-envelope text-primary me-2"></i> You have {{ $invitationCount }} pending team invitation{{ $invitationCount > 1 ? 's' : '' }}</h5>
                                <p class="text-muted small mb-0">Teams have invited you to join them</p>
                            </div>
                            <a href="{{ route('invitations.player') }}" class="btn btn-primary btn-sm">View Invitations</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        
<!-- Conditionally display Last Visited or Search Results Section -->
<section id="featured-venues" class="top-rated-venues py-4">
    <div class="container">
        <div class="section-header">
            @if(isset($hasSearch) && $hasSearch)
                <h2 class="section-title">Search Results ({{ $resultsCount ?? 0 }} found)</h2>
                @if(isset($resultsCount) && $resultsCount > 4)
                    <a href="{{ route('fields.search', request()->all()) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
                @endif
            @elseif(isset($hasBookings) && $hasBookings && isset($lastVisitedFields) && $lastVisitedFields->isNotEmpty())
                <h2 class="section-title">Last Visited</h2>
                <a href="{{ route('bookings.history') }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            @else
                <h2 class="section-title">Top Rated Venues</h2>
                <a href="{{ route('fields.all', ['sort' => 'newest']) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            @endif
        </div>
        
        <div class="venue-cards-container">
            <div class="row g-4">
                @if(isset($hasSearch) && $hasSearch)
                    @if(isset($searchResults) && $searchResults->isNotEmpty())
                        @foreach($searchResults->take(4) as $field)
                            <div class="col-lg-3 col-md-6">
                                <div class="venue-card">
                                    <div class="venue-image">
                                        <img src="{{ asset($field->main_image_path ?? 'img/default-field.jpg') }}" alt="{{ $field->name }} venue">
                                        <div class="venue-badge">
                                            <span>{{ $field->type }}</span>
                                        </div>
                                        @if($field->rating >= 4.5)
                                            <div class="top-rated-badge">
                                                <i class="fas fa-award"></i> Top Rated
                                            </div>
                                        @endif
                                    </div>
                                    <div class="venue-details">
                                        <h3 class="venue-name">{{ $field->name }}</h3>
                                        <div class="venue-location">
                                            <i class="fas fa-map-marker-alt"></i> {{ $field->location }}
                                        </div>
                                        <div class="venue-rating">
                                            <i class="fas fa-star"></i> {{ number_format($field->rating, 1) }}
                                        </div>
                                        <div class="venue-features">
                                            <span class="feature">
                                                @if($field->is_covered == 1)
                                                    <i class="fas fa-warehouse"></i> Indoor
                                                @else
                                                    <i class="fas fa-sun"></i> Outdoor
                                                @endif
                                            </span>
                                            <span class="feature">
                                                <i class="fas fa-ruler"></i> {{ $field->size }}
                                            </span>
                                        </div>
                                        <div class="venue-footer">
                                            <div class="venue-price">${{ number_format($field->fees, 2) }}/hr</div>
                                            <a href="{{ route('booking.show', ['player' => session('player_id'), 'field' => $field->id]) }}" class="btn-book">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No venues match your search criteria. Try adjusting your filters.
                            </div>
                        </div>
                    @endif
                
                @elseif(isset($hasBookings) && $hasBookings && isset($lastVisitedFields) && $lastVisitedFields->isNotEmpty())
                    @foreach($lastVisitedFields->take(4) as $field)
                        <div class="col-lg-3 col-md-6">
                            <div class="venue-card">
                                <div class="venue-image">
                                    <img src="{{ asset($field->main_image_path ?? 'img/default-field.jpg') }}" alt="{{ $field->name }} venue">
                                    <div class="venue-badge">
                                        <span>{{ $field->type }}</span>
                                    </div>
                                    @if($field->rating >= 4.5)
                                        <div class="top-rated-badge">
                                            <i class="fas fa-award"></i> Top Rated
                                        </div>
                                    @endif
                                </div>
                                <div class="venue-details">
                                    <h3 class="venue-name">{{ $field->name }}</h3>
                                    <div class="venue-location">
                                        <i class="fas fa-map-marker-alt"></i> {{ $field->location }}
                                    </div>
                                    <div class="venue-rating">
                                        <i class="fas fa-star"></i> {{ number_format($field->rating, 1) }}
                                    </div>
                                    <div class="venue-features">
                                        <span class="feature">
                                            @if($field->is_covered == 1)
                                                <i class="fas fa-warehouse"></i> Indoor
                                            @else
                                                <i class="fas fa-sun"></i> Outdoor
                                            @endif
                                        </span>
                                        <span class="feature">
                                            <i class="fas fa-ruler"></i> {{ $field->size }}
                                        </span>
                                    </div>
                                    <div class="venue-footer">
                                        <div class="venue-price">${{ number_format($field->fees, 2) }}/hr</div>
                                        <a href="{{ route('booking.show', ['player' => session('player_id'), 'field' => $field->id]) }}" class="btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                
                @elseif(isset($fields) && $fields->isNotEmpty())
                    @foreach($fields->sortByDesc('rating')->take(4) as $field)
                        <div class="col-lg-3 col-md-6">
                            <div class="venue-card">
                                <div class="venue-image">
                                    <img src="{{ asset($field['main_image_path'] ?? 'img/default-field.jpg') }}" alt="{{ $field['name'] }} venue">
                                    <div class="venue-badge">
                                        <span>{{ $field['type'] }}</span>
                                    </div>
                                    @if($field['rating'] >= 4.5)
                                        <div class="top-rated-badge">
                                            <i class="fas fa-award"></i> Top Rated
                                        </div>
                                    @endif
                                </div>
                                <div class="venue-details">
                                    <h3 class="venue-name">{{ $field['name'] }}</h3>
                                    <div class="venue-location">
                                        <i class="fas fa-map-marker-alt"></i> {{ $field['location'] }}
                                    </div>
                                    <div class="venue-rating">
                                        <i class="fas fa-star"></i> {{ number_format($field['rating'], 1) }}
                                    </div>
                                    <div class="venue-features">
                                        <span class="feature">
                                            @if($field['is_covered'] == 1)
                                                <i class="fas fa-warehouse"></i> Indoor
                                            @else
                                                <i class="fas fa-sun"></i> Outdoor
                                            @endif
                                        </span>
                                        <span class="feature">
                                            <i class="fas fa-ruler"></i> {{ $field['size'] }}
                                        </span>
                                    </div>
                                    <div class="venue-footer">
                                        <div class="venue-price">${{ number_format($field['fees'], 2) }}/hr</div>
                                        <a href="{{ route('booking.show', ['player' => session('player_id'), 'field' => $field['id']]) }}" class="btn-book">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No venues available at the moment.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
        
        <!-- Recently Added Venues -->
        <section id="recently-added" class="recently-added py-4">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Recently Added</h2>
                    
    <a href="{{ route('fields.all', ['sort' => 'newest']) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="venue-list">
                
                    @if($fields->isNotEmpty())
                        @foreach($fields->sortByDesc('created_at')->take(5) as $field)
                            <div class="venue-list-item">
                                <a href="{{ route('booking.show', ['player' => session('player_id'), 'field' => $field['id']]) }}" class="venue-link">
                                    <div class="venue-horizontal-card">
                                        <div class="venue-image">
                                            <img src="{{ asset($field['main_image_path'] ?? 'img/default-field.jpg') }}" alt="{{ $field['name'] }} venue">
                                        </div>
                                        <div class="venue-content">
                                            <div class="venue-name">{{ $field['name'] }}</div>
                                            <div class="venue-details">
                                                <div class="venue-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $field['location'] }}
                                                </div>
                                                <div class="venue-type">
                                                    <span class="badge">{{ $field['type'] }}</span>
                                                </div>
                                            </div>
                                            <div class="venue-features">
                                                <span class="feature">
                                                    @if($field['is_covered'] == 1)
                                                        <i class="fas fa-warehouse"></i> Indoor
                                                    @else
                                                        <i class="fas fa-sun"></i> Outdoor
                                                    @endif
                                                </span>
                                                <span class="feature">
                                                    <i class="fas fa-ruler"></i> {{ $field['size'] }}
                                                </span>
                                                <span class="feature">
                                                    <i class="fas fa-star"></i> {{ number_format($field['rating'], 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="venue-actions">
                                            <div class="venue-price">${{ number_format($field['fees'], 2) }}/hr</div>
                                            <button class="btn-book">Book Now</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No venues available at the moment.
                        </div>
                    @endif
                </div>
            </div>
        </section>
        
        <!-- How It Works Section -->
        <section id="how-it-works" class="how-it-works py-4">
            <div class="container">
                <h2 class="section-title">How It Works</h2>
                <div class="steps-container">
                    <div class="step-flow">
                        <div class="step">
                            <div class="step-number">1</div>
                            <div class="step-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Search</h3>
                            <p>Find your perfect venue by location, sport type, or amenities</p>
                        </div>
                        
                        <div class="step-connector">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3>Book</h3>
                            <p>Select your date and time slot and confirm your booking</p>
                        </div>
                        
                        <div class="step-connector">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h3>Pay</h3>
                            <p>Secure your booking with easy online payment</p>
                        </div>
                        
                        <div class="step-connector">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-icon">
                                <i class="fas fa-futbol"></i>
                            </div>
                            <h3>Play</h3>
                            <p>Enjoy your game at your chosen venue</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="contact-section py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="contact-info">
                            <h2>Need Help?</h2>
                            <p>Our team is here to assist you with booking or answering any questions</p>
                            
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div class="contact-text">
                                    <h4>Email Us</h4>
                                    <a href="mailto:info@fieldbooking.com">info@fieldbooking.com</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <div class="contact-text">
                                    <h4>Call Us</h4>
                                    <a href="tel:+15589554885">+1 (558) 955-4885</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <i class="fas fa-comment-dots"></i>
                                <div class="contact-text">
                                    <h4>Live Chat</h4>
                                    <p>Available 9AM - 6PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-7">
                        <form class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Your Name</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Your Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Back to Top Button -->
    <a href="#" id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Custom Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Advanced Search Toggle
        const toggleAdvanced = document.getElementById('toggle-advanced');
        const advancedOptions = document.getElementById('advanced-options');
        
        if (toggleAdvanced && advancedOptions) {
            toggleAdvanced.addEventListener('click', function(e) {
                e.preventDefault();
                const isExpanded = advancedOptions.style.display !== 'none';
                
                if (!isExpanded) {
                    advancedOptions.style.display = 'block';
                    toggleAdvanced.innerHTML = 'Less filters <i class="fas fa-chevron-up"></i>';
                    toggleAdvanced.setAttribute('aria-expanded', 'true');
                } else {
                    advancedOptions.style.display = 'none';
                    toggleAdvanced.innerHTML = 'More filters <i class="fas fa-chevron-down"></i>';
                    toggleAdvanced.setAttribute('aria-expanded', 'false');
                }
            });
        }
        
        // Back to Top Functionality
        const backToTop = document.getElementById('back-to-top');
        
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });
            
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
    </script>
   
    <!-- Team Invitations Alert Banner Styles -->
    <style>
    /* Team Invitations Alert Banner */
    #team-invitations .card {
        transition: all 0.3s ease;
        border-left: 4px solid #0d6efd;
    }
    
    #team-invitations .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    </style>
</x-layout>