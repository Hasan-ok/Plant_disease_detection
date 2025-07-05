@extends('layouts.admin')

@section('title', 'Expert Details')
@section('page-title', 'Expert Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Expert Information</h5>
                <div>
                    <a href="{{ route('admin.experts.edit', $expert) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form action="{{ route('admin.experts.destroy', $expert) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this expert?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <p class="form-control-plaintext">{{ $expert->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <p class="form-control-plaintext">
                                <a href="mailto:{{ $expert->email }}">{{ $expert->email }}</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <p class="form-control-plaintext">
                                @if($expert->phone)
                                    <a href="tel:{{ $expert->phone }}">{{ $expert->phone }}</a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Specialty</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $expert->specialty }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Experience</label>
                            <p class="form-control-plaintext">{{ $expert->experience_years }} years</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Qualification</label>
                            <p class="form-control-plaintext">{{ $expert->qualification }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $expert->status === 'active' ? 'success' : 'secondary' }} fs-6">
                                    {{ ucfirst($expert->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Joined Date</label>
                            <p class="form-control-plaintext">{{ $expert->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>

                @if($expert->bio)
                <div class="mb-3">
                    <label class="form-label fw-bold">Biography</label>
                    <div class="border rounded p-3 bg-light">
                        {{ $expert->bio }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.experts') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Experts
                    </a>
                    <a href="{{ route('admin.experts.edit', $expert) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Expert
                    </a>
                    <a href="mailto:{{ $expert->email }}" class="btn btn-info">
                        <i class="fas fa-envelope me-2"></i>Send Email
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Expert Statistics</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" 
                         style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        {{ strtoupper(substr($expert->name, 0, 2)) }}
                    </div>
                    <h5>{{ $expert->name }}</h5>
                    <p class="text-muted">{{ $expert->specialty }} Expert</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col">
                            <div class="fw-bold text-primary">{{ $expert->experience_years }}</div>
                            <small class="text-muted">Years Exp.</small>
                        </div>
                        <div class="col">
                            <div class="fw-bold text-success">Active</div>
                            <small class="text-muted">Status</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection