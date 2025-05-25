<x-layout title="Bookings History">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <x-player_header />
    <div class="main">
    <section class="mt-5">
    
        <div class="app-header">
            <h1 class="app-title">Edit Booking</h1>
           </div>

  

        <!-- Current Booking Details -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <span>Current Booking Details</span>
            </div>
            <div class="card-body">
                <div class="booking-details">
                    <div class="booking-details-item">
                        <div class="booking-details-label">Date</div>
                        <div class="booking-details-value">{{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Time</div>
                        <div class="booking-details-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Duration</div>
                        <div class="booking-details-value">
                            @php
                                $start = $booking->start_time;
                                $end = $booking->end_time;
                                $duration = $booking->duration;
                            @endphp
                            {{ $duration }} {{ $duration > 1 ? 'Hours' : 'Hour' }}
                        </div>
                    </div>
                    
                    <!-- Payment Details - Updated to use Payment table -->
                    @if(isset($payment))
                    <div class="booking-details-item">
                        <div class="booking-details-label">Payment Method</div>
                        <div class="booking-details-value">{{ strtoupper($payment->transfer_type) }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Payment Status</div>
                        <div class="booking-details-value">
                            <span class="status-badge {{ strtolower($payment->status) }}">
                                @if($payment->status == 'confirmed')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($payment->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @else
                                    <i class="fas fa-ban"></i>
                                @endif
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Transaction ID</div>
                        <div class="booking-details-value">{{ $payment->transfer_code }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Field Fee</div>
                        <div class="booking-details-value">${{ number_format($payment->field_fee, 2) }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Website Fee</div>
                        <div class="booking-details-value">${{ number_format($payment->website_fee, 2) }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Total Amount</div>
                        <div class="booking-details-value">${{ number_format($payment->field_fee + $payment->website_fee, 2) }}</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Paid At</div>
                        <div class="booking-details-value">{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y g:i A') }}</div>
                    </div>
                    @else
                    <!-- Fallback to booking model if payment record doesn't exist -->
                    <div class="booking-details-item">
                        <div class="booking-details-label">Payment Status</div>
                        <div class="booking-details-value">
                            <span class="status-badge pending">
                                <i class="fas fa-clock"></i>
                                Pending
                            </span>
                        </div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Field Fee</div>
                        <div class="booking-details-value">$0.00</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Website Fee</div>
                        <div class="booking-details-value">$0.00</div>
                    </div>
                    <div class="booking-details-item">
                        <div class="booking-details-label">Total Amount</div>
                        <div class="booking-details-value">$0.00</div>
                    </div>
                    @endif
                </div>

                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    You can modify your booking details below. If you change the date, time, or duration, pricing may be updated accordingly.
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Edit Booking Form -->
        <form id="editBookingForm" method="POST" action="{{ route('bookings.update', $booking->id) }}">
            @csrf
            @method('POST')
            <input type="hidden" name="field_id" value="{{ $booking->field_id }}">
            <input type="hidden" name="original_booking_date" value="{{ $booking->date->format('Y-m-d') }}">
            <input type="hidden" name="original_start_time" value="{{ $booking->start_time }}">
            <input type="hidden" name="original_end_time" value="{{ $booking->end_time }}">
            <input type="hidden" name="original_duration" value="{{ $booking->duration }}">

            <div class="row mb-4">
                <!-- Calendar Section -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="far fa-calendar-alt"></i>
                            <span>Select New Date</span>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="selectedDate" name="booking_date" value="{{ $booking->date->format('Y-m-d') }}">
                            <div id="booking-calendar"></div>
                            
                            <div class="duration-selector mt-4">
                                <div class="duration-item {{ $booking->duration == 1 ? 'active' : '' }}" data-duration="1">
                                    <span class="duration-value">1</span>
                                    <span class="duration-label">Hour</span>
                                </div>
                                <div class="duration-item {{ $booking->duration == 2 ? 'active' : '' }}" data-duration="2">
                                    <span class="duration-value">2</span>
                                    <span class="duration-label">Hours</span>
                                </div>
                                <div class="duration-item {{ $booking->duration == 3 ? 'active' : '' }}" data-duration="3">
                                    <span class="duration-value">3</span>
                                    <span class="duration-label">Hours</span>
                                </div>
                            </div>
                            <input type="hidden" id="selectedDuration" name="duration" value="{{ $booking->duration }}">
                        </div>
                    </div>
                </div>
                
                <!-- Time Slots Section -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="far fa-clock"></i>
                            <span>Select New Time Slot</span>
                        </div>
                        <div class="card-body">
                            <div class="slots-container" id="slots-container">
                                <!-- Slots will be loaded here via JavaScript -->
                                <div class="slots-loader">
                                    <div class="slots-loader-spinner"></div>
                                </div>
                            </div>
                            <input type="hidden" id="selectedSlotStart" name="start_time" value="{{ $booking->start_time }}">
                            <input type="hidden" id="selectedSlotEnd" name="end_time" value="{{ $booking->end_time }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Options -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-cog"></i>
                            <span>Additional Options</span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="details" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="details" name="details" rows="3" placeholder="Any special requests or notes">{{ $booking->details }}</textarea>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Important:</strong> Changing your booking may affect pricing. Review details carefully before submitting.
                            </div>
                            
                            @if($booking->status == 'confirmed')
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="sendConfirmation" name="send_confirmation" checked>
                                <label class="form-check-label" for="sendConfirmation">Send me an email confirmation of these changes</label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Section (appears when changes are made) -->
<div class="row mb-4" id="changesSummary" style="display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exchange-alt"></i>
                <span>Changes Summary</span>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Review Changes:</strong> Please review the changes below before confirming your booking update.
                </div>
                
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Detail</th>
                            <th>Original Booking</th>
                            <th>New Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="dateSummaryRow" style="display: none;">
                            <td>Date</td>
                            <td class="old-value">{{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}</td>
                            <td class="new-value" id="newDateSummary"></td>
                        </tr>
                        <tr id="timeSummaryRow" style="display: none;">
                            <td>Time</td>
                            <td class="old-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</td>
                            <td class="new-value" id="newTimeSummary"></td>
                        </tr>
                        <tr id="durationSummaryRow" style="display: none;">
                            <td>Duration</td>
                            <td class="old-value">
                                @php
                                   
                                    $duration = $booking->duration;
                                @endphp
                                {{ $duration }} {{ $duration > 1 ? 'Hours' : 'Hour' }}
                            </td>
                            <td class="new-value" id="newDurationSummary"></td>
                        </tr>
                        <tr id="priceSummaryRow" style="display: none;">
                            <td>Total Price</td>
                            <td class="old-value">
                                @if(isset($payment))
                                    ${{ number_format($payment->field_fee + $payment->website_fee, 2) }}
                                @else
                                    $0.00
                                @endif
                            </td>
                            <td class="new-value" id="newPriceSummary"></td>
                        </tr>
                    </tbody>
                </table>
                
                <div id="priceDifferenceAlert" class="alert alert-warning" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="priceDifferenceText"></span>
                </div>
                
                <input type="hidden" name="new_field_fee" id="newFieldFee" value="{{ isset($payment) ? $payment->field_fee : '0.00' }}">
                <input type="hidden" name="new_website_fee" id="newWebsiteFee" value="{{ isset($payment) ? $payment->website_fee : '0.00' }}">
                <input type="hidden" name="new_total_price" id="newTotalPrice" value="{{ isset($payment) ? ($payment->field_fee + $payment->website_fee) : '0.00' }}">
            </div>
        </div>
    </div>
</div>
            
            <!-- Form Actions -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between">
                        <!-- Cancel Button -->
                        <a href="" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to My Bookings
                        </a>
                        
                        <div>
                            <!-- Additional Actions -->
                            @if($booking->status != 'cancelled')
                            <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                                <i class="fas fa-ban me-2"></i>Cancel Booking
                            </button>
                            @endif
                            
                            <!-- Save Changes -->
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
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
                            <li><strong>Field:</strong> {{ $booking->sportfield->namee }}</li>
                            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->date)->format('D, M d, Y') }}</li>
                            <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</li>
                        </ul>
                        
                        <p class="mb-0"><strong>Cancellation Policy:</strong></p>
                        <ul>
                            <li>Cancellations made more than 24 hours in advance will receive a full refund.</li>
                            <li>Cancellations made less than 24 hours in advance may be subject to partial or no refund.</li>
                        </ul>
                        
                        <form id="cancelBookingForm" method="POST" action="{{ route('bookings.cancel', $booking->id) }}">
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
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('cancelBookingForm').submit();">
                            <i class="fas fa-ban me-2"></i>Confirm Cancellation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <style>
/* ===== EDIT BOOKING PAGE SPECIFIC STYLES - edit-booking.css ===== */

/* ===== FIELD OVERVIEW FOR EDIT PAGE ===== */
.field-image-container {
    height: 200px; /* Edit page has shorter field images */
}

/* ===== BOOKING REFERENCE BAR ===== */
.booking-reference {
    background: #f0f9ff;
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    border-left: 4px solid var(--info-color);
    font-weight: 600;
    margin-bottom: 1.5rem;
}

/* ===== BOOKING DETAILS GRID ===== */
.booking-details {
    background: #f8fafc;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
}

.booking-details-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.booking-details-item:last-child {
    border-bottom: none;
}

.booking-details-label {
    color: var(--text-secondary);
    font-weight: 500;
}

.booking-details-value {
    font-weight: 600;
    text-align: right;
}

/* ===== CURRENT SLOT STYLING ===== */
.slot-item.current {
    border: 2px dashed var(--warning-color);
    background: #fffbeb;
}

.slot-item.current .slot-status {
    color: var(--warning-color);
}

/* ===== CHANGES SUMMARY SECTION ===== */
#changesSummary {
    display: none; /* Initially hidden until changes are made */
}

.comparison-table {
    width: 100%;
    border-radius: var(--border-radius);
    overflow: hidden;
    border-collapse: collapse;
    margin-bottom: 1.5rem;
}

.comparison-table th,
.comparison-table td {
    padding: 1rem;
    text-align: left;
}

.comparison-table th {
    background-color: #f8fafc;
    font-weight: 600;
    color: var(--secondary-color);
}

.comparison-table td {
    border-top: 1px solid #e2e8f0;
}

.comparison-table .old-value {
    text-decoration: line-through;
    color: var(--text-secondary);
}

.comparison-table .new-value {
    color: var(--primary-color);
    font-weight: 600;
}

/* ===== PRICE DIFFERENCE ALERTS ===== */
#priceDifferenceAlert {
    display: none; /* Initially hidden */
}

#priceDifferenceAlert.alert-warning {
    background-color: #fff7ed;
    border-left: 4px solid var(--warning-color);
}

#priceDifferenceAlert.alert-info {
    background-color: #f0f9ff;
    border-left: 4px solid var(--info-color);
}

/* ===== FORM TOGGLE SWITCHES ===== */
.form-switch {
    padding-left: 2.5em;
}

.form-switch .form-check-input {
    width: 2em;
    margin-left: -2.5em;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
    background-position: left center;
    border-radius: 2em;
    transition: background-position 0.15s ease-in-out;
}

.form-switch .form-check-input:checked {
    background-position: right center;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
}

/* ===== FORM ACTIONS LAYOUT ===== */
.d-flex.justify-content-between {
    align-items: center;
}

.d-flex.justify-content-between .btn {
    margin-left: 0.5rem;
}

.d-flex.justify-content-between .btn:first-child {
    margin-left: 0;
}

/* ===== MODAL OVERRIDES ===== */
.modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.modal-title i {
    color: var(--danger-color);
}

/* ===== EDIT-SPECIFIC ALERTS ===== */
.alert.alert-info {
    background-color: #f0f9ff;
    color: var(--info-color);
    border-left: 4px solid var(--info-color);
}

.alert.alert-warning {
    background-color: #fff7ed;
    color: #b45309;
    border-left: 4px solid var(--warning-color);
}

/* ===== RESPONSIVE OVERRIDES FOR EDIT BOOKING ===== */
@media (max-width: 768px) {
    .comparison-table {
        font-size: 0.875rem;
    }
    
    .comparison-table th,
    .comparison-table td {
        padding: 0.5rem;
    }
    
    .booking-details-item {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .booking-details-value {
        text-align: left;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .field-image-container {
        height: 180px;
    }
}
/* Loading Overlay Styles */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    margin-bottom: 20px;
}

.loading-message {
    color: white;
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    max-width: 80%;
    padding: 10px 15px;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 5px;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Error and Success Alerts */
.alert-success, .alert-danger {
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form Validation Feedback */
.is-invalid {
    border-color: var(--danger-color) !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 80%;
    color: var(--danger-color);
}

.was-validated .form-control:invalid ~ .invalid-feedback,
.form-control.is-invalid ~ .invalid-feedback {
    display: block;
}
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>// Booking data from backend
const booking = @json($booking);
const field = @json($booking->sportfield);
const hourlyRate = parseFloat("{{ $booking->sportfield->fees }}");
const defaultFromTime = "{{ $booking->sportfield->defaultSchedule->from_time }}";
const defaultToTime = "{{ $booking->sportfield->defaultSchedule->to_time }}";

// Original booking payment details for price comparisons
const originalFieldFee = {{ isset($payment) ? $payment->field_fee : 0 }};
const originalWebsiteFee = {{ isset($payment) ? $payment->website_fee : 0 }};
const originalTotalPrice = originalFieldFee + originalWebsiteFee;
const originalDate = "{{ $booking->date->format('Y-m-d') }}";
const originalDuration = "{{ $booking->duration}}";

let selectedDate = "{{ $booking->date->format('Y-m-d') }}";
let selectedSlot = {
    from: "{{ $booking->start_time }}",
    to: "{{ $booking->end_time }}",
    display: "{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}"
};
let selectedDuration = {{ $booking->duration }};
let isLoadingSlots = false;
let hasChanges = false;

// Initialize flatpickr calendar
const calendar = flatpickr('#booking-calendar', {
    inline: true,
    minDate: "today",
    defaultDate: selectedDate,
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
        // Update selected date
        selectedDate = dateStr;
        document.getElementById('selectedDate').value = dateStr;
        
        // Mark that changes have been made
       
        hasChanges = true;
        
        // Show the date change in summary
        updateDateSummary(dateStr);
        
        // Show summary section
        document.getElementById('changesSummary').style.display = 'block';
       
        // Load slots for the new date
        loadSlots(dateStr, selectedDuration);
    }
});

// Load slots for initial date
document.addEventListener('DOMContentLoaded', function() {
    loadSlots(selectedDate, selectedDuration);
    
    // Initialize the changes summary - hide it initially
    document.getElementById('changesSummary').style.display = 'none';
    document.getElementById('dateSummaryRow').style.display = 'none';
    document.getElementById('timeSummaryRow').style.display = 'none';
    document.getElementById('durationSummaryRow').style.display = 'none';
    document.getElementById('priceSummaryRow').style.display = 'none';
    
    // Remove price difference alert entirely
    const priceDifferenceAlert = document.getElementById('priceDifferenceAlert');
    if (priceDifferenceAlert) {
        priceDifferenceAlert.style.display = 'none';
        priceDifferenceAlert.remove(); // Remove from DOM entirely
    }
});

// Update Date Summary
function updateDateSummary(dateStr) {
    if(dateStr!=originalDate){
      
    const dateSummaryRow = document.getElementById('dateSummaryRow');
    dateSummaryRow.style.display = 'table-row';
    
    const newDateSummary = document.getElementById('newDateSummary');
    const newDate = new Date(dateStr);
    newDateSummary.textContent = newDate.toLocaleDateString('en-US', { 
        weekday: 'short', 
        month: 'short', 
        day: 'numeric',
        year: 'numeric'
    });
}else{
    const dateSummaryRow = document.getElementById('dateSummaryRow');
    dateSummaryRow.style.display = 'none';
}
    
    
    
    
}

// Update Time Summary
function updateTimeSummary(slot) {
    originalstartTime = booking.start_time;
    originalendTime = booking.end_time;
    if(slot.from!=originalstartTime || slot.to!=originalendTime){
    const timeSummaryRow = document.getElementById('timeSummaryRow');
    timeSummaryRow.style.display = 'table-row';
    
    const newTimeSummary = document.getElementById('newTimeSummary');
    newTimeSummary.textContent = slot.display;
    
    
    }else{
        const timeSummaryRow = document.getElementById('timeSummaryRow');
        timeSummaryRow.style.display = 'none';
    }
}

// Update Duration Summary - FIXED
function updateDurationSummary(duration) {
    if(duration!=originalDuration){
    const durationSummaryRow = document.getElementById('durationSummaryRow');
    durationSummaryRow.style.display = 'table-row';
    
    const newDurationSummary = document.getElementById('newDurationSummary');
    newDurationSummary.textContent = `${duration} ${duration > 1 ? 'Hours' : 'Hour'}`;
    updatePriceSummarySimple();
    // Update price summary after changing duration but without warnings
    
    }else{
        const durationSummaryRow = document.getElementById('durationSummaryRow');
        durationSummaryRow.style.display = 'none';
        updatePriceSummarySimple();
    }
}

// Simplified price summary function - without warnings
function updatePriceSummarySimple() {
    // Calculate new prices
    const fieldFee = hourlyRate * selectedDuration;
    const websiteFee = fieldFee * 0.05; // 5% website fee
    const totalPrice = fieldFee + websiteFee;
    
    // Update hidden fields with the new prices
    document.getElementById('newFieldFee').value = fieldFee.toFixed(2);
    document.getElementById('newWebsiteFee').value = websiteFee.toFixed(2);
    document.getElementById('newTotalPrice').value = totalPrice.toFixed(2);
    
    // Display price summary
    if(totalPrice > originalTotalPrice) {
    const priceSummaryRow = document.getElementById('priceSummaryRow');
    priceSummaryRow.style.display = 'table-row';
    
    // Update the new price display
    const newPriceSummary = document.getElementById('newPriceSummary');
    newPriceSummary.textContent = `$${totalPrice.toFixed(2)}`;
    } else {
        const priceSummaryRow = document.getElementById('priceSummaryRow');
    priceSummaryRow.style.display = 'none';
        
    }
    
}

// Duration selector handling - FIXED VERSION
// Always processes the click without conditional checks
const durationItems = document.querySelectorAll('.duration-item');
durationItems.forEach(item => {
    item.addEventListener('click', function() {
        // Get the duration from the clicked element
        const newDuration = parseInt(this.getAttribute('data-duration'));
        
        // Always update the UI regardless of previous selection
        // Remove active class from all items
        durationItems.forEach(el => el.classList.remove('active'));
        
        // Add active class to clicked item
        this.classList.add('active');
        
        // Update selected duration
        selectedDuration = newDuration;
        document.getElementById('selectedDuration').value = newDuration;
        
        // Mark that changes have been made
        hasChanges = true;
        
        // Show the duration change in summary
        updateDurationSummary(newDuration);
        
        // Show summary section
        document.getElementById('changesSummary').style.display = 'block';
        
        // Always reload slots with the selected duration
        loadSlots(selectedDate, newDuration);
    });
});

// Format time for display (convert 24h to 12h format)
function formatTime(time24h) {
    const [hours, minutes] = time24h.split(':');
    const hour = parseInt(hours, 10);
    const period = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12 || 12;
    return `${hour12}:${minutes} ${period}`;
}

// Generate time slots based on operating hours
function generateTimeSlots(fromTime, toTime, duration) {
    const slots = [];
    
    // Parse times
    const [fromHour, fromMinute] = fromTime.split(':').map(Number);
    const [toHour, toMinute] = toTime.split(':').map(Number);
    
    // Convert to minutes from midnight
    const startMinutes = fromHour * 60 + fromMinute;
    const endMinutes = toHour * 60 + toMinute;
    
    // Generate slots in hourly increments
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
            status: 'available' // Default status, will be updated based on bookings
        });
    }
    
    return slots;
}

// Fetch booked slots from the server
async function fetchBookedSlots(date, fieldId, excludeBookingId) {
    try {
        const response = await fetch(`/api/fields/${fieldId}/booked-slots?date=${date}&exclude_booking=${excludeBookingId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch booked slots');
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error fetching booked slots:', error);
        // Fallback to simulated bookings if API call fails
        return { slots: {} };
    }
}

// Check if a specific slot is booked
function isSlotBooked(bookedSlots, slot) {
    // First, check for direct match
    if (bookedSlots && bookedSlots.slots) {
        if (bookedSlots.slots[slot.from]) {
            return true;
        }
        
        // Then check for overlapping bookings
        for (const bookedStart in bookedSlots.slots) {
            const bookedEnd = bookedSlots.slots[bookedStart];
            
            // Convert all times to minutes for easier comparison
            const slotStart = timeToMinutes(slot.from);
            const slotEnd = timeToMinutes(slot.to);
            const bookingStart = timeToMinutes(bookedStart);
            const bookingEnd = timeToMinutes(bookedEnd);
            
            // Check if slot overlaps with a booking
            if ((slotStart < bookingEnd && slotEnd > bookingStart)) {
                return true;
            }
        }
    }
    
    return false;
}

// Helper function to convert time string to minutes since midnight
function timeToMinutes(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
}

// Load available slots
async function loadSlots(date, duration) {
    console.log('Loading slots...');
    console.log(`Selected date: ${date}`);

    console.log(`Loading slots for date: ${date}, duration: ${duration}`);
    const slotsContainer = document.getElementById('slots-container');
    
    // Show loading state
    if (isLoadingSlots) {
        console.log('Already loading slots, returning');
        return; // Prevent multiple simultaneous loading
    }
    
    isLoadingSlots = true;
    slotsContainer.innerHTML = `
        <div class="slots-loader">
            <div class="slots-loader-spinner"></div>
        </div>
    `;
    
    try {
        // Fetch already booked slots from server, excluding current booking
        const bookedSlots = await fetchBookedSlots(date, field.id, booking.id);
        console.log('Booked slots:', bookedSlots);
        
        // Generate all possible slots
        const slots = generateTimeSlots(defaultFromTime, defaultToTime, duration);
        console.log('Generated slots:', slots);
        
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
        
        // Check if we have the current booking slot in the list
        const currentSlotTime = booking.start_time;
        const currentSlotFrom = currentSlotTime.substring(0, 5); // HH:MM format
        let hasCurrentSlot = false;
        
        // Finding current slot in new slots list
        if (date === booking.date && duration === parseInt(booking.duration)) {
            hasCurrentSlot = slots.some(slot => slot.from === currentSlotFrom);
            console.log(`Checking for current slot (${currentSlotFrom}) - exists: ${hasCurrentSlot}`);
        }
        
        // Add slots to container
        slots.forEach(slot => {
            // Check if this is the current booking's slot
            const isCurrent = date === booking.date && 
                              slot.from === currentSlotFrom && 
                              duration === parseInt(booking.duration);
            
            // For all other slots, check if they are booked
            slot.status = isCurrent ? 'current' : (isSlotBooked(bookedSlots, slot) ? 'booked' : 'available');
            
            // Create slot element
            const slotElement = document.createElement('div');
            slotElement.className = `slot-item ${slot.status}`;
            
            // Add slot content
            if (isCurrent) {
                slotElement.innerHTML = `
                    <span class="slot-time">${slot.display}</span>
                    <span class="slot-status">Current Booking</span>
                `;
                slotElement.classList.add('selected');
                selectedSlot = slot;
                
                // Update form hidden fields for the current slot
                document.getElementById('selectedSlotStart').value = slot.from;
                document.getElementById('selectedSlotEnd').value = slot.to;
            } else {
                slotElement.innerHTML = `
                    <span class="slot-time">${slot.display}</span>
                    <span class="slot-status">${slot.status === 'available' ? 'Available' : 'Booked'}</span>
                `;
            }
            
            // Add click event for available slots
            if (slot.status === 'available' || slot.status === 'current') {
                slotElement.addEventListener('click', () => {
                    // Deselect previous slot if any
                    document.querySelectorAll('.slot-item.selected').forEach(el => {
                        el.classList.remove('selected');
                    });
                    
                    // Select this slot
                    slotElement.classList.add('selected');
                    
                    // Update selected slot
                    selectedSlot = slot;
                    
                    // Update form hidden fields
                    document.getElementById('selectedSlotStart').value = slot.from;
                    document.getElementById('selectedSlotEnd').value = slot.to;
                    
                    // Mark that changes have been made
                    hasChanges = true;
                    
                    // Show the time change in summary
                    updateTimeSummary(slot);
                    
                    // Show summary section
                    document.getElementById('changesSummary').style.display = 'block';
                });
            }
            
            slotsGrid.appendChild(slotElement);
        });
        
        // If we don't have current slot in the list but it's the same date
        if (!hasCurrentSlot && date === booking.date && slots.length > 0) {
            // Show a message or alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                Your current time slot is not available with the selected duration. Please select a new time slot.
            `;
            slotsContainer.appendChild(alertDiv);
            
            // Auto-select the first available slot if the current one isn't available
            const firstAvailableSlot = slots.find(slot => slot.status === 'available');
            if (firstAvailableSlot) {
                const firstAvailableElement = slotsGrid.querySelector('.slot-item.available');
                if (firstAvailableElement) {
                    firstAvailableElement.click(); // Trigger click event to select this slot
                }
            }
        }
        
        // If no slots available
        if (slots.length === 0) {
            slotsContainer.innerHTML = `
                <div class="no-slots-message text-center p-4">
                    <i class="fas fa-exclamation-circle mb-3" style="font-size: 2rem; color: var(--text-secondary);"></i>
                    <h5>No Slots Available</h5>
                    <p class="mb-0">There are no slots available for the selected duration. Please try a shorter duration or another date.</p>
                </div>
            `;
        }
        
    } catch (error) {
        console.error('Error loading slots:', error);
        slotsContainer.innerHTML = `
            <div class="no-slots-message text-center p-4">
                <i class="fas fa-exclamation-triangle mb-3" style="font-size: 2rem; color: var(--danger-color);"></i>
                <h5>Error Loading Slots</h5>
                <p class="mb-0">There was a problem loading the available slots. Please try again later.</p>
            </div>
        `;
    } finally {
        isLoadingSlots = false;
    }
}

// Helper function to show errors
function showError(message) {
    // Remove any existing error messages
    const existingErrors = document.querySelectorAll('.alert-danger');
    existingErrors.forEach(el => el.remove());
    
    // Create error element
    const errorElement = document.createElement('div');
    errorElement.className = 'alert alert-danger';
    errorElement.innerHTML = `
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Error:</strong> ${message}
    `;
    
    // Insert error message at the top of the form
    const form = document.getElementById('editBookingForm');
    form.insertBefore(errorElement, form.firstChild);
    
    // Scroll to error message
    errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Form submission
document.getElementById('editBookingForm').addEventListener('submit', function(e) {
    // Prevent default form submission if no changes were made
    if (!hasChanges) {
        e.preventDefault();
        
        // Show alert to user
        showError('No changes have been made to the booking.');
        
        // Scroll to top of form
        this.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return;
    }
    
    // Validate that a slot is selected
    if (!selectedSlot) {
        e.preventDefault();
        showError('Please select a time slot for your booking.');
        return;
    }
});
</script>
</x-layout>