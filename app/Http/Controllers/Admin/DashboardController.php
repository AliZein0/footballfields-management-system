<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\SportField;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get stats for dashboard
        $totalUsers = User::count();
        $totalRevenue = Payment::where('status', 'completed')
            ->sum(DB::raw('field_fee + website_fee'));
        $activeFields = SportField::where('is_active', true)->count();
        $pendingBookings = Booking::where('status', 'upcoming')->count();
        
        // Recent bookings
        $recentBookings = Booking::with(['player.user', 'sportfield'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Pending payments
        $pendingPayments = Payment::with(['booking.player.user', 'booking.sportfield'])
            ->where('status', 'pending')
            ->orderBy('paid_at', 'desc')
            ->take(5)
            ->get();
        
        // Field usage by type
        $fieldsByType = SportField::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();
        
        $fieldTypes = $fieldsByType->pluck('type')->map(function($type) {
            return ucfirst($type);
        })->toArray();
        
        $fieldCounts = $fieldsByType->pluck('count')->toArray();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRevenue',
            'activeFields',
            'pendingBookings',
            'recentBookings',
            'pendingPayments',
            'fieldTypes',
            'fieldCounts'
        ));
    }
}