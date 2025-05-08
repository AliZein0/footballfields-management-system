<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportField; // Assuming this is your field model
use Illuminate\Support\Facades\DB;
use App\Models\Image;
class SportFieldController extends Controller
{
    /**
     * Handle the search functionality
     */
    public function search(Request $request)
    {
        // Start with a base query
        $query = DB::table('sport_fields');
        $fields = SportField::all();
        // Apply filters based on request parameters
        
        // Filter by name if provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Filter by city if provided
        if ($request->filled('location') && $request->city !== "") {
            $query->where('location', $request->city);
        }
        
        // Filter by sport type if provided
        if ($request->filled('type') && $request->type !== "") {
            $query->where('type', $request->type);
        }
        
        // Apply advanced search filters if provided
        
        // Filter by size if provided
        if ($request->filled('size') && $request->size !== "") {
            $query->where('size', $request->size);
        }
        
        // Filter by is_covered (indoor/outdoor) if provided
        if ($request->filled('is_covered') && $request->is_covered !== "") {
            $query->where('is_covered', $request->is_covered);
        }
        
        // Filter by fees range if provided
        if ($request->filled('fees') && $request->fees !== "") {
            // Check if it's a range (e.g., "50-100") or a minimum (e.g., "200+")
            if (strpos($request->fees, '-') !== false) {
                list($min, $max) = explode('-', $request->fees);
                $query->whereBetween('fees', [(float)$min, (float)$max]);
            } elseif (strpos($request->fees, '+') !== false) {
                $min = (float)str_replace('+', '', $request->fees);
                $query->where('fees', '>=', $min);
            }
        }
        
        // Execute the query and paginate results
        $searchResults = $query->paginate(6);
        
        // Get the count of total results
        $resultsCount = $searchResults->total();
        
        // Pass data to the view
        return view('players.index', compact('searchResults', 'resultsCount' , 'fields'));
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




   


    
    
}