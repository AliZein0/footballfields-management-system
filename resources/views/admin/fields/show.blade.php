<!-- resources/views/admin/fields/show.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fields.index') }}">Sport Fields</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $field->name }}</li>
        </ol>
    </nav>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $field->name }}</h1>
        <div>
            
            <a href="{{ route('admin.fields.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <x-admin.fields.detail :field="$field" />
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Preview images before upload
        $('#images').on('change', function() {
            $('#imagePreview').html('');
            var files = $(this)[0].files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').append('<img src="' + e.target.result + '" class="img-thumbnail me-2 mb-2" style="height: 100px;">');
                }
                reader.readAsDataURL(files[i]);
            }
        });
    });
</script>
@endpush