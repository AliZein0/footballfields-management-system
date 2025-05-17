<!-- resources/views/components/admin/bookings/status-dropdown.blade.php -->
@props(['id'])

<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Status
    </button>
    <ul class="dropdown-menu">
        <li>
            <form action="{{ route('admin.bookings.update-status', $id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="dropdown-item">Mark as Completed</button>
            </form>
        </li>
        <li>
            <form action="{{ route('admin.bookings.update-status', $id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="dropdown-item">Mark as Cancelled</button>
            </form>
        </li>
    </ul>
</div>