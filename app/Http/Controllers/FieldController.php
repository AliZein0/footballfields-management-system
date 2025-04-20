<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportField; // Assuming this is your field model
use Illuminate\Support\Facades\DB;
use App\Models\Image;
class FieldController extends Controller
{
    /**
     * Handle the search functionality
     */
    public function search(Request $request)
    {
        // Start with a base query
        $query = DB::table('sport_fields');
        
        // Apply filters based on request parameters
        
        // Filter by name if provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Filter by city if provided
        if ($request->filled('city') && $request->city !== "") {
            $query->where('city', $request->city);
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
        return view('players.index', compact('searchResults', 'resultsCount'));
    }



    function show(SportField $field)
    {
        
        return view('sport_fields.show',[
            'field' => $field,
        ]);
    }


    
    
}