{{-- resources/views/player/edit-profile.blade.php --}}
<x-layout title="Edit Profile" bodyClass="edit-profile-page bg-light">
    <x-player_header />

    <!-- Main Content -->
    <main class="container py-5 flex-grow-1 mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-success text-white p-3">
                        <h5 class="mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('players.update', session('player_id')) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-12 text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img 
                                            src="{{ $player->user->profile_photo_url ?? 'https://th.bing.com/th/id/OIP.k6-0bR_5ijgMASJ1yl_NiQHaHa?w=250&h=250&c=8&rs=1&qlt=90&o=6&dpr=1.1&pid=3.1&rm=2' }}" 
                                            alt="Profile photo" 
                                            class="rounded-circle border border-4 border-white shadow" 
                                            style="width: 150px; height: 150px; object-fit: cover;"
                                        />
                                        <label for="profile_photo" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-2" style="cursor: pointer; border: 2px solid white;">
                                            <i class="bi bi-camera"></i>
                                        </label>
                                    </div>
                                    <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">
                                    <div class="small text-muted mt-2">Click on the camera icon to upload a new photo</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $player->user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $player->user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $player->user->phone_number) }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $player->user->location) }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Preferred Sports</label>
                                <div class="row g-2">
                                    @php
                                        // Convert player sports to array if it's a string or JSON
                                        $playerSports = [];
                                        if (isset($player->sport)) {
                                            if (is_string($player->sport)) {
                                                // If it's stored as a string, try to decode as JSON first
                                                $decoded = json_decode($player->sport, true);
                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                    $playerSports = $decoded;
                                                } else {
                                                    // If not JSON, assume it's a comma-separated string
                                                    $playerSports = explode(',', $player->sport);
                                                }
                                            } elseif (is_array($player->sport)) {
                                                $playerSports = $player->sport;
                                            } else {
                                                // If it's a single value enum
                                                $playerSports = [$player->sport];
                                            }
                                        }
                                    @endphp
                                    
                                    @foreach($availableSports as $value => $label)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="preferred_sports[]" 
                                                    value="{{ $value }}" 
                                                    id="sport_{{ $value }}"
                                                    {{ in_array($value, $playerSports) ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="sport_{{ $value }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('preferred_sports')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $player->bio) }}</textarea>
                                <div class="form-text">Tell others about yourself and your sporting interests. (Max 500 characters)</div>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('players.profile', session('player_id')) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Preview image before upload
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    document.querySelector('img.rounded-circle').setAttribute('src', event.target.result);
                }
                
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-layout>