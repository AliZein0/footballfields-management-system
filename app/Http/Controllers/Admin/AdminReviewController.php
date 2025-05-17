<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * Remove the specified review from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $fieldId = $review->field_id;
        
        $review->delete();
        
        // Update the field's rating
        $field = $review->field;
        $averageRating = $field->reviews()->avg('rating');
        
        if ($averageRating) {
            $field->rating = round($averageRating);
            $field->save();
        }
        
        return redirect()->route('admin.fields.reviews', $fieldId)
            ->with('success', 'Review deleted successfully');
    }
}