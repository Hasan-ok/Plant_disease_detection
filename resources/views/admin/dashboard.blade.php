@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalExperts }}</h4>
                        <p class="card-text">Total Experts</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $activeExperts }}</h4>
                        <p class="card-text">Active Experts</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalExperts - $activeExperts }}</h4>
                        <p class="card-text">Inactive Experts</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-pause-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ date('M') }}</h4>
                        <p class="card-text">Current Month</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Experts -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Experts</h5>
                <a href="{{ route('admin.experts') }}" class="btn btn-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                @if($recentExperts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Specialty</th>
                                    <th>Status</th>
                                    <th>Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentExperts as $expert)
                                <tr>
                                    <td>{{ $expert->name }}</td>
                                    <td>{{ $expert->email }}</td>
                                    <td>{{ $expert->specialty }}</td>
                                    <td>
                                        <span class="badge bg-{{ $expert->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($expert->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $expert->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No experts found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection