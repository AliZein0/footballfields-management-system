<!-- resources/views/components/admin/fields/table.blade.php -->
@props(['fields'])

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>City</th>
                <th>Fees</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fields as $field)
                <tr>
                    <td>{{ $field->id }}</td>
                    <td>
                        @if($field->main_image_path)
                            <img src="{{ asset('storage/' . $field->main_image_path) }}" 
                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" 
                                 alt="{{ $field->name }}">
                        @else
                            <div class="bg-light text-center" style="width: 50px; height: 50px; line-height: 50px;">
                                <i class="fas fa-image text-secondary"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $field->name }}</td>
                    <td>{{ ucfirst($field->type) }}</td>
                    <td>{{ $field->location }}</td>
                    <td>${{ number_format($field->fees, 2) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="me-2">{{ $field->rating }}/5</span>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $field->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.fields.toggle-status', $field->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $field->is_active ? 'btn-success' : 'btn-danger' }}">
                                {{ $field->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.fields.show', $field->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                           
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No sport fields found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>