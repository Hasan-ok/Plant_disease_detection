@extends('layouts.admin')

@section('title', 'Manage Experts')
@section('page-title', 'Manage Experts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Experts Management</h2>
        <p class="text-muted">Manage plant disease experts in the system</p>
    </div>
    <a href="{{ route('admin.experts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Expert
    </a>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.experts') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search Experts</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name, email, specialty...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Experts Table -->
<div class="card">
    <div class="card-body">
        @if($experts->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Specialty</th>
                            <th>Experience</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($experts as $expert)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($expert->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $expert->name }}</div>
                                        <small class="text-muted">{{ $expert->qualification }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $expert->email }}</td>
                            <td>{{ $expert->phone ?: 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $expert->specialty }}</span>
                            </td>
                            <td>{{ $expert->experience_years }} years</td>
                            <td>
                                <span class="badge bg-{{ $expert->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($expert->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.experts.show', $expert) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.experts.edit', $expert) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.experts.destroy', $expert) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this expert?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $experts->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                <h5>No experts found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No experts match your search criteria.
                    @else
                        Start by adding your first expert to the system.
                    @endif
                </p>
                <a href="{{ route('admin.experts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Expert
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
