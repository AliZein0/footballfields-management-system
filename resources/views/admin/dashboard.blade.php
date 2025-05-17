<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Fields</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeFields }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Bookings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingBookings }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <x-admin.shared.card title="Recent Bookings">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Player</th>
                                <th>Field</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->player->user->name }}</td>
                                    <td>{{ $booking->sportfield->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'upcoming' ? 'primary' : 
                                                                  ($booking->status == 'completed' ? 'success' : 'danger') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <a href="" class="btn btn-sm btn-primary">View All Bookings</a>
                </div>
            </x-admin.shared.card>
        </div>
        
        <div class="col-xl-4 col-lg-5">
            <x-admin.shared.card title="Pending Payments">
                <div class="list-group">
                    @forelse($pendingPayments as $payment)
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Payment #{{ $payment->id }}</h6>
                                <small>${{ number_format($payment->field_fee + $payment->website_fee, 2) }}</small>
                            </div>
                            <p class="mb-1">{{ $payment->booking->player->user->name }} - {{ $payment->booking->sportfield->name }}</p>
                            <small>{{ $payment->paid_at->format('Y-m-d H:i') }}</small>
                        </a>
                    @empty
                        <div class="list-group-item">No pending payments</div>
                    @endforelse
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                        View All Pending Payments
                    </a>
                </div>
            </x-admin.shared.card>
            
            <x-admin.shared.card title="Field Usage by Type" class="mt-4">
                <canvas id="fieldUsageChart" height="250"></canvas>
            </x-admin.shared.card>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Field usage chart
    var ctx = document.getElementById('fieldUsageChart').getContext('2d');
    var fieldUsageChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($fieldTypes) !!},
            datasets: [{
                data: {!! json_encode($fieldCounts) !!},
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush