<x-layout title="Bookings History">
    <div class="app-container">
        <div class="app-header">
            <h1 class="app-title">My Bookings</h1>
            <p class="text-secondary">Track and manage all your field reservations in one place</p>
        </div>
        
        <!-- Stats cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['upcoming'] }}</div>
                    <div class="stat-label">Upcoming Bookings</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-hourglass-end"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['completed'] }}</div>
                    <div class="stat-label">Completed Bookings</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['cancelled'] }}</div>
                    <div class="stat-label">Cancelled Bookings</div>
                </div>
            </div>
        </div>
    
        <!-- Tab navigation -->
        <div class="tab-navigation mb-4">
            <div class="tab-item {{ request('status', 'upcoming') == 'upcoming' ? 'active' : '' }}" data-tab="upcoming">
                <i class="fas fa-calendar-alt"></i>
                <span>Upcoming ({{ $stats['upcoming'] }})</span>
            </div>
            <div class="tab-item {{ request('status') == 'completed' ? 'active' : '' }}" data-tab="completed">
                <i class="fas fa-check-circle"></i>
                <span>Completed ({{ $stats['completed'] }})</span>
            </div>
            <div class="tab-item {{ request('status') == 'cancelled' ? 'active' : '' }}" data-tab="cancelled">
                <i class="fas fa-ban"></i>
                <span>Cancelled ({{ $stats['cancelled'] }})</span>
            </div>
            <div class="tab-item {{ request('status') == 'all' ? 'active' : '' }}" data-tab="all">
                <i class="fas fa-list"></i>
                <span>All Bookings ({{ $stats['total'] }})</span>
            </div>
        </div>
    
        <!-- Filters -->
        <div class="filter-controls mb-4">
            <div class="filter-title">
                <i class="fas fa-filter me-2 text-primary"></i>
                Filter Bookings
            </div>
            <form id="filterForm" method="GET" action="{{ route('bookings.history') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="date-range-picker">
                            <div class="filter-input-group">
                                <i class="far fa-calendar-alt"></i>
                                <input type="date" class="filter-input" name="from_date" placeholder="From Date" value="{{ request('from_date') }}">
                            </div>
                            <div class="filter-input-group">
                                <i class="far fa-calendar-alt"></i>
                                <input type="date" class="filter-input" name="to_date" placeholder="To Date" value="{{ request('to_date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="filter-input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" class="filter-input" name="search" placeholder="Search field or reference" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-end h-100 align-items-center">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="status" id="statusFilter" value="{{ request('status', 'upcoming') }}">
                        <div class="status-filters">
                            <div class="status-filter {{ request('status') == 'all' ? 'active' : '' }}" data-status="all">
                                <i class="fas fa-list"></i>
                                All
                            </div>
                            <div class="status-filter {{ request('status', 'upcoming') == 'upcoming' ? 'active' : '' }}" data-status="upcoming">
                                <i class="fas fa-check-circle"></i>
                                Upcoming
                            </div>
                            <div class="status-filter {{ request('status') == 'completed' ? 'active' : '' }}" data-status="completed">
                                <i class="fas fa-check-double"></i>
                                Completed
                            </div>
                            <div class="status-filter {{ request('status') == 'cancelled' ? 'active' : '' }}" data-status="cancelled">
                                <i class="fas fa-ban"></i>
                                Cancelled
                            </div>
                            @if(request('from_date') || request('to_date') || request('search'))
                            <a href="{{ route('bookings.history') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
        @endif
    
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
        @endif
    
        <!-- Tab content -->
        <div class="tab-content d-block">
            <!-- Bookings List -->
            <div class="booking-list">
               
                @forelse($bookings as $booking)

                
                <div class="booking-item" data-status="{{ $booking->status }}">
                    <div class="booking-item-header">
                        <div class="booking-item-date">
                            {{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}
                        </div>
                        <div class="booking-status {{ $booking->status }}">
                            @if($booking->status == 'upcoming')
                                <i class="fas fa-clock"></i>
                                Upcoming
                            @elseif($booking->status == 'completed')
                                <i class="fas fa-check-double"></i>
                                Completed
                            @elseif($booking->status == 'cancelled')
                                <i class="fas fa-ban"></i>
                                Cancelled
                            @endif
                        </div>
                    </div>
                    <div class="booking-item-content">
                        
                        <div class="booking-item-details">
                            <div class="booking-item-title">{{ $booking->sportfield->name }}</div>
    
                            <ul class="booking-info-list">
                                <li class="booking-info-item">
                                    <i class="far fa-clock"></i>
                                    <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</span>
                                </li>
                                <li class="booking-info-item">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>{{ $booking->duration ?? 1 }} {{ ($booking->duration ?? 1) > 1 ? 'Hours' : 'Hour' }}</span>
                                </li>
                                <li class="booking-info-item">
                                    <i class="fas fa-tag"></i>
                                    <span>${{ number_format($booking->payment ? $booking->payment->field_fee + $booking->payment->website_fee : 0, 2) }}</span>
                                </li>
                                <li class="booking-info-item">
                                    <i class="fas fa-credit-card"></i>
                                    <span>{{ $booking->payment ? strtoupper($booking->payment->transfer_type ?? 'N/A') : 'N/A' }}</span>
                                </li>
                                <li class="booking-info-item">
                                    <i class="fas fa-receipt"></i>
                                    <span>Ref: BK-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </li>
                            </ul>
    
                            <div class="booking-item-actions">
                                
    
                                <!-- Edit Button (only for upcoming bookings) -->
                                @if($booking->status == 'upcoming' )
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Edit Booking
                                </a>
                                @endif
    
                                <!-- Cancel Button (only for upcoming bookings) -->
                                @if($booking->status == 'upcoming')
                                <button type="button" class="btn btn-outline-danger cancel-booking-btn" data-bs-toggle="modal" data-bs-target="#cancelBookingModal" data-booking-id="{{ $booking->id }}" data-booking-reference="BK-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}" data-booking-field="{{ $booking->sportfield->name }}" data-booking-date="{{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}" data-booking-time="{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}">
                                    <i class="fas fa-ban"></i>
                                    Cancel
                                </button>
                                @endif
    
                                <!-- Rebook Button (for completed or cancelled bookings) -->
                                @if($booking->status == 'completed' || $booking->status == 'cancelled')
                                <a href="{{ route('booking.show', ['player' => session('player_id'), 'field' => $booking->field_id]) }}" class="btn btn-outline-success">
                                    <i class="fas fa-redo"></i>
                                    Book Again
                                </a>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="empty-state-title">No Bookings Found</h3>
                    <p class="empty-state-text">No bookings match your current filters. Try adjusting your search criteria or create a new booking.</p>
                    <a href="" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        Book a Field
                    </a>
                </div>
                @endforelse
            </div>
    
            <!-- Pagination with fallback styling -->
            @if($bookings->hasPages())
            <div class="pagination-container">
               
                {{ $bookings->appends(request()->except('page'))->links() }}
            </div>
            @endif
        </div>
    </div>
    
    <!-- Cancellation Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelBookingModalLabel">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Cancel Booking
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> You are about to cancel your booking. This action cannot be undone.
                    </div>
                    
                    <p>Please confirm that you want to cancel your booking for:</p>
                    <ul>
                        <li><strong>Field:</strong> <span id="modal-field-name"></span></li>
                        <li><strong>Date:</strong> <span id="modal-booking-date"></span></li>
                        <li><strong>Time:</strong> <span id="modal-booking-time"></span></li>
                        <li><strong>Reference:</strong> <span id="modal-booking-reference"></span></li>
                    </ul>
                    
                    <p class="mb-0"><strong>Cancellation Policy:</strong></p>
                    <ul>
                        <li>Cancellations made more than 24 hours in advance will receive a full refund.</li>
                        <li>Cancellations made less than 24 hours in advance may be subject to partial or no refund.</li>
                    </ul>
                    
                    <form id="cancelBookingForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label">Reason for Cancellation (Optional)</label>
                            <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" placeholder="Please provide a reason for your cancellation"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelButton">
                        <i class="fas fa-ban me-2"></i>Confirm Cancellation
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab navigation
            const tabItems = document.querySelectorAll('.tab-item');
            const statusFilter = document.getElementById('statusFilter');
    
            if (tabItems.length > 0 && statusFilter) {
                tabItems.forEach(item => {
                    item.addEventListener('click', function () {
                        const status = this.getAttribute('data-tab');
                        statusFilter.value = status;
                        document.getElementById('filterForm').submit();
                    });
                });
            }
    
            // Status filters
            const statusFilters = document.querySelectorAll('.status-filter');
    
            if (statusFilters.length > 0 && statusFilter) {
                statusFilters.forEach(filter => {
                    filter.addEventListener('click', function () {
                        const status = this.getAttribute('data-status');
                        statusFilter.value = status;
                        document.getElementById('filterForm').submit();
                    });
                });
            }
    
            // Cancel booking modal
            const cancelBookingButtons = document.querySelectorAll('.cancel-booking-btn');
            const cancelBookingForm = document.getElementById('cancelBookingForm');
    
            if (cancelBookingButtons.length > 0 && cancelBookingForm) {
                cancelBookingButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const bookingId = this.getAttribute('data-booking-id');
                        const bookingReference = this.getAttribute('data-booking-reference');
                        const bookingField = this.getAttribute('data-booking-field');
                        const bookingDate = this.getAttribute('data-booking-date');
                        const bookingTime = this.getAttribute('data-booking-time');
    
                        cancelBookingForm.action = `/bookings/${bookingId}/cancel`;
    
                        document.getElementById('modal-field-name').textContent = bookingField;
                        document.getElementById('modal-booking-date').textContent = bookingDate;
                        document.getElementById('modal-booking-time').textContent = bookingTime;
                        document.getElementById('modal-booking-reference').textContent = bookingReference;
                    });
                });
    
                // Form validation before submission
                const confirmCancelButton = document.getElementById('confirmCancelButton');
                if (confirmCancelButton) {
                    confirmCancelButton.addEventListener('click', function () {
                        // You could add additional validation here if needed
                        cancelBookingForm.submit();
                    });
                }
            }
        });
    </script>
     <style>
        /* Bookings History Stylesheet */
        :root {
            --primary-color: #2563eb;
            --secondary-color: #0f172a;
            --success-color: #059669;
            --danger-color: #e11d48;
            --warning-color: #f59e0b;
            --info-color: #0284c7;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-radius: 12px;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .app-container {
            max-width: 1340px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .app-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .app-title {
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }
        
        .app-title:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .text-secondary {
            color: var(--text-secondary);
        }
        
        /* Stats cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-icon.primary {
            background-color: var(--primary-color);
        }
        
        .stat-icon.success {
            background-color: var(--success-color);
        }
        
        .stat-icon.warning {
            background-color: var(--warning-color);
        }
        
        .stat-icon.danger {
            background-color: var(--danger-color);
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.3rem;
            color: var(--text-primary);
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        /* Tab navigation */
        .tab-navigation {
            display: flex;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .tab-navigation .tab-item {
            flex: 1;
            text-align: center;
            padding: 1rem;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tab-navigation .tab-item i {
            margin-right: 0.5rem;
        }
        
        .tab-navigation .tab-item:hover {
            color: var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
        }
        
        .tab-navigation .tab-item.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
        }
        
        /* Filter controls */
        .filter-controls {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.25rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }
        
        .filter-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        .date-range-picker {
            display: flex;
            gap: 1rem;
        }
        
        .filter-input-group {
            position: relative;
            flex: 1;
        }
        
        .filter-input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }
        
        .filter-input {
            padding-left: 2.5rem;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            width: 100%;
            height: 45px;
            transition: all 0.3s ease;
        }
        
        .filter-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
            outline: none;
        }
          /* Minimal pagination fallback styling */
          .pagination-fallback {
                        display: flex;
                        list-style: none;
                        padding: 0;
                        margin: 20px 0;
                        justify-content: center;
                    }
                    .pagination-fallback li {
                        margin: 0 5px;
                    }
                    .pagination-fallback a, .pagination-fallback span {
                        display: block;
                        padding: 8px 12px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        text-decoration: none;
                        color: #333;
                    }
                    .pagination-fallback .active span {
                        background-color: #2563eb;
                        color: white;
                        border-color: #2563eb;
                    }
                    .pagination-fallback .disabled span {
                        color: #aaa;
                        cursor: not-allowed;
                    }
        
        .status-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .status-filter {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        
        .status-filter.active {
            background-color: rgba(37, 99, 235, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .status-filter i {
            margin-right: 0.4rem;
        }
        
        .btn-filter {
            display: flex;
            align-items: center;
            margin-left: auto;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-filter:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .btn-filter i {
            margin-right: 0.5rem;
        }
        
        /* Booking items */
        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .booking-item {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }
        
        .booking-item:hover {
            transform: translateY(-5px);
        }
        
        .booking-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .booking-item-date {
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .booking-status {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .booking-status.upcoming {
            background-color: rgba(2, 132, 199, 0.1);
            color: var(--info-color);
        }
        
        .booking-status.completed {
            background-color: rgba(5, 150, 105, 0.1);
            color: var(--success-color);
        }
        
        .booking-status.cancelled {
            background-color: rgba(225, 29, 72, 0.1);
            color: var(--danger-color);
        }
        
        .booking-status i {
            margin-right: 0.4rem;
        }
        
        .booking-item-content {
            display: flex;
            padding: 1.5rem;
        }
        
        .booking-item-image {
            width: 180px;
            height: 140px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        
        .booking-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .booking-item-details {
            flex: 1;
        }
        
        .booking-item-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        .booking-info-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding: 0;
            list-style: none;
        }
        
        .booking-info-item {
            display: flex;
            align-items: center;
        }
        
        .booking-info-item i {
            color: var(--text-secondary);
            margin-right: 0.5rem;
            width: 16px;
        }
        
        .booking-item-actions {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn i {
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .btn-outline-primary {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: rgba(37, 99, 235, 0.1);
        }
        
        .btn-outline-danger {
            background-color: transparent;
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }
        
        .btn-outline-danger:hover {
            background-color: rgba(225, 29, 72, 0.1);
        }
        
        .btn-outline-success {
            background-color: transparent;
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
        
        .btn-outline-success:hover {
            background-color: rgba(5, 150, 105, 0.1);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-danger:hover {
            background-color: #be123c;
        }
        
        .btn-secondary {
            background-color: #64748b;
            color: white;
            border: none;
        }
        
        .btn-secondary:hover {
            background-color: #475569;
        }
        
        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .empty-state-text {
            color: var(--text-secondary);
            max-width: 500px;
            margin-bottom: 1.5rem;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: rgba(5, 150, 105, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .alert-danger {
            background-color: rgba(225, 29, 72, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border-left: 4px solid var(--warning-color);
        }
        
        .alert i {
            margin-right: 0.5rem;
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }
        
        /* Form elements */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
            outline: none;
        }
        
        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 0.3rem;
        }
        
        .page-item {
            margin: 0;
        }
        
        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            min-width: 40px;
            padding: 0 0.75rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            color: var(--text-primary);
            background-color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .page-link:hover {
            background-color: #f1f5f9;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .page-item.disabled .page-link {
            color: #94a3b8;
            pointer-events: none;
            background-color: #f8fafc;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .booking-info-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .tab-navigation {
                flex-direction: column;
            }
            
            .tab-navigation .tab-item {
                border-bottom: none;
                border-left: 3px solid transparent;
                text-align: left;
                justify-content: flex-start;
            }
            
            .tab-navigation .tab-item.active {
                border-left-color: var(--primary-color);
                border-bottom-color: transparent;
            }
            
            .booking-item-content {
                flex-direction: column;
            }
            
            .booking-item-image {
                width: 100%;
                height: 180px;
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .booking-info-list {
                grid-template-columns: 1fr;
            }
            
            .booking-item-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .booking-item-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .date-range-picker {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
            }
        }
        </style>

        <script>
            // Cancel booking modal
const cancelBookingButtons = document.querySelectorAll('.cancel-booking-btn');
const cancelBookingForm = document.getElementById('cancelBookingForm');

if (cancelBookingButtons.length > 0 && cancelBookingForm) {
    cancelBookingButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bookingId = this.getAttribute('data-booking-id');
            const bookingReference = this.getAttribute('data-booking-reference');
            const bookingField = this.getAttribute('data-booking-field');
            const bookingDate = this.getAttribute('data-booking-date');
            const bookingTime = this.getAttribute('data-booking-time');

            // Set the form action using the Laravel route helper
            cancelBookingForm.action = `/bookings/${bookingId}/cancel`;
            
            // Also set the booking ID in a hidden field as a backup
            document.getElementById('cancellation_booking_id').value = bookingId;

            document.getElementById('modal-field-name').textContent = bookingField;
            document.getElementById('modal-booking-date').textContent = bookingDate;
            document.getElementById('modal-booking-time').textContent = bookingTime;
            document.getElementById('modal-booking-reference').textContent = bookingReference;
        });
    });

    // Form validation before submission
    const confirmCancelButton = document.getElementById('confirmCancelButton');
    if (confirmCancelButton) {
        confirmCancelButton.addEventListener('click', function () {
            // You could add additional validation here if needed
            cancelBookingForm.submit();
        });
    }
}
        </script>
</x-layout>