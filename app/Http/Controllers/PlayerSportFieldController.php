<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportField; // Assuming this is your field model
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\Booking; 
use App\Models\Review;
use App\Models\Player;

class PlayerSportFieldController extends Controller
{
/**
 * This is a partial controller implementation that needs to be added to your existing controller
 * Showing how to handle the search logic properly
 */
public function index()
{
    // Get all fields for the default display
    $fields = SportField::all();
    
    // Check if user has any previous bookings
    $hasBookings = false;
    $lastVisitedFields = collect();
    
    if (session()->has('player_id')) {
        $playerId = session('player_id');
        $playerBookings = Booking::where('player_id', $playerId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($playerBookings->isNotEmpty()) {
            $hasBookings = true;
            
            // Get the fields from the bookings
            $fieldIds = $playerBookings->pluck('field_id')->unique();
            $lastVisitedFields = SportField::whereIn('id', $fieldIds)->get();
        }
    }
    
    // Check if a search is being performed - look for any non-empty search parameter
    $hasSearch = false;
    if (
        request()->has('city') && request('city') != '' ||
        request()->has('type') && request('type') != '' ||
        request()->has('name') && request('name') != '' ||
        request()->has('size') && request('size') != '' ||
        request()->has('fees') && request('fees') != '' ||
        request()->has('is_covered') && request('is_covered') != '' ||
        request()->has('min_rating') && request('min_rating') != ''
    ) {
        $hasSearch = true;
        
        // Perform the search
        $searchResults = $this->searchFields(request()->all());
        $resultsCount = $searchResults->count();
        
        return view('players.index', compact('fields', 'hasBookings', 'lastVisitedFields', 'hasSearch', 'searchResults', 'resultsCount'));
    }
    
    return view('players.index', compact('fields', 'hasBookings', 'lastVisitedFields'));
}

public function search(Request $request)
{
    // Handle the search request
    $searchResults = $this->searchFields($request->all());
    $resultsCount = $searchResults->count();
    $hasSearch = true;
    
    // Get all fields as a fallback
    $fields = SportField::all();
    
    // Check if user has any previous bookings
    $hasBookings = false;
    $lastVisitedFields = collect();
    
    if (session()->has('player_id')) {
        $playerId = session('player_id');
        $playerBookings = Booking::where('player_id', $playerId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($playerBookings->isNotEmpty()) {
            $hasBookings = true;
            
            // Get the fields from the bookings
            $fieldIds = $playerBookings->pluck('field_id')->unique();
            $lastVisitedFields = SportField::whereIn('id', $fieldIds)->get();
        }
    }
    
    return view('players.index', compact('fields', 'hasBookings', 'lastVisitedFields', 'hasSearch', 'searchResults', 'resultsCount'));
}

private function searchFields($params)
{
    $query = SportField::query();
    
    // Apply filters
    if (isset($params['city']) && $params['city'] != '') {
        $query->where('location', $params['city']);
    }
    
    if (isset($params['type']) && $params['type'] != '') {
        $query->where('type', $params['type']);
    }
    
    if (isset($params['name']) && $params['name'] != '') {
        $query->where('name', 'like', '%' . $params['name'] . '%');
    }
    
    if (isset($params['size']) && $params['size'] != '') {
        $query->where('size', $params['size']);
    }
    
    if (isset($params['fees']) && $params['fees'] != '') {
        // Parse price range
        $range = explode('-', $params['fees']);
        if (count($range) == 2) {
            $query->whereBetween('fees', [$range[0], $range[1]]);
        } elseif (str_ends_with($params['fees'], '+')) {
            $minValue = (float) str_replace('+', '', $params['fees']);
            $query->where('fees', '>=', $minValue);
        }
    }
    
    if (isset($params['is_covered']) && $params['is_covered'] != '') {
        $query->where('is_covered', $params['is_covered']);
    }
    
    if (isset($params['min_rating']) && $params['min_rating'] != '') {
        $query->where('rating', '>=', $params['min_rating']);
    }
    
    // Sort results
    if (isset($params['sort'])) {
        switch ($params['sort']) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('fees', 'asc');
                break;
            case 'price_high':
                $query->orderBy('fees', 'desc');
                break;
            case 'rating':
            default:
                $query->orderBy('rating', 'desc');
                break;
        }
    } else {
        // Default sorting
        $query->orderBy('rating', 'desc');
    }
    
    return $query->get();
}
    public function getDefaultSchedule($id)
    {
        // Get the sport field
        $sportField = SportField::findOrFail($id);
        
        // Instead of using the relationship that's trying to use the non-existent pivot table,
        // Query the default schedules directly using a join
        $defaultSchedules = DB::table('default_schedules')
            ->join('default_schedule_sport_field', 'default_schedules.id', '=', 'default_schedule_sport_field.default_schedule_id')
            ->where('default_schedule_sport_field.sport_field_id', $id)
            ->select('default_schedules.*')
            ->get();
            
        // Alternative approach if the table name is different
        // Replace 'your_actual_pivot_table' with the actual name of your pivot table
        /*
        $defaultSchedules = DB::table('default_schedules')
            ->join('your_actual_pivot_table', 'default_schedules.id', '=', 'your_actual_pivot_table.default_schedule_id')
            ->where('your_actual_pivot_table.sport_field_id', $id)
            ->select('default_schedules.*')
            ->get();
        */
        
        // Return appropriate response (adjust based on your needs)
        return view('sport_fields.schedules', [
            'sportField' => $sportField,
            'defaultSchedules' => $defaultSchedules
        ]);
    }
    
    // If you need to load the schedules in another method
    public function show($id)
    {
        $sportField = SportField::findOrFail($id);
        
        // Direct query without using the relationship
        $defaultSchedules = DB::table('default_schedules')
            ->join('default_schedule_sport_field', 'default_schedules.id', '=', 'default_schedule_sport_field.default_schedule_id')
            ->where('default_schedule_sport_field.sport_field_id', $id)
            ->select('default_schedules.*')
            ->get();
            
        return view('sport_fields.show', compact('sportField', 'defaultSchedules'));
    }



/**
 * Display all venues with optional filtering and sorting
 *
 * @param Request $request
 * @return \Illuminate\View\View
 */
public function allFields(Request $request)
{
    // Start with a base query
    $query = SportField::query();
    
    // Apply filters if they exist
    if ($request->filled('city')) {
        $query->where('location', $request->city);
    }
    
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    
    if ($request->filled('size')) {
        $query->where('size', $request->size);
    }
    
    if ($request->filled('fees')) {
        // Parse price range
        $range = explode('-', $request->fees);
        if (count($range) == 2) {
            $query->whereBetween('fees', [$range[0], $range[1]]);
        } elseif (str_ends_with($request->fees, '+')) {
            $minValue = (float) str_replace('+', '', $request->fees);
            $query->where('fees', '>=', $minValue);
        }
    }
    
    if ($request->filled('is_covered')) {
        $query->where('is_covered', $request->is_covered);
    }
    
    if ($request->filled('min_rating')) {
        $query->where('rating', '>=', $request->min_rating);
    }
    
    // Apply sorting
    switch ($request->sort) {
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price_low':
            $query->orderBy('fees', 'asc');
            break;
        case 'price_high':
            $query->orderBy('fees', 'desc');
            break;
        case 'rating':
        default:
            $query->orderBy('rating', 'desc');
            break;
    }
    
    // Determine the page title based on filters
    $pageTitle = 'All Venues';
    
    if ($request->filled('min_rating') && $request->min_rating == '4.5') {
        $pageTitle = 'Top Rated Venues';
    } elseif ($request->sort == 'newest') {
        $pageTitle = 'Recently Added Venues';
    } elseif ($request->filled('type')) {
        $pageTitle = $request->type . ' Venues';
    } elseif ($request->filled('city')) {
        $cityName = SportField::LOCATIONS[$request->city] ?? $request->city;
        $pageTitle = 'Venues in ' . $cityName;
    }
    
    // Paginate the results - adjust the number per page as needed
    $allFields = $query->paginate(12);
    
    // Return the view with data
    return view('sportfields.all-fields', compact('allFields', 'pageTitle'));
}
   

/**
 * Get the reviews for the sport field.
 */
public function reviews()
{
    return $this->hasMany(Review::class, 'field_id');
}

/**
 * Get the average rating for this field.
 *
 * @return float|null
 */
public function getAverageRatingAttribute()
{
    return $this->reviews()->avg('rating');
}

/**
 * Get the review count for this field.
 *
 * @return int
 */
public function getReviewCountAttribute()
{
    return $this->reviews()->count();
}
    
    
}