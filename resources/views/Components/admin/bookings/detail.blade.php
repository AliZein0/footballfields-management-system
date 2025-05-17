<!-- resources/views/components/admin/bookings/detail.blade.php -->
@props(['booking'])

<div class="row">
    <div class="col-md-6">
        <!-- Booking Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Booking ID:</div>
                    <div class="col-md-8">{{ $booking->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Date:</div>
                    <div class="col-md-8">{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Time:</div>
                    <div class="col-md-8">
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Status:</div>
                    <div class="col-md-8">
                        <x-admin.bookings.status-badge :status="$booking->status" />
                        
                        @if($booking->status == 'upcoming')
                            <div class="btn-group ms-2">
                                <x-admin.bookings.status-dropdown :id="$booking->id" />
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Created At:</div>
                    <div class="col-md-8">{{ $booking->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Player Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Player Information</h6>
            </div>
            <div class="card-body">
                @if($booking->player && $booking->player->user)
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8">
                            <a href="{{ route('admin.users.show', $booking->player->user->id) }}">
                                {{ $booking->player->user->name }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8">{{ $booking->player->user->email }}</div>
                    </div>
                    @if($booking->player->phone_number)
                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Phone:</div>
                            <div class="col-md-8">{{ $booking->player->phone_number }}</div>
                        </div>
                    @endif
                    @if($booking->player->location)
                        <div class="row mb-3">
                            <div class="col-md-4 font-weight-bold">Location:</div>
                            <div class="col-md-8">{{ $booking->player->location }}</div>
                        </div>
                    @endif
                @else
                    <p class="text-center text-muted">Player information not available</p>
                @endif
            </div>
        </div>

        <!-- Field Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Field Information</h6>
            </div>
            <div class="card-body">
                @if($booking->sportField)
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8">
                            <a href="{{ route('admin.fields.show', $booking->sportField->id) }}">
                                {{ $booking->sportField->name }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Type:</div>
                        <div class="col-md-8">{{ ucfirst($booking->sportField->type) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">City:</div>
                        <div class="col-md-8">{{ $booking->sportField->city }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Fees:</div>
                        <div class="col-md-8">${{ number_format($booking->sportField->fees, 2) }}</div>
                    </div>
                @else
                    <p class="text-center text-muted">Field information not available</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!-- Payment Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                @if($booking->payment && $booking->payment->status == 'pending')
                    <div>
                        <x-admin.payments.verify-button :payment="$booking->payment" />
                    </div>
                @endif
            </div>
            <div class="card-body">
                @if($booking->payment)
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Payment ID:</div>
                        <div class="col-md-9">
                            <a href="{{ route('admin.payments.show', $booking->payment->id) }}">
                                #{{ $booking->payment->id }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Status:</div>
                        <div class="col-md-9">
                            <x-admin.payments.status-badge :status="$booking->payment->status" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Field Fee:</div>
                        <div class="col-md-9">${{ number_format($booking->payment->field_fee, 2) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Website Fee:</div>
                        <div class="col-md-9">${{ number_format($booking->payment->website_fee, 2) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Total Amount:</div>
                        <div class="col-md-9">${{ number_format($booking->payment->field_fee + $booking->payment->website_fee, 2) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Transfer Type:</div>
                        <div class="col-md-9">{{ $booking->payment->transfer_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Transfer Code:</div>
                        <div class="col-md-9">{{ $booking->payment->transfer_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Paid At:</div>
                        <div class="col-md-9">{{ $booking->payment->paid_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Processed By:</div>
                        <div class="col-md-9">
                            @if($booking->payment->admin_id)
                                {{ $booking->payment->admin->name ?? 'Unknown Admin' }}
                            @else
                                <span class="text-muted">Not processed yet</span>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-center text-muted">No payment information available</p>
                @endif
            </div>
        </div>
    </div>
</div>