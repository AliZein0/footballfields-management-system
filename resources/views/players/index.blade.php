<x-layout title="Player - Home">
    
    <body class="index-page">
        
        <x-player_header>
    
        </x-player_header>
    
    
        <main class="main">
           <!-- داخل قسم Hero Section -->
    <!-- Updated Hero Section with Simplified Search Bar -->
    <section id="hero" class="hero section dark-background">
        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Carousel Item 1 -->
            <div class="carousel-item active">
                <img src="{{ asset('img/hero-carousel/field1.jpg') }}" alt="">
                <div class="carousel-container">
                    <h1>Book Your Next Game Now</h1>
                    <!-- Simplified Search Bar Container -->
                    <div class="search-bar-container">
                        <form id="field-search-form" action="{{ route('fields.search') }}" method="GET">
                            <div class="search-main-row">
                                <div class="search-input-group">
                                    <i class="fas fa-search input-icon"></i>
                                    <input type="text" name="name" class="stadium-input" placeholder="Enter Stadium Name">
                                </div>
                                
                                <div class="search-input-group">
                                    <i class="fas fa-map-marker-alt input-icon"></i>
                                    <select name="city" class="city-dropdown">
                                        <option value="" disabled selected>Select City</option>
                                        <option value="city1">City 1</option>
                                        <option value="city2">City 2</option>
                                        <option value="city3">City 3</option>
                                    </select>
                                </div>
                                
                                <div class="search-input-group sport-select-group">
                                    <i class="fas fa-basketball-ball input-icon"></i>
                                    <select name="type" class="sport-dropdown">
                                        <option value="" disabled selected>Select Sport</option>
                                        <option value="Football" data-icon="futbol">Football</option>
                                        <option value="Basketball" data-icon="basketball-ball">Basketball</option>
                                        <option value="Tennis" data-icon="table-tennis">Tennis</option>
                                        <option value="Volleyball" data-icon="volleyball-ball">Volleyball</option>
                                        <option value="Futsal" data-icon="running">Futsal</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            
                            <div class="advanced-search-toggle">
                                <a href="#" id="toggle-advanced">Advanced Search <i class="fas fa-chevron-down"></i></a>
                            </div>
                            
                            <div class="advanced-search-container" style="display: none;">
                                <div class="advanced-search-row">
                                    <div class="search-input-group">
                                        <i class="fas fa-ruler input-icon"></i>
                                        <select name="size" class="size-dropdown">
                                            <option value="" disabled selected>Field Size</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                        </select>
                                    </div>
                                    
                                    <div class="search-input-group">
                                        <i class="fas fa-dollar-sign input-icon"></i>
                                        <select name="fees" class="fees-dropdown">
                                            <option value="" disabled selected>Price Range</option>
                                            <option value="0-50">$0 - $50</option>
                                            <option value="50-100">$50 - $100</option>
                                            <option value="100-200">$100 - $200</option>
                                            <option value="200+">$200+</option>
                                        </select>
                                    </div>
                                    
                                    <div class="search-input-group">
                                        <i class="fas fa-warehouse input-icon"></i>
                                        <select name="is_covered" class="covered-dropdown">
                                            <option value="" disabled selected>Indoor/Outdoor</option>
                                            <option value="1">Indoor</option>
                                            <option value="0">Outdoor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Carousel Item 2 -->
            <div class="carousel-item">
                <img src="{{ asset('img/hero-carousel/BasketField1.jpg') }}" alt="">
                <div class="carousel-container">
                    <h1>The Court Awaits You</h1>
                    <!-- Same simplified search form on second slide -->
                    <div class="search-bar-container">
                        <form id="field-search-form-2" action="{{ route('fields.search') }}" method="GET">
                            <div class="search-main-row">
                                <div class="search-input-group">
                                    <i class="fas fa-search input-icon"></i>
                                    <input type="text" name="name" class="stadium-input" placeholder="Enter Stadium Name">
                                </div>
                                
                                <div class="search-input-group">
                                    <i class="fas fa-map-marker-alt input-icon"></i>
                                    <select name="city" class="city-dropdown">
                                        <option value="" disabled selected>Select City</option>
                                        <option value="city1">City 1</option>
                                        <option value="city2">City 2</option>
                                        <option value="city3">City 3</option>
                                    </select>
                                </div>
                                
                                <div class="search-input-group sport-select-group">
                                    <i class="fas fa-basketball-ball input-icon"></i>
                                    <select name="type" class="sport-dropdown">
                                        <option value="" disabled selected>Select Sport</option>
                                        <option value="Football" data-icon="futbol">Football</option>
                                        <option value="Basketball" data-icon="basketball-ball">Basketball</option>
                                        <option value="Tennis" data-icon="table-tennis">Tennis</option>
                                        <option value="Volleyball" data-icon="volleyball-ball">Volleyball</option>
                                        <option value="Futsal" data-icon="running">Futsal</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            
                            <div class="advanced-search-toggle">
                                <a href="#" id="toggle-advanced-2">Advanced Search <i class="fas fa-chevron-down"></i></a>
                            </div>
                            
                            <div class="advanced-search-container" style="display: none;">
                                <div class="advanced-search-row">
                                    <div class="search-input-group">
                                        <i class="fas fa-ruler input-icon"></i>
                                        <select name="size" class="size-dropdown">
                                            <option value="" disabled selected>Field Size</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                        </select>
                                    </div>
                                    
                                    <div class="search-input-group">
                                        <i class="fas fa-dollar-sign input-icon"></i>
                                        <select name="fees" class="fees-dropdown">
                                            <option value="" disabled selected>Price Range</option>
                                            <option value="0-50">$0 - $50</option>
                                            <option value="50-100">$50 - $100</option>
                                            <option value="100-200">$100 - $200</option>
                                            <option value="200+">$200+</option>
                                        </select>
                                    </div>
                                    
                                    <div class="search-input-group">
                                        <i class="fas fa-warehouse input-icon"></i>
                                        <select name="is_covered" class="covered-dropdown">
                                            <option value="" disabled selected>Indoor/Outdoor</option>
                                            <option value="1">Indoor</option>
                                            <option value="0">Outdoor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Carousel Controls -->
            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
            <ol class="carousel-indicators"></ol>
        </div>
    </section>
    <!-- Hero Section -->
    
    <!-- Search Results Section (Replaces Recommended Fields Section) -->
    <section id="search-results" class="book-a-table section py-4">
        <div class="container section-title">
            @if(isset($searchResults))
                <h2>Search Results</h2>
                <div>
                    <span>Found</span> 
                    <span class="description-title">{{ $resultsCount }} Fields</span>
                </div>
            @else
                <h2>Book a Field</h2>
                <div>
                    <span>Recommended</span> 
                    <span class="description-title">Fields</span>
                </div>
            @endif
        </div>
    
        <div class="container">
            @if(isset($searchResults) && count($searchResults) > 0)
                <!-- Display search results with improved card design -->
                <div class="row g-3">
                    @foreach($searchResults as $field)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="" class="text-decoration-none">
                                <div class="card search-result-card h-100">
                                    <div class="field-image-container">
                                        <img src="{{ asset($field->image_path ?? 'img/default-field.jpg') }}" class="card-img-top" alt="{{ $field->name }}">
                                        <div class="field-type-badge">
                                            <span class="badge bg-primary">{{ $field->type }}</span>
                                        </div>
                                        @if($field->rating >= 4.5)
                                            <div class="top-rated-badge">
                                                <span class="badge bg-success"><i class="bi bi-award"></i> Top Rated</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate mb-1">{{ $field->name }}</h6>
                                        <div class="field-meta mb-2">
                                            <span class="rating me-2">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                {{ number_format($field->rating, 1) }}
                                            </span>
                                            
                                        </div>
                                        <div class="field-features d-flex flex-wrap gap-2 mb-2">
                                            <span class="feature-tag">
                                                @if($field->is_covered == 1)
                                                    <i class="fas fa-home text-secondary"></i> Indoor
                                                @else
                                                    <i class="fas fa-sun text-warning"></i> Outdoor
                                                @endif
                                            </span>
                                            <span class="feature-tag">
                                                <i class="fas fa-ruler"></i> {{ $field->size }}
                                            </span>
                                        </div>
                                        <div class="price-book-row d-flex justify-content-between align-items-center">
                                            <span class="price-tag">${{ number_format($field->fees, 2) }}/hr</span>
                                            <button class="btn btn-sm btn-primary book-btn">Book</button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $searchResults->appends(request()->query())->links() }}
                </div>
                
            @elseif(isset($searchResults) && count($searchResults) == 0)
                <!-- No results message -->
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    No fields match your search criteria. Please try different search terms.
                </div>
                
            @else
                <!-- Updated recommendation carousel with fixed 3-column layout -->
             
                <!-- Sport Fields Card -->
                <div class="container">
                    <div id="field-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            @php
                                // Filter fields with rating > 4.8 and chunk into groups of 3
                                $highRatedFields = $fields->filter(function($field) {
                                    return $field['rating'] > 4.8;
                                })->chunk(3);
                            @endphp
                                
                            @foreach($highRatedFields as $index => $chunk)
                            @if(count($chunk)==3)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="carousel-container row justify-content-center">
                                        
                                        @foreach($chunk as $field)
                                            <div class="col-md-4 d-flex justify-content-center">
                                                <a href="" class="text-decoration-none">
                                                    <div class="card field-card small-card">
                                                        <img src="{{ asset($field['image_path']) }}" class="card-img-top" alt="{{ $field['name'] }}">
                                                        <div class="card-body p-2">
                                                            <h6 class="card-title mb-1">{{ $field['name'] }}</h6>
                                                            <span class="badge bg-primary mb-2">{{ $field['type'] }}</span>
                                                            <div class="rating text-warning small">
                                                                <i class="bi bi-star-fill"></i>
                                                                {{ number_format($field['rating'], 1) }}
                                                                <span class="badge bg-success ms-1">Top Rated</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                       
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                            
                        @if($highRatedFields->count() > 1)
                            <a class="carousel-control-prev" href="#field-carousel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#field-carousel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                            </a>
                        @endif
                    </div>
                        
                    @if($highRatedFields->flatten()->isEmpty())
                        <div class="alert alert-info mt-4">No fields with rating above 4.8 available currently.</div>
                    @endif
                </div>
    
        @endif
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <div><span>Get in</span> <span class="description-title">Touch</span></div>
        </div>
        <div class="container" data-aos="fade">
            <div class="row gy-5 gx-lg-5">
                <div class="col-lg-4">
                    <div class="info">
                        <h3>Contact Us</h3>
                        <div class="info-item d-flex">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h4>Location:</h4>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>
                        </div>
                        <div class="info-item d-flex">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h4>Email:</h4>
                                <p>info@fieldbooking.com</p>
                            </div>
                        </div>
                        <div class="info-item d-flex">
                            <i class="bi bi-phone flex-shrink-0"></i>
                            <div>
                                <h4>Call:</h4>
                                <p>+1 5589 55488 55</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <form action="#" method="post" role="form" class="php-email-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" placeholder="Message" required></textarea>
                        </div>
                        <div class="text-center mt-3"><button type="submit">Send Message</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /Contact Section -->
    </main>
    
   
    
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    </body>
    </x-layout>