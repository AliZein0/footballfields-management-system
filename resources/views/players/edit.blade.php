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
                        

                        <form action="{{ route('players.update', 11) }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $player->user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $player->user->email }}">
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ $player->phone_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{ $player->location }}">
                                </div>
                            </div>

                            {{-- <div class="mb-4">
                                <label class="form-label">Preferred Sports</label>
                                <div class="row g-2">
                                    @foreach($availableSports as $value => $label)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="preferred_sports[]" 
                                                    value="{{ $value }}" 
                                                    id="sport_{{ $value }}"
                                                    {{ in_array($value, $player->preferred_sports ?? []) ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="sport_{{ $value }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div> --}}

                            <div class="mb-4">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4">{{ $player->bio }}</textarea>
                                <div class="form-text">Tell others about yourself and your sporting interests. (Max 500 characters)</div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('players.show', 11) }}" class="btn btn-outline-secondary">
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