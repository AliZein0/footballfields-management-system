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

        /* Field details styles */
        .field-image-container {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .field-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card:hover .field-image {
            transform: scale(1.05);
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

        .field-details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .field-details-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .field-details-list li:last-child {
            border-bottom: none;
        }

        .field-details-list i {
            width: 24px;
            color: var(--primary-color);
            margin-right: 0.75rem;
            text-align: center;
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

        /* Calendar and booking styles */
        .flatpickr-calendar {
            box-shadow: var(--shadow) !important;
            border-radius: var(--border-radius) !important;
            border: none !important;
            margin-top: 0.5rem;
            width: 100% !important;
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

        .slot-item.selected .slot-time,
        .slot-item.selected .slot-status {
            color: white;
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

        .no-slots-message {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            background: #f8fafc;
            border-radius: var(--border-radius);
            border: 1px dashed #e2e8f0;
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

        /* Payment styles */
        .payment-section {
            background: #f8fafc;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .payment-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .payment-header i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 0.75rem;
        }

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

        .payment-code-input {
            margin-bottom: 1rem;
        }

        .code-info {
            padding: 0.75rem;
            background: #f0f9ff;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            border-left: 3px solid var(--info-color);
            margin-top: 0.5rem;
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

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.125rem;
        }

        /* Booking success styles */
        .booking-success {
            background: #ecfdf5;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-top: 1.5rem;
            display: none;
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

        /* Form styles */
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--primary-color);
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        /* Map styles */
        .map-container {
            height: 400px;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Alert styles */
        .alert {
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .alert-danger i {
            color: #ef4444;
            margin-right: 0.5rem;
        }

        /* Animations */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .slots-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }

            .duration-selector {
                flex-direction: column;
            }

            .payment-methods {
                flex-direction: column;
            }
        }

        
    </style>
</head>
<body>
    <div class="app-container">
        <div class="app-header">
            <h1 class="app-title">{{ $field['title'] }}</h1>
            <p class="text-secondary">Book your perfect sports field in just a few clicks</p>
        </div>
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
        <!-- Top row: Field image and overview -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="field-image-container">
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="mb-3">Field Overview</h4>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
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
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            selectedDate = today;
            document.getElementById('selectedDate').value = today;
            
            // Load slots for today
            loadSlots(today, selectedDuration);
            
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
        });

        // Duration selector handling
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

        // Payment method handling
        const paymentMethods = document.querySelectorAll('.payment-method-item');
        paymentMethods.forEach(method => {
            method.addEventListener('click', function() {
                // Remove active class from all methods
                paymentMethods.forEach(el => el.classList.remove('active'));
                
                // Add active class to clicked method
                this.classList.add('active');
                
                // Update payment method
                const paymentType = this.getAttribute('data-method');
                document.getElementById('payment_method').value = paymentType;
                document.getElementById('code_type').textContent = paymentType.toUpperCase();
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

        // Load available slots
        async function loadSlots(date, duration) {
            const slotsContainer = document.getElementById('slots-container');
            
            // Show loading state
            if (isLoadingSlots) return; // Prevent multiple simultaneous loading
            
            isLoadingSlots = true;
            slotsContainer.innerHTML = `
                <div class="slots-loader">
                    <div class="slots-loader-spinner"></div>
                </div>
            `;
            
            try {
                // Fetch already booked slots from server
                const bookedSlots = await fetchBookedSlots(date, field.id);
                
                // Generate all possible slots
                const slots = generateTimeSlots(defaultFromTime, defaultToTime, duration);
                
                // Clear selected slot when reloading
                selectedSlot = null;
                
                // Hide the booking form when reloading slots
                document.getElementById('booking-form-section').style.display = 'none';
                
                if (slots.length === 0) {
                    slotsContainer.innerHTML = `
                        <div class="no-slots-message">
                            <i class="fas fa-exclamation-circle mb-3" style="font-size: 2rem; color: var(--text-secondary);"></i>
                            <h5>No Slots Available</h5>
                            <p class="mb-0">There are no slots available for the selected duration. Please try a shorter duration or another date.</p>
                        </div>
                    `;
                    isLoadingSlots = false;
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
                        slotElement.addEventListener('click', () => {
                            // Deselect previous slot if any
                            document.querySelectorAll('.slot-item.selected').forEach(el => {
                                el.classList.remove('selected');
                            });
                            
                            // Select this slot
                            slotElement.classList.add('selected');
                            selectedSlot = slot;
                            
                            // Calculate payment details
                            calculatePayment(duration, hourlyRate);
                            
                            // Update booking form with selected slot data
                            document.getElementById('form-booking-date').value = date;
                            document.getElementById('form-start-time').value = slot.from;
                            document.getElementById('form-end-time').value = slot.to;
                            document.getElementById('form-duration').value = duration;
                            
                            // Update summary display
                            document.getElementById('summary-date').textContent = formattedDate;
                            document.getElementById('summary-time').textContent = slot.display;
                            document.getElementById('summary-duration').textContent = `${duration} Hour${duration > 1 ? 's' : ''}`;
                            
                            // Show the booking form section
                            document.getElementById('booking-form-section').style.display = 'block';
                            
                            // Scroll to the booking form
                            document.getElementById('booking-form-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
                        });
                    }
                    
                    slotsGrid.appendChild(slotElement);
                });
                
            } catch (error) {
                console.error('Error loading slots:', error);
                slotsContainer.innerHTML = `
                    <div class="no-slots-message">
                        <i class="fas fa-exclamation-triangle mb-3" style="font-size: 2rem; color: var(--danger-color);"></i>
                        <h5>Error Loading Slots</h5>
                        <p class="mb-0">There was a problem loading the available slots. Please try again later.</p>
                    </div>
                `;
            } finally {
                isLoadingSlots = false;
            }
        }

        // Payment calculation
       // Payment calculation
function calculatePayment(duration, hourlyRate) {
    const fieldFee = hourlyRate * duration;
    const websiteFee = fieldFee * 0.05; // 5% website fee
    const total = fieldFee + websiteFee;
    
    // Update the payment display - only update the summary display fields
    document.getElementById('field-fee').textContent = `$${fieldFee.toFixed(2)}`;
    document.getElementById('website-fee').textContent = `$${websiteFee.toFixed(2)}`;
    document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
    
    // Update hidden form fields
    document.getElementById('form-website-fee').value = websiteFee.toFixed(2);
    document.getElementById('form-field-fee').value = fieldFee.toFixed(2);
    document.getElementById('form-total-price').value = total.toFixed(2);
    
    return {
        fieldFee,
        websiteFee,
        total
    };
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
                <i class="fas fa-exclamation-circle"></i>
                <strong>Error:</strong> ${message}
            `;
            
            // Insert error message at the top of the form
            const form = document.getElementById('bookingForm');
            form.insertBefore(errorElement, form.firstChild);
            
            // Scroll to error message
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Handle form submission
   // Update the form submit event handler in the booking.show view
document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBookingBtn');
    const originalBtnText = submitBtn.innerHTML;
    const form = this;
    
    // Validate payment selections
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
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
    submitBtn.disabled = true;
    
    try {
        const formData = new FormData(form);
        const timeout = 10000; // 10 seconds timeout
        
        // Add current timestamp as paid_at
        const now = new Date().toISOString();
        formData.append('paid_at', now);
        
        // Set initial payment status
        formData.set('status', 'pending');
        
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
        
        // Store the field fee and website fee values
        const fieldFee = document.getElementById('field-fee').textContent;
        const websiteFee = document.getElementById('website-fee').textContent;
        
        // Update success message details
        document.getElementById('booking-reference').textContent = data.reference || 'FLD-' + Math.floor(Math.random() * 10000000);
        document.getElementById('payment-method-display').textContent = transferType.toUpperCase();
        document.getElementById('transaction-id').textContent = transferCode;
        document.getElementById('field-fee-display').textContent = fieldFee;
        document.getElementById('website-fee-display').textContent = websiteFee;
        document.getElementById('payment-amount-display').textContent = document.getElementById('total-amount').textContent;
        
        // Show success message
        document.getElementById('booking-success').style.display = 'block';
        
        // Scroll to success message
        document.getElementById('booking-success').scrollIntoView({ behavior: 'smooth', block: 'start' });
        
    } catch (error) {
        console.error('Booking error:', error);
        showError(error.message || 'An error occurred while processing your booking. Please try again.');
    } finally {
        // Always reset button state
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    }
});
    </script>
</body>
</html>