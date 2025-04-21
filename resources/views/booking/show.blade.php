<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $field['title'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            padding: 30px;
            max-width: 1200px;
        }
        h1 {
            color: #2c3e50;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        .carousel-inner img {
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            border: 2px solid #3498db;
        }
        .field-details, .calendar-section, .map-section, .review-card {
            padding: 20px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        .field-details:hover, .calendar-section:hover, .map-section:hover, .review-card:hover {
            transform: translateY(-5px);
        }
        .btn-success {
            background: #27ae60;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .btn-success:hover {
            background: #219653;
        }
        .slot-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        .slot {
            padding: 12px;
            text-align: center;
            background: #ebf7f1;
            color: #27ae60;
            border: 2px solid #27ae60;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .slot:hover {
            background: #27ae60;
            color: white;
            transform: translateY(-3px);
        }
        .slot.booked {
            background: #ffeeee;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .slot.booked:hover {
            background: #ffeeee;
            color: #e74c3c;
            transform: none;
        }
        .slot.selected {
            background: #27ae60;
            color: white;
            box-shadow: 0 0 15px rgba(39, 174, 96, 0.5);
        }
        .time-range {
            font-size: 15px;
            font-weight: 600;
        }
        .flatpickr-calendar {
            border-radius: 15px !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }
        .time-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .booking-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
            border-left: 4px solid #27ae60;
        }
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        .modal-header {
            background: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }
        .empty-slot-message {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
        }
        #booking-loader {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loader-spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #27ae60;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .booking-summary-section {
            background: #e9f7ef;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: 600;
        }
        .form-floating > label {
            font-weight: normal;
        }
        .booking-success {
            display: none;
            text-align: center;
            padding: 20px;
            background: #d4edda;
            border-radius: 10px;
            margin-top: 15px;
        }
        .code-info {
            background: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 10px;
            margin-top: 8px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4 fw-bold">{{ $field['title'] }}</h1>
        <div class="row">
            <!-- Left Side: Field Details and Carousel -->
            <div class="col-md-6">
                <div class="field-details">
                    <h3>Field Details</h3>
                    <ul class="list-unstyled">
                        <li><strong>Type:</strong> {{ $field['type'] }}</li>
                        <li><strong>Size:</strong> {{ $field['size'] }}</li>
                        <li><strong>Covered:</strong> {{ $field['is_covered'] ? 'Yes' : 'No' }}</li>
                        <li><strong>Location:</strong> {{ $field['location'] }}</li>
                        <li><strong>Opening Hours:</strong> {{ $field->defaultSchedule->from_time }} - {{ $field->defaultSchedule->to_time }}</li>
                        <li><strong>Fees:</strong> ${{ number_format($field['fees'], 2) }} per hour</li>
                    </ul>
                    @if(!empty($field['details']))
                        <div class="mt-3">
                            <h5>Description</h5>
                            <p>{{ $field['details'] }}</p>
                        </div>
                    @endif
                </div>
                <div id="fieldCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if($field->images->isEmpty())
                            <div class="carousel-item active">
                                <img src="{{ asset('images/default.jpg') }}" class="d-block w-100" alt="{{ $field['title'] }}">
                            </div>
                        @else
                            @foreach($field->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image) }}" class="d-block w-100" alt="{{ $field['title'] }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#fieldCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#fieldCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Right Side: Calendar, Duration, and Slots Button -->
            <div class="col-md-6">
                <div class="calendar-section">
                    <h3>Book This Field</h3>
                    <div class="time-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="far fa-clock"></i> Operating Hours:
                                <span class="time-range">{{ $field->defaultSchedule->from_time }} - {{ $field->defaultSchedule->to_time }}</span>
                            </div>
                            <div>
                                <i class="fas fa-chart-line"></i> Rating: 
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
                    <div class="mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="text" class="form-control" id="bookingDate">
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <select class="form-select" id="duration">
                            <option value="1">1 Hour</option>
                            <option value="2">2 Hours</option>
                            <option value="3">3 Hours</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100" id="showSlotsBtn">
                        <i class="far fa-clock me-2"></i> Show Available Slots
                    </button>
                    
                    <!-- Booking Form -->
                    <div id="booking-form-container" class="booking-form mt-3" style="display: none;">
                        <form id="bookingForm" method="POST" action="">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field['id'] }}">
                            <input type="hidden" name="booking_date" id="form-booking-date">
                            <input type="hidden" name="start_time" id="form-start-time">
                            <input type="hidden" name="end_time" id="form-end-time">
                            <input type="hidden" name="duration" id="form-duration">
                            <input type="hidden" name="total_price" id="form-total-price">
                            
                            <div class="booking-summary-section">
                                <h5><i class="fas fa-calendar-check text-success me-2"></i>Booking Summary</h5>
                                <div id="booking-details" class="mb-3"></div>
                                <div class="text-end">
                                    <span id="booking-price" class="fw-bold h5"></span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Player Identification</label>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="player_code" name="player_code" placeholder="OMT or Wish Code" required>
                                    <label for="player_code">OMT or Wish Code</label>
                                </div>
                                <div class="code-info">
                                    <i class="fas fa-info-circle me-1 text-primary"></i>
                                    Enter your OMT or Wish code to complete the booking. This code is linked to your player profile.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <div class="form-floating">
                                    <textarea class="form-control" id="details" name="details" placeholder="Additional Notes" style="height: 100px"></textarea>
                                    <label for="details">Special Requests or Notes</label>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a></label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100" id="submitBookingBtn">
                                <i class="fas fa-check-circle me-2"></i>Confirm Booking
                            </button>
                        </form>
                        
                        <!-- Success Message -->
                        <div id="booking-success" class="booking-success">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h4>Booking Confirmed!</h4>
                            <p>Your booking has been successfully confirmed. Your booking reference is: <strong id="booking-reference"></strong></p>
                            <button class="btn btn-outline-success mt-3" onclick="window.location.reload()">
                                Make Another Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section mt-4">
            <h3 class="text-center">Field Location</h3>
            <div id="fieldMap" style="height: 400px; border-radius: 15px; overflow: hidden;">
                <iframe src="{{ $field['mapEmbed'] }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <!-- Modal for Available Slots -->
    <div class="modal fade" id="slotsModal" tabindex="-1" aria-labelledby="slotsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slotsModalLabel">
                        <i class="far fa-calendar-alt me-2"></i> Available Slots
                        <span id="selectedDateDisplay" class="ms-2 text-primary"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="booking-loader">
                        <div class="loader-spinner"></div>
                        <p>Loading available slots...</p>
                    </div>
                    <div id="slotsContainer" class="slot-grid"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="selectSlotBtn" disabled>Select Slot</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Booking Terms</h6>
                    <p>By booking this field, you agree to the following terms:</p>
                    <ul>
                        <li>Payment must be made upon arrival.</li>
                        <li>Cancellations must be made at least 24 hours in advance for a full refund.</li>
                        <li>You are responsible for any damage caused to the facilities.</li>
                        <li>The field must be vacated promptly at the end of your booking time.</li>
                        <li>Management reserves the right to cancel bookings due to weather conditions or maintenance needs.</li>
                    </ul>
                    <h6>Rules of Conduct</h6>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
       // Field data from backend
