<!-- resources/views/admin/fields/index.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sport Fields Management</h1>
        
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
    
    <!-- Filter Form -->
    <x-admin.fields.filter />
    
    <!-- Fields Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sport Fields</h6>
        </div>
        <div class="card-body">
            <x-admin.fields.table :fields="$fields" />
            
           
         <x-admin.shared.pagination :paginator="$fields" />
        </div>
    </div>
</div>
@endsection