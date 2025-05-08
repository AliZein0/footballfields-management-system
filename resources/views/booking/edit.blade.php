<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Booking - {{ $booking->sportfield->name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <style>
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

        body {
            background: var(--light-bg);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
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

        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background-color: var(--card-bg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
        }

        .card-header i {
            margin-right: 0.75rem;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Duration selector styles */
        .duration-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .duration-item {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            background: #f1f5f9;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .duration-item:hover {
            background: #e2e8f0;
        }

        .duration-item.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .duration-value {
            font-weight: 700;
            font-size: 1.25rem;
            display: block;
        }

        .duration-label {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Field details styles */
        .field-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .field-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .field-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Status badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-badge.confirmed {
            background-color: #ecfdf5;
            color: var(--success-color);
        }

        .status-badge.pending {
            background-color: #fff7ed;
            color: var(--warning-color);
        }

        .status-badge.cancelled {
            background-color: #fee2e2;
            color: var(--danger-color);
        }

        .status-badge i {
            margin-right: 0.5rem;
        }

        /* Slots grid */
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 0.5rem;
        }

        .slot-item {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 0.75rem 0.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .slot-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .slot-item.available {
            border-color: #e2e8f0;
            color: var(--text-primary);
        }

        .slot-item.selected {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .slot-item.booked {
            background: #fee2e2;
            border-color: #fecaca;
            color: #ef4444;
            cursor: not-allowed;
            opacity: 0.8;
        }

        .slot-item.current {
            border: 2px dashed var(--warning-color);
            background: #fffbeb;
        }

        .slot-time {
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .slot-status {
            font-size: 0.75rem;
            display: block;
            font-weight: 500;
        }

        .slot-item.available .slot-status {
            color: var(--success-color);
        }

        .slot-item.booked .slot-status {
            color: var(--danger-color);
        }

        .slot-item.current .slot-status {
            color: var(--warning-color);
        }

        .slot-item.selected .slot-time,
        .slot-item.selected .slot-status {
            color: white;
        }

        /* Edit booking specific styles */
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

        .btn-outline-warning {
            color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-outline-warning:hover {
            background-color: var(--warning-color);
            color: white;
        }

        .btn-outline-danger {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .booking-reference {
            background: #f0f9ff;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            border-left: 4px solid var(--info-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .edit-section {
            background: #f8fafc;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .edit-section-header {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .edit-section-header i {
            color: var(--primary-color);
            margin-right: 0.75rem;
        }

        /* Flatpickr styles */
        .flatpickr-calendar {
            box-shadow: var(--shadow) !important;
            border-radius: var(--border-radius) !important;
            border: none !important;
            margin-top: 0.5rem;
        }

        .flatpickr-day {
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .flatpickr-day.selected, 
        .flatpickr-day.startRange, 
        .flatpickr-day.endRange, 
        .flatpickr-day.selected.inRange, 
        .flatpickr-day.startRange.inRange, 
        .flatpickr-day.endRange.inRange, 
        .flatpickr-day.selected:focus, 
        .flatpickr-day.startRange:focus, 
        .flatpickr-day.endRange:focus, 
        .flatpickr-day.selected:hover, 
        .flatpickr-day.startRange:hover, 
        .flatpickr-day.endRange:hover, 
        .flatpickr-day.selected.prevMonthDay, 
        .flatpickr-day.startRange.prevMonthDay, 
        .flatpickr-day.endRange.prevMonthDay, 
        .flatpickr-day.selected.nextMonthDay, 
        .flatpickr-day.startRange.nextMonthDay, 
        .flatpickr-day.endRange.nextMonthDay {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .flatpickr-day.today {
            border-color: var(--primary-color);
        }

        /* Alert styles */
        .alert {
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .alert-info {
            background-color: #f0f9ff;
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        .alert-warning {
            background-color: #fff7ed;
            color: #b45309;
            border-left: 4px solid var(--warning-color);
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid var(--danger-color);
        }

        /* Comparison table */
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

        /* Button styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            box-shadow: 0 10px 15px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.2);
            transition: all 0.3s ease;
        }

        .btn-success:hover, .btn-success:focus {
            background-color: #047857;
            border-color: #047857;
            box-shadow: 0 10px 15px rgba(5, 150, 105, 0.3);
            transform: translateY(-2px);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .slots-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }

            .duration-selector {
                flex-direction: column;
            }
        }

        /* Toggle switch */
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

        /* Slots loader */
        .slots-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 5;
            border-radius: var(--border-radius);
        }

        .slots-loader-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(37, 99, 235, 0.2);
            border-left-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="app-header">
            <h1 class="app-title">Edit Booking</h1>
            <p class="text-secondary">Modify your reservation for {{ $booking->sportfield->name}}</p>
        </div>

        <!-- Booking Reference -->
        <div class="booking-reference">
            <i class="fas fa-receipt me-2"></i>
            Booking Reference: <span>{{ $booking->reference }}</span>
        </div>

        <!-- Booking Field Overview -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="field-image-container">
                        @if($booking->sportfield->is_covered)
                            <div class="field-badge">
                                <i class="fas fa-umbrella"></i> Covered
                            </div>
                        @endif

                        @if($booking->sportfield->images->isEmpty())
                            <img src="{{ asset('images/default.jpg') }}" class="field-image" alt="{{ $booking->sportfield->name }}">
                        @else
                            <img src="{{ asset($booking->sportfield->images[0]) }}" class="field-image" alt="{{ $booking->sportfield->name }}">
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ $booking->sportfield->name }}</h5>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-futbol text-primary me-2"></i>
                                    <span>{{ $booking->sportfield->type }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span>{{ $booking->sportfield->location }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column justify-content-center h-100">
                                    <div class="mb-2 text-muted">
                                        <i class="fas fa-tag me-2"></i>
                                        <span>${{ number_format($booking->sportfield->fees, 2) }}/hour</span>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 0; $i < $booking->sportfield->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($i = $booking->sportfield->rating; $i < 5; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex flex-column justify-content-center align-items-end h-100">
                                    <div class="status-badge {{ strtolower($booking->status) }}">
                                        @if($booking->status == 'confirmed')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($booking->status == 'pending')
                                            <i class="fas fa-clock"></i>
                                        @elseif($booking->status == 'cancelled')
                                            <i class="fas fa-ban"></i>
                                        @endif
                                        {{ ucfirst($booking->status) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
   // Booking data from backend
const booking = @json($booking);
const field = @json($booking->sportfield);
const hourlyRate = parseFloat("{{ $booking->sportfield->fees }}");
const defaultFromTime = "{{ $booking->sportfield->defaultSchedule->from_time }}";
const defaultToTime = "{{ $booking->sportfield->defaultSchedule->to_time }}";

// Original booking payment details for price comparisons
const originalFieldFee = {{ isset($payment) ? $payment->field_fee : 0 }};
const originalWebsiteFee = {{ isset($payment) ? $payment->website_fee : 0 }};
const originalTotalPrice = originalFieldFee + originalWebsiteFee;

let selectedDate = "{{ $booking->date }}";
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
        if (dateStr !== selectedDate) {
            selectedDate = dateStr;
            document.getElementById('selectedDate').value = dateStr;
            
            // Mark that changes have been made
            hasChanges = true;
            
            // Show the date change in summary
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
            
            // Show summary section
            document.getElementById('changesSummary').style.display = 'block';
            
            // Load slots for the new date
            loadSlots(dateStr, selectedDuration);
            
            // Update price in summary
            updatePriceSummary();
        }
    }
});

// Load slots for initial date
document.addEventListener('DOMContentLoaded', function() {
    loadSlots(selectedDate, selectedDuration);
});

// Duration selector handling
const durationItems = document.querySelectorAll('.duration-item');
durationItems.forEach(item => {
    item.addEventListener('click', function() {
        const newDuration = parseInt(this.getAttribute('data-duration'));
        
        if (newDuration !== selectedDuration) {
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
            const durationSummaryRow = document.getElementById('durationSummaryRow');
            durationSummaryRow.style.display = 'table-row';
            
            const newDurationSummary = document.getElementById('newDurationSummary');
            newDurationSummary.textContent = `${newDuration} ${newDuration > 1 ? 'Hours' : 'Hour'}`;
            
            // Show summary section
            document.getElementById('changesSummary').style.display = 'block';
            
            // This is critical - update price before loading slots
            updatePriceSummary();
            
            // Reload slots with new duration - making sure we're passing the correct parameters
            loadSlots(selectedDate, newDuration);
        }
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
                    
                    // If the slot is different from the currently selected one
                    if (selectedSlot.from !== slot.from || selectedSlot.to !== slot.to) {
                        // Update selected slot
                        selectedSlot = slot;
                        
                        // Update form hidden fields
                        document.getElementById('selectedSlotStart').value = slot.from;
                        document.getElementById('selectedSlotEnd').value = slot.to;
                        
                        // Mark that changes have been made
                        hasChanges = true;
                        
                        // Show the time change in summary
                        const timeSummaryRow = document.getElementById('timeSummaryRow');
                        timeSummaryRow.style.display = 'table-row';
                        
                        const newTimeSummary = document.getElementById('newTimeSummary');
                        newTimeSummary.textContent = slot.display;
                        
                        // Show summary section
                        document.getElementById('changesSummary').style.display = 'block';
                        
                        // Update price summary since time has changed
                        updatePriceSummary();
                        
                        // Scroll to summary
                        window.scrollTo(0, document.getElementById('changesSummary').offsetTop - 20);
                    }
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

// Update price summary based on changes
function updatePriceSummary() {
    const fieldFee = hourlyRate * selectedDuration;
    const websiteFee = fieldFee * 0.05; // 5% website fee
    const totalPrice = fieldFee + websiteFee;
    
    // Update hidden fields
    document.getElementById('newFieldFee').value = fieldFee.toFixed(2);
    document.getElementById('newWebsiteFee').value = websiteFee.toFixed(2);
    document.getElementById('newTotalPrice').value = totalPrice.toFixed(2);
    
    // Display price summary only if the price has changed
    const priceSummaryRow = document.getElementById('priceSummaryRow');
    if (Math.abs(totalPrice - originalTotalPrice) > 0.01) { // Using a small threshold to handle floating point comparison
        priceSummaryRow.style.display = 'table-row';
        
        const newPriceSummary = document.getElementById('newPriceSummary');
        newPriceSummary.textContent = `$${totalPrice.toFixed(2)}`;
        
        // Show price difference alert
        const priceDifferenceAlert = document.getElementById('priceDifferenceAlert');
        const priceDifferenceText = document.getElementById('priceDifferenceText');
        
        priceDifferenceAlert.style.display = 'block';
        
        const priceDifference = totalPrice - originalTotalPrice;
        if (priceDifference > 0) {
            priceDifferenceAlert.className = 'alert alert-warning';
            priceDifferenceText.innerHTML = `The new booking is <strong>$${Math.abs(priceDifference).toFixed(2)} more expensive</strong> than your original booking. You will need to pay the additional amount.`;
        } else {
            priceDifferenceAlert.className = 'alert alert-info';
            priceDifferenceText.innerHTML = `The new booking is <strong>$${Math.abs(priceDifference).toFixed(2)} less expensive</strong> than your original booking. You will receive a partial refund.`;
        }
    } else {
        priceSummaryRow.style.display = 'none';
        document.getElementById('priceDifferenceAlert').style.display = 'none';
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
</body> 
</html>