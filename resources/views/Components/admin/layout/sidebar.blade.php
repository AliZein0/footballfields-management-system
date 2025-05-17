<!-- resources/views/components/admin/layout/sidebar.blade.php -->
<div class="sidebar bg-dark text-white">
    <div class="sidebar-header py-3 px-4 d-flex justify-content-center">
        <h3>Sports Admin</h3>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users me-2"></i> User Management
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('admin/fields*') ? 'active' : '' }}" href="{{ route('admin.fields.index') }}">
                <i class="fas fa-map-marker-alt me-2"></i> Sport Fields
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('admin/bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                <i class="fas fa-calendar-check me-2"></i> Bookings
            </a>
      
        
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                <i class="fas fa-credit-card me-2"></i> Payments
            </a>
        </li>
        
       
       
        
        </li>
    </ul>
</div>