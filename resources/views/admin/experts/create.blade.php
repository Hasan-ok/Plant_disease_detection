@extends('layouts.admin')

@section('title', 'Add New Expert')
@section('page-title', 'Add New Expert')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Expert</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.experts.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialty" class="form-label">Specialty <span class="text-danger">*</span></label>
                                <select class="form-select @error('specialty') is-invalid @enderror" 
                                        id="specialty" name="specialty" required>
                                    <option value="">Select Specialty</option>
                                    <option value="Fungal Diseases" {{ old('specialty') === 'Fungal Diseases' ? 'selected' : '' }}>Fungal Diseases</option>
                                    <option value="Bacterial Infections" {{ old('specialty') === 'Bacterial Infections' ? 'selected' : '' }}>Bacterial Infections</option>
                                    <option value="Viral Diseases" {{ old('specialty') === 'Viral Diseases' ? 'selected' : '' }}>Viral Diseases</option>
                                    <option value="Nutrient Deficiency" {{ old('specialty') === 'Nutrient Deficiency' ? 'selected' : '' }}>Nutrient Deficiency</option>
                                    <option value="Pest Management" {{ old('specialty') === 'Pest Management' ? 'selected' : '' }}>Pest Management</option>
                                    <option value="General Plant Health" {{ old('specialty') === 'General Plant Health' ? 'selected' : '' }}>General Plant Health</option>
                                </select>
                                @error('specialty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="experience_years" class="form-label">Years of Experience <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                       id="experience_years" name="experience_years" value="{{ old('experience_years') }}" 
                                       min="0" max="50" required>
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qualification" class="form-label">Qualification <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('qualification') is-invalid @enderror" 
                                       id="qualification" name="qualification" value="{{ old('qualification') }}" 
                                       placeholder="e.g., Ph.D. in Plant Pathology" required>
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Biography</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="4" 
                                  placeholder="Brief description of the expert's background and expertise">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.experts') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Expert
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection