@extends('layouts.admin')
@section('title', 'Edit Ticket — Admin')
@section('page-title', 'Edit Ticket')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Edit: {{ $ticket->title }}</h4>
    <a href="{{ route('admin.tickets.index') }}" class="btn-admin-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Tickets
    </a>
</div>

<div class="admin-form-card">
    <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="row g-4">
            <div class="col-12"><div class="form-section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</div></div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Ticket Title *</label>
                <input type="text" name="title" class="form-control custom-input @error('title') is-invalid @enderror"
                       value="{{ old('title', $ticket->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Category *</label>
                <select name="category" class="form-control custom-input" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $ticket->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-control custom-input" required>
                    @foreach(['available','booked','hold','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $ticket->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Airline</label>
                <input type="text" name="airline" class="form-control custom-input" value="{{ old('airline', $ticket->airline) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Origin *</label>
                <input type="text" name="origin" class="form-control custom-input" value="{{ old('origin', $ticket->origin) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Destination *</label>
                <input type="text" name="destination" class="form-control custom-input" value="{{ old('destination', $ticket->destination) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Departure Date *</label>
                <input type="date" name="departure_date" class="form-control custom-input"
                       value="{{ old('departure_date', $ticket->departure_date->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Return Date</label>
                <input type="date" name="return_date" class="form-control custom-input"
                       value="{{ old('return_date', $ticket->return_date?->format('Y-m-d')) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Price (PKR) *</label>
                <input type="number" name="price" class="form-control custom-input"
                       value="{{ old('price', $ticket->price) }}" min="0" step="100" required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Seats Available *</label>
                <input type="number" name="seats_available" class="form-control custom-input"
                       value="{{ old('seats_available', $ticket->seats_available) }}" min="0" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control custom-input" rows="3">{{ old('description', $ticket->description) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Change Image</label>
                <input type="file" name="image" class="form-control custom-input" accept="image/*" onchange="previewImage(this)">
                @if($ticket->image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($ticket->image) }}" style="height:80px;border-radius:8px;" alt="Current image">
                        <small class="text-muted d-block mt-1">Current image — upload new to replace</small>
                    </div>
                @endif
                <div id="imagePreview" style="display:none;" class="mt-2">
                    <img id="previewImg" src="" style="height:80px;border-radius:8px;" alt="New preview">
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-4 pt-3 border-top">
            <button type="submit" class="btn-admin-primary px-5"><i class="fas fa-save me-2"></i>Update Ticket</button>
            <a href="{{ route('admin.tickets.index') }}" class="btn-admin-secondary px-4">Cancel</a>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
