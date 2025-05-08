<x-layout title="Find Your Field - Book Sports Venues Easily">
    
    
        
        <x-player_header>
        </x-player_header>
    
        <main class="main ">
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
                                                <option value="" disabled selected>Select City</option>
                                                <option value="city1">City 1</option>
                                                <option value="city2">City 2</option>
                                                <option value="city3">City 3</option>
                                            </select>
                                        </div>
                                        
                                        <div class="search-input-group">
                                            <i class="fas fa-basketball-ball input-icon"></i>
                                            <select name="type" class="form-select" aria-label="Select Sport">
                                                <option value="" disabled selected>Select Sport</option>
                                                <option value="Football">Football</option>
                                                <option value="Basketball">Basketball</option>
                                                <option value="Tennis">Tennis</option>
                                                <option value="Volleyball">Volleyball</option>
                                                <option value="Futsal">Futsal</option>
                                            </select>
                                        </div>
                                        
                                        <div class="search-input-group">
                                            <i class="fas fa-calendar input-icon"></i>
                                            <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" aria-label="Select Date">
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
                                                        <option value="">Any Size</option>
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
                                                        <option value="">Any Price</option>
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
                                                        <option value="">Indoor or Outdoor</option>
                                                        <option value="1">Indoor</option>
                                                        <option value="0">Outdoor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="min_rating"><i class="fas fa-star"></i> Rating</label>
                                                    <select id="min_rating" name="min_rating" class="form-select">
                                                        <option value="">Any Rating</option>
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
            
            <!-- Featured Sports Categories -->
            <section id="sport-categories" class="sport-categories py-4">
                <div class="container">
                    <h2 class="section-title">Book by Sport</h2>
                    <div class="sport-category-cards">
                        <a href="{{ route('fields.search', ['type' => 'Football']) }}" class="sport-card">
                            <div class="sport-icon">
                                <i class="fas fa-futbol"></i>
                            </div>
                            <h3>Football</h3>
                        </a>
                        
                        <a href="{{ route('fields.search', ['type' => 'Basketball']) }}" class="sport-card">
                            <div class="sport-icon">
                                <i class="fas fa-basketball-ball"></i>
                            </div>
                            <h3>Basketball</h3>
                        </a>
                        
                        <a href="{{ route('fields.search', ['type' => 'Tennis']) }}" class="sport-card">
                            <div class="sport-icon">
                                <i class="fas fa-table-tennis"></i>
                            </div>
                            <h3>Tennis</h3>
                        </a>
                        
                        <a href="{{ route('fields.search', ['type' => 'Volleyball']) }}" class="sport-card">
                            <div class="sport-icon">
                                <i class="fas fa-volleyball-ball"></i>
                            </div>
                            <h3>Volleyball</h3>
                        </a>
                        
                        <a href="{{ route('fields.search', ['type' => 'Futsal']) }}" class="sport-card">
                            <div class="sport-icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <h3>Futsal</h3>
                        </a>
                    </div>
                </div>
            </section>
            
            <!-- Top Rated Venues Section -->
            <section id="top-rated-venues" class="top-rated-venues py-4">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Top Rated Venues</h2>
                        <a href="{{ route('fields.search', ['min_rating' => '4.5']) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="venue-cards-container">
                        <div class="row g-4">
                            @if($fields->isNotEmpty())
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
                        <a href="{{ route('fields.search', ['sort' => 'newest']) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
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
            
            <!-- How It Works Section - FIXED -->
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
            
            <!-- Simplified Contact Section -->
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
    
    <style>
    /* Modern styles for the Player Home Page */
    
    /* General Styles */
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
        background-color: #f8f9fa;
        padding-top: 70px; /* Match the header height */
    }
    /* Add this to your index page CSS */

    .main {
    position: relative;
    z-index: 1; /* Ensure main content is below header z-index (997) */
    }
    
    a {
        color: #0066cc;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    a:hover {
        color: #0052a3;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        display: block;
        width: 50px;
        height: 3px;
        background: #0066cc;
        bottom: 0;
        left: 0;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .view-all-link {
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }
    
    .view-all-link i {
        margin-left: 0.25rem;
        transition: transform 0.3s ease;
    }
    
    .view-all-link:hover i {
        transform: translateX(3px);
    }
    
    /* Search Section Styles */
    .search-section {
        padding: 2.5rem 0;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    
    .search-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }
    
    .search-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .search-subtitle {
        font-size: 1rem;
        color: #666;
        margin-bottom: 1.5rem;
    }
    
    .search-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 1rem;
    }
    
    .search-input-group {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    
    .search-button-container {
        display: flex;
        align-items: center;
    }
    
    .form-select,
    .form-control {
        height: 50px;
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
    
    .search-button {
        height: 50px;
        min-width: 140px;
        border-radius: 8px;
        background-color: #0066cc;
        border: none;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 102, 204, 0.2);
        transition: all 0.3s ease;
    }
    
    .search-button:hover {
        background-color: #0052a3;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 102, 204, 0.25);
    }
    
    .advanced-toggle {
        text-align: center;
        margin-top: 0.5rem;
    }
    
    .advanced-toggle a {
        color: #666;
        font-size: 0.9rem;
    }
    
    .advanced-toggle i {
        font-size: 0.8rem;
        margin-left: 0.25rem;
    }
    
    .advanced-options {
        margin-top: 1.5rem;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    /* Sport Categories Styles */
    .sport-categories {
        padding: 3rem 0;
    }
    
    .sport-category-cards {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .sport-card {
        flex: 1;
        min-width: 150px;
        max-width: 200px;
        background-color: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .sport-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .sport-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #0066cc;
    }
    
    .sport-card h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    /* Venue Card Styles */
    .venue-cards-container {
        margin-top: 1.5rem;
    }
    
    .venue-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .venue-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .venue-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }
    
    .venue-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .venue-card:hover .venue-image img {
        transform: scale(1.05);
    }
    
    .venue-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 102, 204, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .top-rated-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(40, 167, 69, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .top-rated-badge i {
        margin-right: 5px;
    }
    
    .venue-details {
        padding: 1.25rem;
    }
    
    .venue-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .venue-location {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .venue-location i {
        margin-right: 5px;
        color: #999;
    }
    
    .venue-rating {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .venue-rating i {
        margin-right: 5px;
        color: #ffcb00;
    }
    
    .venue-features {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 1rem;
    }
    
    .feature {
        font-size: 0.8rem;
        color: #666;
        background-color: #f5f5f5;
        padding: 3px 10px;
        border-radius: 15px;
        display: flex;
        align-items: center;
    }
    
    .feature i {
        margin-right: 5px;
    }
    
    .venue-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
        padding-top: 1rem;
    }
    
    .venue-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0066cc;
    }
    
    .btn-book {
        background-color: #0066cc;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-book:hover {
        background-color: #0052a3;
        color: white;
    }
    
    /* Venue List Item Styles */
    .venue-list {
        margin-top: 1.5rem;
    }
    
    .venue-list-item {
        margin-bottom: 1rem;
    }
    
    .venue-list-item:last-child {
        margin-bottom: 0;
    }
    
    .venue-link {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    
    .venue-link:hover {
        color: inherit;
        text-decoration: none;
    }
    
    .venue-horizontal-card {
        display: flex;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .venue-horizontal-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .venue-horizontal-card .venue-image {
        width: 120px;
        height: 120px;
        flex-shrink: 0;
    }
    
    .venue-horizontal-card .venue-content {
        flex: 1;
        padding: 1rem;
        min-width: 0; /* Prevent flex child from overflowing */
    }
    
    .venue-horizontal-card .venue-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .venue-horizontal-card .venue-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .venue-horizontal-card .venue-features {
        margin-bottom: 0;
    }
    
    .venue-horizontal-card .venue-actions {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-left: 1px solid #eee;
        min-width: 120px;
    }
    
    .venue-horizontal-card .venue-price {
        margin-bottom: 0.5rem;
    }
    
    /* How It Works Section - FIXED STYLES */
    .how-it-works {
        padding: 3rem 0;
        background-color: #f0f5ff;
    }
    
    .steps-container {
        margin-top: 2rem;
    }
    
    .step-flow {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: stretch;
    }
    
    .step {
        flex: 1;
        min-width: 200px;
        max-width: 250px;
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        position: relative;
        margin: 0 0.5rem 1.5rem;
    }
    
    .step-number {
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 30px;
        background-color: #0066cc;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 1;
    }
    
    .step-connector {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0066cc;
        font-size: 1.5rem;
        padding: 0 0.5rem;
    }
    
    .step-icon {
        width: 70px;
        height: 70px;
        background-color: #e6f0ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #0066cc;
        margin: 0 auto 1.5rem;
    }
    
    .step h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .step p {
        font-size: 0.9rem;
        color: #666;
    }
    
    /* Contact Section Styles */
    .contact-section {
        padding: 3rem 0;
        background-color: #fff;
    }
    
    .contact-info {
        background-color: #0066cc;
        color: white;
        border-radius: 10px;
        padding: 2rem;
        height: 100%;
    }
    
    .contact-info h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .contact-info p {
        margin-bottom: 2rem;
        opacity: 0.9;
    }
    
    .contact-item {
        display: flex;
        margin-bottom: 1.5rem;
    }
    
    .contact-item:last-child {
        margin-bottom: 0;
    }
    
    .contact-item i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .contact-text h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .contact-text a {
        color: white;
        opacity: 0.9;
    }
    
    .contact-text a:hover {
        opacity: 1;
        text-decoration: underline;
    }
    
    .contact-form {
        background-color: #fff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .contact-form label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .contact-form .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        height: auto;
    }
    
    .contact-form textarea.form-control {
        min-height: 120px;
    }
    
    .contact-form button {
        padding: 12px 25px;
        font-weight: 600;
        margin-top: 1rem;
        background-color: #0066cc;
        border: none;
    }
    
    .contact-form button:hover {
        background-color: #0052a3;
    }
    
    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        right: 20px;
        bottom: 20px;
        width: 40px;
        height: 40px;
        background-color: #0066cc;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 99;
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        background-color: #0052a3;
        transform: translateY(-3px);
    }
    
    /* Media Queries */
    @media (max-width: 992px) {
        .step-connector {
            display: none;
        }
        
        .sport-card {
            min-width: 120px;
        }
        
        .steps-container {
            padding: 0 1rem;
        }
        
        .step-flow {
            justify-content: center;
        }
        
        .step {
            margin-bottom: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .search-section,
        .sport-categories,
        .top-rated-venues,
        .recently-added,
        .how-it-works,
        .contact-section {
            padding: 2rem 0;
        }
        
        .search-row {
            flex-direction: column;
            gap: 10px;
        }
        
        .search-button-container {
            width: 100%;
        }
        
        .search-button {
            width: 100%;
        }
        
        .sport-category-cards {
            justify-content: center;
        }
        
        .venue-horizontal-card {
            flex-direction: column;
        }
        
        .venue-horizontal-card .venue-image {
            width: 100%;
            height: 150px;
        }
        
        .venue-horizontal-card .venue-actions {
            border-left: none;
            border-top: 1px solid #eee;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }
        
        .venue-horizontal-card .venue-price {
            margin-bottom: 0;
        }
        
        .contact-info {
            margin-bottom: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .sport-card {
            min-width: 140px;
            margin-bottom: 1rem;
        }
        
        .step {
            min-width: 100%;
        }
        
        .venue-horizontal-card .venue-details {
            flex-direction: column;
        }
        
        .venue-horizontal-card .venue-type {
            margin-top: 0.5rem;
        }
    }
    </style>
</x-layout>