<!-- resources/views/admin/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <x-admin.layout.sidebar />
        
        <div class="content-wrapper">
            <!-- Navbar -->
            <x-admin.layout.navbar />
            
            <!-- Main Content -->
            <main class="content px-4 py-3">
                <!-- Alerts -->
                @if(session('success'))
                    <x-admin.shared.alert type="success" :message="session('success')" />
                @endif
                
                @if(session('error'))
                    <x-admin.shared.alert type="danger" :message="session('error')" />
                @endif
                
                <!-- Content -->
                @yield('content')
            </main>
            
            <!-- Footer -->
            <x-admin.layout.footer />
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/admin.js') }}"></script>
    
    @stack('scripts')
</body>
</html>