<!-- resources/views/components/admin/payments/table.blade.php -->
@props(['payments'])

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking</th>
                <th>Player</th>
                <th>Field</th>
                <th>Total Amount</th>
                <th>Transfer Details</th>
                <th>Paid At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td> 
                         <a href="{{ route('admin.bookings.show', $payment->booking->id) }}">
                        #{{ $payment->booking_id }}
                    </td>
                    <td>
                        @if($payment->booking && $payment->booking->player && $payment->booking->player->user)
                            {{ $payment->booking->player->user->name }}
                        @else
                            <span class="text-muted">Unknown</span>
                        @endif
                    </td>
                    <td>
                        @if($payment->booking && $payment->booking->sportField)
                            {{ $payment->booking->sportField->name }}
                        @else
                            <span class="text-muted">Unknown</span>
                        @endif
                    </td>
                    <td>
                         <p>${{ number_format($payment->field_fee + $payment->website_fee, 2) }}</p>
                    </td>
                    <td>
                        {{ $payment->transfer_code }}<br>
                       
                    </td>
                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <x-admin.payments.status-badge :status="$payment->status" />
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info me-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <x-admin.payments.verify-buttons :payment="$payment" />
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No payments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>