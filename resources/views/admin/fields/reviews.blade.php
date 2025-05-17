<!-- resources/views/admin/fields/reviews.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fields.index') }}">Sport Fields</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fields.show', $field->id) }}">{{ $field->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reviews</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reviews for {{ $field->name }}</h1>
        <a href="{{ route('admin.fields.show', $field->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Field
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rating Summary</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="me-3 mb-0">{{ number_format($field->rating, 1) }}</h3>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $field->rating ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <div class="text-muted">Based on {{ $reviews->total() }} reviews</div>
                        </div>
                    </div>
                    
                    <!-- Rating Distribution -->
                    @php
                        $ratingCounts = [0, 0, 0, 0, 0];
                        foreach ($field->reviews as $review) {
                            $ratingCounts[$review->rating - 1]++;
                        }
                        $totalReviews = $field->reviews->count();
                    @endphp
                    
                    @for($i = 5; $i >= 1; $i--)
                        <div class="d-flex align-items-center mb-2">
                            <div style="width: 60px;">{{ $i }} stars</div>
                            <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" 
                                    style="width: {{ $totalReviews > 0 ? ($ratingCounts[$i-1] / $totalReviews) * 100 : 0 }}%"
                                    aria-valuenow="{{ $totalReviews > 0 ? ($ratingCounts[$i-1] / $totalReviews) * 100 : 0 }}" 
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div style="width: 30px;">{{ $ratingCounts[$i-1] }}</div>
                        </div>
                    @endfor
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Field Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Type</span>
                                    <span class="badge bg-primary">{{ ucfirst($field->type) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>City</span>
                                    <span>{{ $field->city }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Fees</span>
                                    <span>${{ number_format($field->fees, 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Covered</span>
                                    <span>{{ $field->is_covered ? 'Yes' : 'No' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Reviews ({{ $reviews->total() }})</h6>
        </div>
        <div class="card-body">
            @if($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Player</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $review->player->user->id) }}">
                                            {{ $review->player->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $review->rating }}/5</span>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $review->date->format('Y-m-d') }}</td>
                                    <td>
                                        @if(strlen($review->comment) > 100)
                                            {{ substr($review->comment, 0, 100) }}...
                                            <button type="button" class="btn btn-link btn-sm p-0" 
                                                    data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}">
                                                Read More
                                            </button>
                                        @else
                                            {{ $review->comment }}
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteReviewModal{{ $review->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Full Review Modal -->
                                <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Review from {{ $review->player->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">Rating: {{ $review->rating }}/5</span>
                                                        <div>
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $review->date->format('Y-m-d') }}</small>
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Delete Review Modal -->
                                <div class="modal fade" id="deleteReviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this review from {{ $review->player->user->name }}?</p>
                                                <p class="text-danger">This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $reviews->links() }}
                </div>
            @else
                <p class="text-center text-muted">No reviews available for this field.</p>
            @endif
        </div>
    </div>
</div>
@endsection