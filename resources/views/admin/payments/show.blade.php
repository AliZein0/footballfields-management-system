<!-- resources/views/admin/payments/show.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <x-admin.shared.breadcrumb :items="[
        'Payments' => route('admin.payments.index'), 
        'Payment #' . $payment->id => '#'
    ]" />
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Payment Details: #{{ $payment->id }}</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <x-admin.shared.card title="Payment Information">
                <div class="mb-3">
                    <h6>Payment ID</h6>
                    <p>#{{ $payment->id }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Status</h6>
                    <p>
                        <x-admin.payments.status-badge :status="$payment->status" />
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Total Amount</h6>
                    <p>${{ number_format($payment->field_fee + $payment->website_fee, 2) }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Field Fee</h6>
                    <p>${{ number_format($payment->field_fee, 2) }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Website Fee</h6>
                    <p>${{ number_format($payment->website_fee, 2) }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Transfer Code</h6>
                    <p>{{ $payment->transfer_code }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Transfer Type</h6>
                    <p>{{ $payment->transfer_type }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Paid At</h6>
                    <p>{{ $payment->paid_at->format('Y-m-d H:i:s') }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Processed By</h6>
                    <p>
                        @if($payment->admin_id)
                            {{ $payment->admin->name }}
                        @else
                            <span class="text-muted">Not processed yet</span>
                        @endif
                    </p>
                </div>
                
                @if($payment->status == 'pending')
                    <div class="d-flex justify-content-end mt-4">
                        <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="me-2">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Verify Payment
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i> Reject Payment
                            </button>
                        </form>
                    </div>
                @endif
            </x-admin.shared.card>
        </div>
        
        <div class="col-md-6">
            <x-admin.shared.card title="Booking Information">
                <div class="mb-3">
                    <h6>Booking ID</h6>
                    <p>
                        <a href="{{ route('admin.bookings.show', $payment->booking->id) }}">
                            #{{ $payment->booking_id }}
                        </a>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Player</h6>
                    <p>
                        <a href="{{ route('admin.users.show', $payment->booking->player->id) }}">
                            {{ $payment->booking->player->user->name }}
                        </a>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Sport Field</h6>
                    <p>
                        <a href="{{ route('admin.fields.show', $payment->booking->sportfield->id) }}">
                            {{ $payment->booking->sportfield->name }}
                        </a>
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Booking Date</h6>
                    <p>{{ \Carbon\Carbon::parse($payment->booking->start_time)->format('Y-m-d') }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>Time Slot</h6>
                    <p>
                        {{ \Carbon\Carbon::parse($payment->booking->start_time)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($payment->booking->end_time)->format('H:i') }}
                    </p>
                </div>
                
                <div class="mb-3">
                    <h6>Booking Status</h6>
                    <p>
                        <span class="badge bg-{{ $payment->booking->status == 'upcoming' ? 'primary' : 
                                              ($payment->booking->status == 'completed' ? 'success' : 'danger') }}">
                            {{ ucfirst($payment->booking->status) }}
                        </span>
                    </p>
                </div>
            </x-admin.shared.card>
        </div>
    </div>
</div>
@endsection