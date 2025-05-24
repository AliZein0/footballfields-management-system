<x-layout title="Bookings History">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <x-player_header />
    <div class="main">
        <section class="mt-5">
    
        @if(isset($booking) && isset($payment))
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <span>Booking Details</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Booking Information</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Reference:</span>
                            <span class="fw-bold">BK-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Date:</span>
                            <span class="fw-bold">{{ date('D, M d, Y', strtotime($booking->date)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Time:</span>
                            <span class="fw-bold">{{ date('h:i A', strtotime($booking->start_time)) }} - {{ date('h:i A', strtotime($booking->end_time)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status:</span>
                            <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Payment Information</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Method:</span>
                            <span class="fw-bold">{{ strtoupper($payment->transfer_type) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Transaction ID:</span>
                            <span class="fw-bold">{{ $payment->transfer_code }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Status:</span>
                            <span class="badge bg-{{ $payment->status == 'confirmed' ? 'success' : 'warning' }}">{{ ucfirst($payment->status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Field Fee:</span>
                            <span class="fw-bold">${{ number_format($payment->field_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Website Fee:</span>
                            <span class="fw-bold">${{ number_format($payment->website_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Amount:</span>
                            <span class="fw-bold text-primary">${{ number_format($payment->field_fee + $payment->website_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Paid At:</span>
                            <span class="fw-bold">{{ date('M d, Y h:i A', strtotime($payment->paid_at)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
        <!-- Replace the entire "Top row: Field image and overview" section with this: -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Clickable Field Overview Header (Always Visible) -->
                <h4 class="mb-3 main-field-overview-toggle" style="cursor: pointer; user-select: none;">
                    <i class="fas fa-chevron-down main-field-overview-chevron"></i>
                    Field Overview
                </h4>
                
                <!-- Collapsible Content (Hidden by Default) - Contains Image and Details -->
                <div class="main-field-overview-content" style="display: none;">
                    <!-- Field Image -->
                    <div class="field-image-container mb-3">
                        @if($field['is_covered'])
                            <div class="field-badge">
                                <i class="fas fa-umbrella"></i> Covered
                            </div>
                        @endif

                        @if($field->images->isEmpty())
                            <img src="{{ asset('images/default.jpg') }}" class="field-image" alt="{{ $field['title'] }}">
                        @else
                            <img src="{{ asset($field->images[0]) }}" class="field-image" alt="{{ $field['title'] }}">
                        @endif
                    </div>

                    <!-- Field Details -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap mb-3">
                                <div class="me-4 mb-2">
                                    <i class="fas fa-futbol text-primary me-2"></i>
                                    <span><strong>Type:</strong> {{ $field['type'] }}</span>
                                </div>
                                <div class="me-4 mb-2">
                                    <i class="fas fa-ruler-combined text-primary me-2"></i>
                                    <span><strong>Size:</strong> {{ $field['size'] }}</span>
                                </div>
                                <div class="me-4 mb-2">
                                    <i class="far fa-clock text-primary me-2"></i>
                                    <span><strong>Hours:</strong> {{ $field->defaultSchedule->from_time }} - {{ $field->defaultSchedule->to_time }}</span>
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span><strong>Location:</strong> {{ $field['location'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="field-price mb-2">
                                <span><i class="fas fa-tag me-2"></i> Hourly Rate</span>
                                <span>${{ number_format($field['fees'], 2) }}</span>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <strong class="me-2">Rating:</strong>
                                <span class="text-warning">
                                    @for($i = 0; $i < $field['rating']; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @for($i = $field['rating']; $i < 5; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Second row: Calendar and Slots side by side -->
        <div class="row mb-4">
            <!-- Calendar Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="far fa-calendar-alt"></i>
                        <span>Select Date & Duration</span>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="selectedDate">
                        <div id="booking-calendar"></div>
                        
                        <div class="duration-selector mt-4">
                            <div class="duration-item active" data-duration="1">
                                <span class="duration-value">1</span>
                                <span class="duration-label">Hour</span>
                            </div>
                            <div class="duration-item" data-duration="2">
                                <span class="duration-value">2</span>
                                <span class="duration-label">Hours</span>
                            </div>
                            <div class="duration-item" data-duration="3">
                                <span class="duration-value">3</span>
                                <span class="duration-label">Hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Time Slots Section -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="far fa-clock"></i>
                        <span>Available Time Slots</span>
                    </div>
                    <div class="card-body">
                        <div class="slots-container" id="slots-container">
                            <div class="no-slots-message">
                                <i class="far fa-calendar-check mb-3" style="font-size: 2rem; color: var(--text-secondary);"></i>
                                <h5>Select a date to see available slots</h5>
                                <p class="mb-0">Available time slots will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form Section -->
        <div class="row mb-4" id="booking-form-section" style="display: none;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-check-circle"></i>
                        <span>Complete Your Booking</span>
                    </div>
                    <div class="card-body">
                        <form id="bookingForm" method="POST" action="">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field['id'] }}">
                            <input type="hidden" name="booking_date" id="form-booking-date">
                            <input type="hidden" name="start_time" id="form-start-time">
                            <input type="hidden" name="end_time" id="form-end-time">
                            <input type="hidden" name="duration" id="form-duration">
                            <input type="hidden" name="total_price" id="form-total-price">
                            <input type="hidden" name="website_fee" id="form-website-fee">
                            <input type="hidden" name="field_fee" id="form-field-fee">
                            <input type="hidden" name="status" id="payment_status" value="pending">
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="booking-summary p-4 bg-light rounded mb-3">
                                        <h5 class="mb-3"><i class="fas fa-receipt text-primary me-2"></i>Booking Summary</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Date:</span>
                                            <span id="summary-date" class="fw-bold"></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Time:</span>
                                            <span id="summary-time" class="fw-bold"></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Duration:</span>
                                            <span id="summary-duration" class="fw-bold"></span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Field Fee:</span>
                                            <span id="field-fee" class="fw-bold"></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span>Website Fee (5%):</span>
                                            <span id="website-fee" class="fw-bold"></span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="h6">Total:</span>
                                            <span id="total-amount" class="fw-bold h5 text-primary"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-7">
                                    <h5 class="mb-3">Payment Information</h5>
                                    
                                    <div class="payment-methods mb-4">
                                        <div class="payment-method-item active" data-method="omt">
                                            <div class="payment-method-icon">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <div class="payment-method-name">OMT</div>
                                        </div>
                                        <div class="payment-method-item" data-method="wish">
                                            <div class="payment-method-icon">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div class="payment-method-name">WISH</div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="payment_method" id="payment_method" value="omt">
                                    
                                    <div class="mb-3">
                                        <label for="payment_code" class="form-label">Enter Transfer Code</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="text" class="form-control" id="payment_code" name="payment_code" placeholder="Enter your payment code" required>
                                        </div>
                                        <div class="code-info mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Enter your <span id="code_type">OMT</span> transfer code to complete the booking. This code will be used to verify your payment.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="details" class="form-label">Additional Notes (Optional)</label>
                                        <textarea class="form-control" id="details" name="details" rows="2" placeholder="Any special requests or notes"></textarea>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-outline-secondary me-2" id="cancelBookingBtn">
                                    <i class="fas fa-times-circle me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-success btn-lg" id="submitBookingBtn">
                                    <i class="fas fa-check-circle me-2"></i>Complete Booking
                                </button>
                            </div>
                        </form>
                        
                       <!-- Booking Success Message -->
<div id="booking-success" class="booking-success">
    <div class="booking-success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h4>Booking Successfully Confirmed!</h4>
    <p>Your field has been reserved. Check your email for booking details.</p>
    
    <div class="booking-reference">
        Booking Reference: <span id="booking-reference">FLD-2564879</span>
    </div>
    
    <div class="payment-summary">
        <div class="payment-summary-row">
            <span>Status:</span>
            <span class="badge bg-warning">Payment Pending</span>
        </div>
        <div class="payment-summary-row">
            <span>Payment Method:</span>
            <span id="payment-method-display">OMT</span>
        </div>
        <div class="payment-summary-row">
            <span>Transaction ID:</span>
            <span id="transaction-id">--</span>
        </div>
        <div class="payment-summary-row">
            <span>Field Fee:</span>
            <span id="field-fee-display">$0.00</span>
        </div>
        <div class="payment-summary-row">
            <span>Website Fee:</span>
            <span id="website-fee-display">$0.00</span>
        </div>
        <div class="payment-summary-row">
            <span>Total Amount:</span>
            <span id="payment-amount-display">$0.00</span>
        </div>
    </div>
    
    <p class="mt-3">You will receive a confirmation email once your payment is verified.</p>
    
    <button class="btn btn-primary mt-3" onclick="window.scrollTo({top: 0, behavior: 'instant'}); setTimeout(() => window.location.reload(), 10)">
        <i class="fas fa-plus-circle me-2"></i>Make Another Booking
    </button>
</div>
          
           
    </div>
        </div>
        </div>

    </div>


                    <!-- Map Section -->
<div class="col-lg-12 mb-4 d-block">
    <div class="card h-100">
        <div class="card-header">
            <i class="fas fa-map-marked-alt"></i>
            <span>Field Location</span>
        </div>
        <div class="card-body p-0">
            <div class="map-container">
                <iframe src="{{ $field['mapEmbed'] }}" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">
                        <i class="fas fa-file-contract me-2"></i>Terms and Conditions
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-2">Booking Terms</h6>
                    <ul class="mb-3">
                        <li>Payment must be made upon arrival.</li>
                        <li>Cancellations must be made at least 24 hours in advance for a full refund.</li>
                        <li>You are responsible for any damage caused to the facilities.</li>
                        <li>The field must be vacated promptly at the end of your booking time.</li>
                        <li>Management reserves the right to cancel bookings due to weather conditions or maintenance needs.</li>
                    </ul>
                    <h6 class="mb-2">Rules of Conduct</h6>
                    <ul>
                        <li>No smoking or alcohol consumption on the premises.</li>
                        <li>Proper sports attire and footwear must be worn.</li>
                        <li>No littering; please clean up after your session.</li>
                        <li>Be respectful to staff and other players.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>
    </section>
      <style>
        /* ===== BOOKING PAGE SPECIFIC STYLES - booking.css ===== */

/* ===== FIELD OVERVIEW ===== */
.field-image-container {
    height: 300px; /* Booking page has taller field images */
}

.field-price {
    background: #f0f9ff;
    padding: 1rem;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
    margin-top: 1rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ===== BOOKING FORM SECTION ===== */
#booking-form-section {
    display: none; /* Initially hidden until slot is selected */
}

.booking-summary {
    background: #f8fafc;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
}

/* ===== PAYMENT METHODS ===== */
.payment-methods {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.payment-method-item {
    flex: 1;
    background: #fff;
    border: 2px solid #e2e8f0;
    padding: 1rem;
    border-radius: var(--border-radius);
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-method-item:hover {
    border-color: #cbd5e1;
    transform: translateY(-3px);
}

.payment-method-item.active {
    border-color: var(--primary-color);
    box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);
}

.payment-method-icon {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.payment-method-name {
    font-weight: 600;
    font-size: 0.875rem;
}

/* ===== PAYMENT CODE INPUT ===== */
.code-info {
    padding: 0.75rem;
    background: #f0f9ff;
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    border-left: 3px solid var(--info-color);
    margin-top: 0.5rem;
}

/* ===== BOOKING SUCCESS MESSAGE ===== */
.booking-success {
    background: #ecfdf5;
    border-radius: var(--border-radius);
    padding: 2rem;
    text-align: center;
    box-shadow: var(--shadow);
    margin-top: 1.5rem;
    display: none; /* Initially hidden */
}

.booking-success-icon {
    font-size: 3rem;
    color: var(--success-color);
    margin-bottom: 1rem;
}

.booking-reference {
    background: #fff;
    padding: 1rem;
    border-radius: var(--border-radius);
    border: 1px dashed #a7f3d0;
    margin: 1rem 0;
    font-weight: 700;
    letter-spacing: 1px;
}

.payment-summary {
    background: #fff;
    border-radius: var(--border-radius);
    border: 1px solid #e2e8f0;
    padding: 1rem;
    margin-bottom: 1rem;
}

.payment-summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.payment-summary-row:last-child {
    border-bottom: none;
    font-weight: 700;
    padding-top: 1rem;
    margin-top: 0.5rem;
}

/* ===== BOOKING DETAILS DISPLAY ===== */
.d-flex.justify-content-between.mb-2 {
    padding: 0.25rem 0;
}

.d-flex.justify-content-between.mb-2 .fw-bold {
    color: var(--primary-color);
}

/* ===== RESPONSIVE OVERRIDES FOR BOOKING ===== */
@media (max-width: 768px) {
    .payment-methods {
        flex-direction: column;
    }
    
    .field-image-container {
        height: 250px;
    }
    
    .booking-summary {
        margin-bottom: 1.5rem;
    }

}
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
       

document.addEventListener('DOMContentLoaded', function() {
    // Field data from backend
    const field = @json($field);
    const defaultFromTime = "{{ $field->defaultSchedule->from_time }}";
    const defaultToTime = "{{ $field->defaultSchedule->to_time }}";
    const hourlyRate = parseFloat("{{ $field['fees'] }}");

    let selectedDate = null;
    let selectedSlot = null;
    let selectedDuration = 1;
    let isLoadingSlots = false;

    // Initialize flatpickr calendar with auto-loading slots
    const calendar = flatpickr('#booking-calendar', {
        inline: true,
        minDate: "today",
        defaultDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            selectedDate = dateStr;
            document.getElementById('selectedDate').value = dateStr;
            
            // Auto-load slots when date changes
            loadSlots(dateStr, selectedDuration);
        }
    });

    // Set initial date and load slots
    const today = new Date().toISOString().split('T')[0];
    selectedDate = today;
    document.getElementById('selectedDate').value = today;
    
    // Load slots for today
    loadSlots(today, selectedDuration);

    // Duration selector handling with automatic slot reloading
    const durationItems = document.querySelectorAll('.duration-item');
    durationItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            durationItems.forEach(el => el.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Update selected duration
            selectedDuration = parseInt(this.getAttribute('data-duration'));
            
            // Reload slots with new duration
            if (selectedDate) {
                loadSlots(selectedDate, selectedDuration);
            }
        });
    });

    // Enhanced loadSlots function with better error handling and UI feedback
    async function loadSlots(date, duration) {
        const slotsContainer = document.getElementById('slots-container');
        
        // Show loading state
        if (isLoadingSlots) return; // Prevent multiple simultaneous loading
        
        isLoadingSlots = true;
        slotsContainer.innerHTML = `
            <div class="slots-loader d-flex justify-content-center align-items-center p-4">
                <div class="spinner-border text-primary me-3" role="status">
                    <span class="visually-hidden">Loading slots...</span>
                </div>
                <span>Loading available slots...</span>
            </div>
        `;
        
        try {
            // Fetch already booked slots from server
            const response = await fetch(`/api/fields/${field.id}/booked-slots?date=${date}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const bookedSlots = await response.json();
            
            // Generate all possible slots
            const slots = generateTimeSlots(defaultFromTime, defaultToTime, duration);
            
            // Clear selected slot when reloading
            selectedSlot = null;
            
            // Hide the booking form when reloading slots
            document.getElementById('booking-form-section').style.display = 'none';
            
            if (slots.length === 0) {
                slotsContainer.innerHTML = `
                    <div class="no-slots-message text-center p-4">
                        <i class="fas fa-exclamation-circle mb-3 text-secondary" style="font-size: 2rem;"></i>
                        <h5>No Slots Available</h5>
                        <p class="mb-0">There are no slots available for the selected duration. Please try a shorter duration or another date.</p>
                    </div>
                `;
                return;
            }
            
            // Clear container
            slotsContainer.innerHTML = '';
            
            // Format date for display
            const displayDate = new Date(date);
            const formattedDate = displayDate.toLocaleDateString('en-US', { 
                weekday: 'short', 
                month: 'short', 
                day: 'numeric' 
            });
            
            // Add date display
            slotsContainer.innerHTML = `
                <div class="date-display mb-3 p-2 bg-light rounded text-center">
                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                    <span class="fw-bold">${formattedDate}</span>
                    <span class="ms-2 badge bg-primary">${duration} Hour${duration > 1 ? 's' : ''}</span>
                </div>
            `;
            
            // Create slots container
            const slotsGrid = document.createElement('div');
            slotsGrid.className = 'slots-grid';
            slotsContainer.appendChild(slotsGrid);
            
            // Add slots to container
            slots.forEach(slot => {
                // Check if slot is booked
                slot.status = isSlotBooked(bookedSlots, slot) ? 'booked' : 'available';
                
                const slotElement = document.createElement('div');
                slotElement.className = `slot-item ${slot.status}`;
                slotElement.innerHTML = `
                    <span class="slot-time">${slot.display}</span>
                    <span class="slot-status">${slot.status === 'available' ? 'Available' : 'Booked'}</span>
                `;
                
                if (slot.status === 'available') {
                    slotElement.style.cursor = 'pointer';
                    slotElement.addEventListener('click', () => selectSlot(slot, formattedDate, duration));
                }
                
                slotsGrid.appendChild(slotElement);
            });
            
        } catch (error) {
            console.error('Error loading slots:', error);
            slotsContainer.innerHTML = `
                <div class="no-slots-message text-center p-4">
                    <i class="fas fa-exclamation-triangle mb-3 text-danger" style="font-size: 2rem;"></i>
                    <h5>Error Loading Slots</h5>
                    <p class="mb-3">There was a problem loading the available slots. Please try again.</p>
                    <button class="btn btn-outline-primary" onclick="loadSlots('${date}', ${duration})">
                        <i class="fas fa-redo me-2"></i>Try Again
                    </button>
                </div>
            `;
        } finally {
            isLoadingSlots = false;
        }
    }

    // Enhanced slot selection function
    function selectSlot(slot, formattedDate, duration) {
        // Deselect previous slot if any
        document.querySelectorAll('.slot-item.selected').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Select this slot
        event.currentTarget.classList.add('selected');
        selectedSlot = slot;
        
        // Calculate payment details
        const paymentDetails = calculatePayment(duration, hourlyRate);
        
        // Update booking form with selected slot data
        document.getElementById('form-booking-date').value = selectedDate;
        document.getElementById('form-start-time').value = slot.from;
        document.getElementById('form-end-time').value = slot.to;
        document.getElementById('form-duration').value = duration;
        
        // Update summary display
        document.getElementById('summary-date').textContent = formattedDate;
        document.getElementById('summary-time').textContent = slot.display;
        document.getElementById('summary-duration').textContent = `${duration} Hour${duration > 1 ? 's' : ''}`;
        
        // Update payment display
        document.getElementById('field-fee').textContent = `$${paymentDetails.fieldFee.toFixed(2)}`;
        document.getElementById('website-fee').textContent = `$${paymentDetails.websiteFee.toFixed(2)}`;
        document.getElementById('total-amount').textContent = `$${paymentDetails.total.toFixed(2)}`;
        
        // Show the booking form section with animation
        const formSection = document.getElementById('booking-form-section');
        formSection.style.display = 'block';
        
        // Smooth scroll to the booking form
        setTimeout(() => {
            formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }

    // Rest of your existing functions (unchanged)
    function formatTime(time24h) {
        const [hours, minutes] = time24h.split(':');
        const hour = parseInt(hours, 10);
        const period = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minutes} ${period}`;
    }

    function generateTimeSlots(fromTime, toTime, duration) {
        const slots = [];
        
        const [fromHour, fromMinute] = fromTime.split(':').map(Number);
        const [toHour, toMinute] = toTime.split(':').map(Number);
        
        const startMinutes = fromHour * 60 + fromMinute;
        const endMinutes = toHour * 60 + toMinute;
        
        for (let time = startMinutes; time + (duration * 60) <= endMinutes; time += 60) {
            const hour = Math.floor(time / 60);
            const minute = time % 60;
            
            const slotFromTime = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
            
            const endTime = time + (duration * 60);
            const endHour = Math.floor(endTime / 60);
            const endMinute = endTime % 60;
            
            const slotToTime = `${endHour.toString().padStart(2, '0')}:${endMinute.toString().padStart(2, '0')}`;
            
            slots.push({
                from: slotFromTime,
                to: slotToTime,
                display: `${formatTime(slotFromTime)} - ${formatTime(slotToTime)}`,
                status: 'available'
            });
        }
        
        return slots;
    }

    function isSlotBooked(bookedSlots, slot) {
        if (bookedSlots && bookedSlots.slots) {
            if (bookedSlots.slots[slot.from]) {
                return true;
            }
            
            for (const bookedStart in bookedSlots.slots) {
                const bookedEnd = bookedSlots.slots[bookedStart];
                
                const slotFrom = timeToMinutes(slot.from);
                const slotTo = timeToMinutes(slot.to);
                const bookingFrom = timeToMinutes(bookedStart);
                const bookingTo = timeToMinutes(bookedEnd);
                
                if ((slotFrom >= bookingFrom && slotFrom < bookingTo) || 
                    (slotTo > bookingFrom && slotTo <= bookingTo) ||
                    (slotFrom <= bookingFrom && slotTo >= bookingTo)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    function timeToMinutes(timeStr) {
        const [hours, minutes] = timeStr.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function calculatePayment(duration, hourlyRate) {
        const fieldFee = hourlyRate * duration;
        const websiteFee = fieldFee * 0.05;
        const total = fieldFee + websiteFee;
        
        // Update hidden form fields
        document.getElementById('form-website-fee').value = websiteFee.toFixed(2);
        document.getElementById('form-field-fee').value = fieldFee.toFixed(2);
        document.getElementById('form-total-price').value = total.toFixed(2);
        
        return { fieldFee, websiteFee, total };
    }

    // Enhanced form submission with better error handling
    document.getElementById('bookingForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBookingBtn');
        const originalBtnText = submitBtn.innerHTML;
        const form = this;
        
        // Validate form
        const transferCode = document.getElementById('payment_code').value.trim();
        const transferType = document.getElementById('payment_method').value;
        
        if (!transferCode) {
            showError('Please enter your payment code');
            return;
        }
        
        if (!transferType) {
            showError('Please select a payment method');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';
        submitBtn.disabled = true;
        
        try {
            const formData = new FormData(form);
            const timeout = 10000; // 10 seconds timeout
            
            const response = await Promise.race([
                fetch('/bookings', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                }),
                new Promise((_, reject) => 
                    setTimeout(() => reject(new Error('Request timeout')), timeout)
                )
            ]);
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(
                    errorData.message || 
                    (errorData.errors ? Object.values(errorData.errors).flat().join('\n') : '') ||
                    `Server responded with status ${response.status}`
                );
            }
            
            const data = await response.json();
            
            // Hide form and show success message
            form.style.display = 'none';
            showSuccessMessage(data, transferCode, transferType);
            
        } catch (error) {
            console.error('Booking error:', error);
            showError(error.message || 'An error occurred while processing your booking. Please try again.');
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });

    // Enhanced error display function
    function showError(message) {
        // Remove any existing error messages
        const existingErrors = document.querySelectorAll('.alert-danger');
        existingErrors.forEach(el => el.remove());
        
        // Create error element
        const errorElement = document.createElement('div');
        errorElement.className = 'alert alert-danger alert-dismissible fade show';
        errorElement.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert error message at the top of the form
        const form = document.getElementById('bookingForm');
        form.insertBefore(errorElement, form.firstChild);
        
        // Scroll to error message
        errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Auto-hide error after 5 seconds
        setTimeout(() => {
            if (errorElement && errorElement.parentNode) {
                errorElement.remove();
            }
        }, 5000);
    }

    // Enhanced success message function
    function showSuccessMessage(data, transferCode, transferType) {
        const fieldFee = document.getElementById('field-fee').textContent;
        const websiteFee = document.getElementById('website-fee').textContent;
        const totalAmount = document.getElementById('total-amount').textContent;
        
        // Update success message details
        document.getElementById('booking-reference').textContent = data.reference || 'FLD-' + Math.floor(Math.random() * 10000000);
        document.getElementById('payment-method-display').textContent = transferType.toUpperCase();
        document.getElementById('transaction-id').textContent = transferCode;
        document.getElementById('field-fee-display').textContent = fieldFee;
        document.getElementById('website-fee-display').textContent = websiteFee;
        document.getElementById('payment-amount-display').textContent = totalAmount;
        
        // Show success message with animation
        const successElement = document.getElementById('booking-success');
        successElement.style.display = 'block';
        successElement.style.opacity = '0';
        
        // Fade in animation
        setTimeout(() => {
            successElement.style.transition = 'opacity 0.5s ease-in-out';
            successElement.style.opacity = '1';
        }, 100);
        
        // Scroll to success message
        successElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Cancel booking button handler
    document.getElementById('cancelBookingBtn').addEventListener('click', function() {
        document.getElementById('booking-form-section').style.display = 'none';
        
        // Deselect any selected slot
        document.querySelectorAll('.slot-item.selected').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Scroll to slots section
        document.getElementById('slots-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Payment method handling (unchanged)
    const paymentMethods = document.querySelectorAll('.payment-method-item');
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            
            const paymentType = this.getAttribute('data-method');
            document.getElementById('payment_method').value = paymentType;
            document.getElementById('code_type').textContent = paymentType.toUpperCase();
        });
    });

    // Field overview toggle functionality (unchanged)
    const mainToggle = document.querySelector('.main-field-overview-toggle');
    const mainContent = document.querySelector('.main-field-overview-content');
    const mainChevron = document.querySelector('.main-field-overview-chevron');
    
    if (mainToggle && mainContent && mainChevron) {
        mainToggle.addEventListener('click', function() {
            const isHidden = mainContent.style.display === 'none' || !mainContent.classList.contains('show');
            
            if (isHidden) {
                mainContent.style.display = 'block';
                mainContent.classList.add('show');
                mainChevron.style.transform = 'rotate(180deg)';
            } else {
                mainContent.classList.remove('show');
                mainChevron.style.transform = 'rotate(0deg)';
                
                setTimeout(() => {
                    if (!mainContent.classList.contains('show')) {
                        mainContent.style.display = 'none';
                    }
                }, 300);
            }
        });
    }

    // Make loadSlots available globally for retry buttons
    window.loadSlots = loadSlots;
});

    </script>
</x-layout>