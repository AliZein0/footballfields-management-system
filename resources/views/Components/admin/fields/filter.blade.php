<!-- resources/views/components/admin/fields/filter.blade.php -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Fields</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.fields.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="football" {{ request('type') == 'football' ? 'selected' : '' }}>Football</option>
                        <option value="basketball" {{ request('type') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                        <option value="tennis" {{ request('type') == 'tennis' ? 'selected' : '' }}>Tennis</option>
                        <option value="volleyball" {{ request('type') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ request('city') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="">All Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="min_rating" class="form-label">Min Rating</label>
                    <select class="form-select" id="min_rating" name="min_rating">
                        <option value="">Any Rating</option>
                        <option value="5" {{ request('min_rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                        <option value="3" {{ request('min_rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                        <option value="2" {{ request('min_rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="fees" class="form-label">Price Range</label>
                    <select class="form-select" id="fees" name="fees">
                        <option value="">Any Price</option>
                        <option value="0-50" {{ request('fees') == '0-50' ? 'selected' : '' }}>$0 - $50</option>
                        <option value="50-100" {{ request('fees') == '50-100' ? 'selected' : '' }}>$50 - $100</option>
                        <option value="100-200" {{ request('fees') == '100-200' ? 'selected' : '' }}>$100 - $200</option>
                        <option value="200+" {{ request('fees') == '200+' ? 'selected' : '' }}>$200+</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="rating" {{ (request('sort') == 'rating' || !request('sort')) ? 'selected' : '' }}>Rating (High to Low)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price (High to Low)</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="is_covered" class="form-label">Covered</label>
                    <select class="form-select" id="is_covered" name="is_covered">
                        <option value="">All</option>
                        <option value="1" {{ request('is_covered') === '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_covered') === '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.fields.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>