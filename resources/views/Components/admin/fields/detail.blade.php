<!-- resources/views/components/admin/fields/detail.blade.php -->
@props(['field'])

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Name:</div>
                    <div class="col-md-8">{{ $field->name }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Type:</div>
                    <div class="col-md-8">{{ ucfirst($field->type) }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Size:</div>
                    <div class="col-md-8">{{ $field->size }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Fees:</div>
                    <div class="col-md-8">${{ number_format($field->fees, 2) }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Rating:</div>
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <span class="me-2">{{ $field->rating }}/5</span>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $field->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Covered:</div>
                    <div class="col-md-8">{{ $field->is_covered ? 'Yes' : 'No' }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $field->is_active ? 'success' : 'danger' }}">
                            {{ $field->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Location</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">City:</div>
                    <div class="col-md-8">{{ $field->location }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Manager:</div>
                    <div class="col-md-8">
                        <a href="{{ route('admin.users.show', $field->manager_id) }}">
                            {{ $field->manager->name }}
                        </a>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6 class="font-weight-bold">Map Location:</h6>
                    <div class="embed-responsive embed-responsive-16by9">
                        {!! $field->mapEmbed !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Field Images</h6>
               
            </div>
            <div class="card-body">
                <div class="row">
                    @if($field->main_image_path)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $field->main_image_path) }}" 
                                     class="card-img-top" alt="Main Image" style="height: 150px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <span class="badge bg-primary">Main Image</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @forelse($field->images as $image)
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="card-img-top" alt="Field Image" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2 d-flex justify-content-between">
                                    <form action="{{ route('admin.fields.set-main-image', ['field' => $field->id, 'image' => $image->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            Set as Main
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.fields.delete-image', $image->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No additional images available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Default Schedules</h6>
            </div>
            <div class="card-body">
                @if(isset($field->defaultSchedule))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $field->defaultSchedule->day ?? 'All Days' }}</td>
                                    <td>{{ $field->defaultSchedule->from_time }}</td>
                                    <td>{{ $field->defaultSchedule->to_time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No default schedule available.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Description</h6>
            </div>
            <div class="card-body">
                {{ $field->details ?? 'No description available.' }}
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Reviews</h6>
                <a href="{{ route('admin.fields.reviews', $field->id) }}" class="btn btn-sm btn-primary">
                    View All Reviews
                </a>
            </div>
            <div class="card-body">
                @if($field->reviews && $field->reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($field->reviews->take(5) as $review)
                                    <tr>
                                        <td>{{ $review->player->user->name }}</td>
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
                                        <td>{{ $review->comment }}</td>
                                        <td>{{ $review->date->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No reviews available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
