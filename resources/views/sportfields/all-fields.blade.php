<!-- all-fields.blade.php -->
<x-layout title="All Venues - Sports Booking">
   <link rel="stylesheet" href="{{ asset('css/player-index.css') }}">
    <x-player_header>
    </x-player_header>

    <main class="main-content">
        <div class="container">

        <!-- All Venues Section -->
        <section id="all-venues" class="all-venues py-4">
            <div class="container">
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="section-title">
                            @if(isset($pageTitle))
                                {{ $pageTitle }}
                            @else
                                All Venues
                            @endif
                        </h2>
                        <p class="text-muted">{{ $allFields->count() }} venues available</p>
                    </div>
                    
                    <div class="sort-options">
                        <label for="sort-by" class="me-2">Sort by:</label>
                        <select id="sort-by" class="form-select sort-select" onchange="window.location.href = this.value;">
                            <option value="{{ route('fields.all', array_merge(request()->except('sort'), ['sort' => 'rating'])) }}" 
                                    {{ request('sort') == 'rating' || !request('sort') ? 'selected' : '' }}>
                                Rating (High to Low)
                            </option>
                            <option value="{{ route('fields.all', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                    {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                Price (Low to High)
                            </option>
                            <option value="{{ route('fields.all', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                    {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                Price (High to Low)
                            </option>
                            <option value="{{ route('fields.all', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                    {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Newest First
                            </option>
                        </select>
                    </div>
                </div>
                
                <!-- Applied Filters Display -->
                @if(request('city') || request('type') || request('name') || request('size') || request('fees') || request('is_covered') !== null || request('min_rating'))
                    <div class="applied-filters mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <h3 class="h6 mb-0 me-2">Applied Filters:</h3>
                            <a href="{{ route('fields.all') }}" class="btn btn-sm btn-outline-danger">Clear All</a>
                        </div>
                        <div class="filter-tags">
                            @if(request('city'))
                                <div class="filter-tag">
                                    City: {{ App\Models\SportField::LOCATIONS[request('city')] ?? request('city') }}
                                    <a href="{{ route('fields.all', array_merge(request()->except('city'), ['city' => ''])) }}" class="remove-filter" aria-label="Remove city filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('type'))
                                <div class="filter-tag">
                                    Sport: {{ request('type') }}
                                    <a href="{{ route('fields.all', array_merge(request()->except('type'), ['type' => ''])) }}" class="remove-filter" aria-label="Remove type filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('name'))
                                <div class="filter-tag">
                                    Name: {{ request('name') }}
                                    <a href="{{ route('fields.all', array_merge(request()->except('name'), ['name' => ''])) }}" class="remove-filter" aria-label="Remove name filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('size'))
                                <div class="filter-tag">
                                    Size: {{ ucfirst(request('size')) }}
                                    <a href="{{ route('fields.all', array_merge(request()->except('size'), ['size' => ''])) }}" class="remove-filter" aria-label="Remove size filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('fees'))
                                <div class="filter-tag">
                                    Price: 
                                    @switch(request('fees'))
                                        @case('0-50')
                                            $0 - $50
                                            @break
                                        @case('50-100')
                                            $50 - $100
                                            @break
                                        @case('100-200')
                                            $100 - $200
                                            @break
                                        @case('200+')
                                            $200+
                                            @break
                                        @default
                                            {{ request('fees') }}
                                    @endswitch
                                    <a href="{{ route('fields.all', array_merge(request()->except('fees'), ['fees' => ''])) }}" class="remove-filter" aria-label="Remove fees filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('is_covered') !== null && request('is_covered') !== '')
                                <div class="filter-tag">
                                    Venue Type: {{ request('is_covered') == '1' ? 'Indoor' : 'Outdoor' }}
                                    <a href="{{ route('fields.all', array_merge(request()->except('is_covered'), ['is_covered' => ''])) }}" class="remove-filter" aria-label="Remove venue type filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('min_rating'))
                                <div class="filter-tag">
                                    Rating: {{ request('min_rating') }}+ Stars
                                    <a href="{{ route('fields.all', array_merge(request()->except('min_rating'), ['min_rating' => ''])) }}" class="remove-filter" aria-label="Remove rating filter">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <!-- Venues Grid -->
                <div class="venues-grid">
                    <div class="row g-4">
                        @if($allFields->isNotEmpty())
                            @foreach($allFields as $field)
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
                                <div class="alert alert-info text-center p-4">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <h4>No Venues Found</h4>
                                    <p>No venues match your current filters. Try adjusting your search criteria or <a href="{{ route('fields.all') }}">clear all filters</a>.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Pagination if needed -->
                @if($allFields->hasPages())
                    <div class="pagination-container mt-5">
                        {{ $allFields->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>
    

    
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
    });
    </script>
    <style>
        /* Additional CSS for the All Fields page */

/* Applied filters styling */
.applied-filters {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
}

.filter-tag {
    background-color: #e9f0fd;
    color: #0056b3;
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
}

.filter-tag .remove-filter {
    color: #0056b3;
    background-color: rgba(0, 0, 0, 0.1);
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-left: 8px;
    font-size: 10px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.filter-tag .remove-filter:hover {
    background-color: rgba(0, 0, 0, 0.2);
}

/* Sorting dropdown styling */
.sort-select {
    min-width: 180px;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 8px 12px;
    font-size: 14px;
}

/* Pagination styling */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.pagination .page-item .page-link {
    border-radius: 4px;
    color: #0056b3;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background-color: #0056b3;
    color: #fff;
    border-color: #0056b3;
}

.pagination .page-item .page-link:hover {
    background-color: #e9ecef;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
}

/* Empty results styling */
.alert-info {
    border-left: 4px solid #0dcaf0;
}

.alert-info i {
    color: #0dcaf0;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .sort-options {
        margin-top: 15px;
        width: 100%;
    }
    
    .sort-select {
        width: 100%;
    }
}

@media (max-width: 767px) {
    .applied-filters {
        padding: 12px;
    }
    
    .filter-tag {
        font-size: 13px;
        padding: 5px 10px;
    }
    
    .filter-tags {
        gap: 8px;
    }
}
    </style>
</x-layout>