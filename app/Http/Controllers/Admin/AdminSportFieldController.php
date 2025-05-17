<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportField;
use Illuminate\Http\Request;

class AdminSportFieldController extends Controller
{
    /**
     * Display a listing of the fields for admin.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function adminFieldsIndex(Request $request)
    {
        $query = SportField::query();
        
        // Apply filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        // Try to filter by is_active if the column exists
        try {
            if ($request->filled('is_active')) {
                $query->where('is_active', $request->is_active);
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet, skip this filter
        }
        
        // Default sorting
        $query->orderBy('created_at', 'desc');
        
        // Get fields with pagination - without eager loading relationships
        $fields = $query->paginate(10);
        
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Display the specified field.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $field = SportField::findOrFail($id);
        return view('admin.fields.show', compact('field'));
    }

    /**
     * Toggle the status of the specified field.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus($id)
    {
        $field = SportField::findOrFail($id);
        
        try {
            $field->is_active = !$field->is_active;
            $field->save();
            
            return redirect()->back()
                ->with('success', 'Field status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Could not toggle status: the is_active column does not exist yet.');
        }
    }
}