const field = @json($field);
const defaultFromTime = "{{ $field->defaultSchedule->from_time }}";
const defaultToTime = "{{ $field->defaultSchedule->to_time }}";

let selectedDate = null;
let selectedSlot = null;
let selectedSlotElement = null;
const hourlyRate = parseFloat("{{ $field['fees'] }}");

// Create a modal instance
const slotsModal = new bootstrap.Modal(document.getElementById('slotsModal'));
const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));

// Initialize flatpickr calendar
const fp = flatpickr('#bookingDate', {
    inline: true,
    minDate: "today",
    defaultDate: "today",
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
        selectedDate = dateStr;
    }
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

// Check if slot is booked - Now we'll fetch this from the server
async function fetchBookedSlots(date, fieldId) {
    try {
        const response = await fetch(`/api/fields/${fieldId}/booked-slots?date=${date}`, {
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
    // Check if this time slot is in the booked slots list
    if (bookedSlots && bookedSlots.slots) {
        // Check for direct conflict (same start time)
        if (bookedSlots.slots[slot.from]) {
            return true;
        }
        
        // Also check for overlapping bookings
        for (const bookedStart in bookedSlots.slots) {
            const bookedEnd = bookedSlots.slots[bookedStart];
            
            // Convert all times to minutes for easier comparison
            const slotFrom = timeToMinutes(slot.from);
            const slotTo = timeToMinutes(slot.to);
            const bookingFrom = timeToMinutes(bookedStart);
            const bookingTo = timeToMinutes(bookedEnd);
            
            // Check if slot overlaps with a booking
            if ((slotFrom >= bookingFrom && slotFrom < bookingTo) || 
                (slotTo > bookingFrom && slotTo <= bookingTo) ||
                (slotFrom <= bookingFrom && slotTo >= bookingTo)) {
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

// Show available slots
document.getElementById('showSlotsBtn').addEventListener('click', async () => {
    if (!selectedDate) {
        selectedDate = fp.selectedDates[0].toISOString().split('T')[0];
    }
    
    const duration = parseInt(document.getElementById('duration').value);
    document.getElementById('selectedDateDisplay').textContent = new Date(selectedDate).toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    const slotsContainer = document.getElementById('slotsContainer');
    const bookingLoader = document.getElementById('booking-loader');
    
    // Reset selected slot
    selectedSlot = null;
    selectedSlotElement = null;
    document.getElementById('selectSlotBtn').disabled = true;
    
    // Show loader
    slotsContainer.innerHTML = '';
    bookingLoader.style.display = 'block';
    slotsModal.show();
    
    try {
        // Fetch already booked slots from server
        const bookedSlots = await fetchBookedSlots(selectedDate, field.id);
        
        // Generate all possible slots
        const slots = generateTimeSlots(defaultFromTime, defaultToTime, duration);
        
        bookingLoader.style.display = 'none';
        
        if (slots.length === 0) {
            slotsContainer.innerHTML = `
                <div class="empty-slot-message">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i>
                    <h5>No slots available</h5>
                    <p>There are no slots available for the selected duration. Please try a shorter duration or another date.</p>
                </div>
            `;
            return;
        }
        
        slots.forEach(slot => {
            // Check if slot is booked
            slot.status = isSlotBooked(bookedSlots, slot) ? 'booked' : 'available';
            
            const slotElement = document.createElement('div');
            slotElement.className = `slot ${slot.status}`;
            slotElement.innerHTML = `
                <div>${slot.display}</div>
                <small>${slot.status === 'available' ? 'Available' : 'Booked'}</small>
            `;
            
            if (slot.status === 'available') {
                slotElement.addEventListener('click', () => {
                    // Deselect previous slot if any
                    if (selectedSlotElement) {
                        selectedSlotElement.classList.remove('selected');
                    }
                    
                    // Select this slot
                    slotElement.classList.add('selected');
                    selectedSlot = slot;
                    selectedSlotElement = slotElement;
                    document.getElementById('selectSlotBtn').disabled = false;
                });
            }
            
            slotsContainer.appendChild(slotElement);
        });
    } catch (error) {
        console.error('Error loading slots:', error);
        bookingLoader.style.display = 'none';
        slotsContainer.innerHTML = `
            <div class="empty-slot-message">
                <i class="fas fa-exclamation-triangle fa-3x mb-3 text-danger"></i>
                <h5>Error Loading Slots</h5>
                <p>There was a problem loading the available slots. Please try again later.</p>
            </div>
        `;
    }
});

// Handle slot selection
document.getElementById('selectSlotBtn').addEventListener('click', () => {
    if (selectedSlot) {
        const duration = parseInt(document.getElementById('duration').value);
        const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', { 
            weekday: 'short', 
            month: 'short', 
            day: 'numeric' 
        });
        
        // Calculate total price
        const totalPrice = hourlyRate * duration;
        
        // Update booking form with selected slot data
        document.getElementById('form-booking-date').value = selectedDate;
        document.getElementById('form-start-time').value = selectedSlot.from;
        document.getElementById('form-end-time').value = selectedSlot.to;
        document.getElementById('form-duration').value = duration;
        document.getElementById('form-total-price').value = totalPrice.toFixed(2);
        
        // Update booking summary
        document.getElementById('booking-form-container').style.display = 'block';
        document.getElementById('booking-details').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <p><strong><i class="far fa-calendar me-1"></i> Date:</strong><br> ${formattedDate}</p>
                    <p><strong><i class="far fa-clock me-1"></i> Time:</strong><br> ${selectedSlot.display}</p>
                </div>
                <div class="col-md-6">
                    <p><strong><i class="fas fa-hourglass-half me-1"></i> Duration:</strong><br> ${duration} hour${duration > 1 ? 's' : ''}</p>
                    <p><strong><i class="fas fa-map-marker-alt me-1"></i> Field:</strong><br> ${field.title}</p>
                </div>
            </div>
        `;
        document.getElementById('booking-price').textContent = `Total: $${totalPrice.toFixed(2)}`;
        
        // Close the modal
        slotsModal.hide();
        
        // Scroll to the booking form
        document.getElementById('booking-form-container').scrollIntoView({ behavior: 'smooth' });
    }
});

// Handle form submission
document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBookingBtn');
    const originalBtnText = submitBtn.innerHTML;
    const form = this;
    
    // Show loading state
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
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
                errorData.errors?.join('\n') || 
                `Server responded with status ${response.status}`
            );
        }
        
        const data = await response.json();
        
        // Hide form and show success message
        form.style.display = 'none';
        document.getElementById('booking-reference').textContent = data.reference;
        document.getElementById('booking-success').style.display = 'block';
        
    } catch (error) {
        console.error('Booking error:', error);
        
        // Remove any existing error messages
        const existingErrors = document.querySelectorAll('.booking-error');
        existingErrors.forEach(el => el.remove());
        
        // Show error to user
        const errorElement = document.createElement('div');
        errorElement.className = 'alert alert-danger mt-3 booking-error';
        errorElement.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Booking Error:</strong> ${error.message}
        `;
        
        // Insert error message
        const formContainer = document.getElementById('booking-form-container');
        formContainer.insertBefore(errorElement, formContainer.firstChild);
        
        // Scroll to error message
        errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
    } finally {
        // Always reset button state
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    }
});
    </script>
</body>
</html>