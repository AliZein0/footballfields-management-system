<!-- resources/views/components/admin/payments/verify-buttons.blade.php -->
@props(['payment'])

<div class="btn-group" id="payment-actions-{{ $payment->id }}">
    @if($payment->status === 'pending')
        <div class="d-flex initial-buttons">
            <button type="button" 
                    class="btn btn-sm btn-success verify-btn" 
                    onclick="showConfirmButtons({{ $payment->id }}, 'verify')"
                    title="Verify Payment">
                <i class="fas fa-check"></i> Verify
            </button>
            
            <button type="button" 
                    class="btn btn-sm btn-danger ms-1 reject-btn" 
                    onclick="showConfirmButtons({{ $payment->id }}, 'reject')"
                    title="Reject Payment">
                <i class="fas fa-times"></i> Reject
            </button>
        </div>
        
        <div class="d-none verify-confirm-buttons">
            <span class="me-2 align-self-center">Verify?</span>
            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="d-inline">
                @csrf
                
                <button type="submit" class="btn btn-sm btn-success">
                    Yes
                </button>
            </form>
            
            <button type="button" 
                    class="btn btn-sm btn-secondary ms-1" 
                    onclick="hideConfirmButtons({{ $payment->id }})"
                    title="Cancel">
                No
            </button>
        </div>
        
        <div class="d-none reject-confirm-buttons">
            <span class="me-2 align-self-center">Reject?</span>
            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="d-inline">
                @csrf
               
                <button type="submit" class="btn btn-sm btn-danger">
                    Yes
                </button>
            </form>
            
            <button type="button" 
                    class="btn btn-sm btn-secondary ms-1" 
                    onclick="hideConfirmButtons({{ $payment->id }})"
                    title="Cancel">
                No
            </button>
        </div>
    @elseif($payment->status === 'completed')
        <span class="btn btn-sm btn-outline-success disabled">
            <i class="fas fa-check-circle"></i> Verified
        </span>
    @elseif($payment->status === 'rejected')
        <span class="btn btn-sm btn-outline-danger disabled">
            <i class="fas fa-times-circle"></i> Rejected
        </span>
    @endif
</div>

<script>
function showConfirmButtons(paymentId, action) {
    const container = document.getElementById(`payment-actions-${paymentId}`);
    const initialButtons = container.querySelector('.initial-buttons');
    const verifyConfirmButtons = container.querySelector('.verify-confirm-buttons');
    const rejectConfirmButtons = container.querySelector('.reject-confirm-buttons');
    
    initialButtons.classList.add('d-none');
    
    if (action === 'verify') {
        verifyConfirmButtons.classList.remove('d-none');
        verifyConfirmButtons.classList.add('d-flex');
    } else {
        rejectConfirmButtons.classList.remove('d-none');
        rejectConfirmButtons.classList.add('d-flex');
    }
}

function hideConfirmButtons(paymentId) {
    const container = document.getElementById(`payment-actions-${paymentId}`);
    const initialButtons = container.querySelector('.initial-buttons');
    const verifyConfirmButtons = container.querySelector('.verify-confirm-buttons');
    const rejectConfirmButtons = container.querySelector('.reject-confirm-buttons');
    
    initialButtons.classList.remove('d-none');
    verifyConfirmButtons.classList.add('d-none');
    verifyConfirmButtons.classList.remove('d-flex');
    rejectConfirmButtons.classList.add('d-none');
    rejectConfirmButtons.classList.remove('d-flex');
}
</script>