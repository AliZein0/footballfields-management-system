<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .modal-body .slot {
            padding: 12px;
            margin: 8px 0;
            background: #27ae60;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .modal-body .slot:hover {
            background: #219653;
        }
        .modal-body .slot.booked {
            background: #e74c3c;
            cursor: not-allowed;
        }
        .reviews-section {
            margin-top: 40px;
        }
        .review-card h5 {
            color: #2c3e50;
        }
        .review-card .text-warning i {
            color: #f1c40f;
        }
        .flatpickr-calendar {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .map-section h3 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
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
                        <li><strong>Covered:</strong> {{ $field['is_covered'] ? 'Yes' : 'No' }}</li>
                        <li><strong>Opening Hours:</strong> {{ $field->defaultSchedule->from_time }}</li>
                    </ul>
                </div>
                <div id="fieldCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                    
                        @if($field->images->isEmpty())
                            <div class="carousel-item active">
                                <img src="{{ asset('images/default.jpg') }}" class="d-block w-100" alt="{{ $field['title'] }}">
                            </div>
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
                    <div class="mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="text" class="form-control" id="bookingDate">
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration (hours)</label>
                        <select class="form-select" id="duration">
                            <option value="1">1 Hour</option>
                            <option value="2">2 Hours</option>
                            <option value="3">3 Hours</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#slotsModal">Show Available Slots</button>
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

        <!-- Reviews Section -->
        {{-- <div class="reviews-section">
            <h3>Reviews</h3>
            <div id="reviewsContainer">
                @foreach($field['reviews'] as $review)
                    <div class="review-card">
                        <h5>{{ $review['user'] }} <span class="text-warning"><i class="fas fa-star"></i> {{ $review['rating'] }}</span></h5>
                        <p>{{ $review['comment'] }}</p>
                    </div>
                @endforeach
            </div>
        </div> --}}
    </div>

    <!-- Modal for Available Slots -->
    <div class="modal fade" id="slotsModal" tabindex="-1" aria-labelledby="slotsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slotsModalLabel">Available Slots</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="slotsContainer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const field = @json($field);
        let selectedDate = '2025-03-21';

        // Initialize flatpickr calendar
        flatpickr('#bookingDate', {
            inline: true,
            minDate: '2025-03-21',
            defaultDate: '2025-03-21',
            onChange: function(selectedDates, dateStr) {
                selectedDate = dateStr;
            }
        });

        // Handle slots modal
        document.getElementById('slotsModal').addEventListener('show.bs.modal', () => {
            const duration = parseInt(document.getElementById('duration').value);
            const slotsContainer = document.getElementById('slotsContainer');
            slotsContainer.innerHTML = '';

            if (field.slots[selectedDate]) {
                for (const [time, status] of Object.entries(field.slots[selectedDate])) {
                    const slotDiv = document.createElement('div');
                    slotDiv.className = `slot ${status}`;
                    slotDiv.textContent = `${time} (${status === 'available' ? 'Available' : 'Booked'})`;
                    if (status === 'available') {
                        slotDiv.addEventListener('click', () => alert(`Booked ${time} for ${duration} hour(s)`));
                    }
                    slotsContainer.appendChild(slotDiv);
                }
            } else {
                slotsContainer.textContent = 'No slots available for this date.';
            }
        });
    </script>
</body>
</html>