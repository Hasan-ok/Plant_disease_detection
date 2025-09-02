@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- 👤 Expert Stats -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3 text-muted">Expert Stats</h5>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">{{ $totalExperts }}</h4>
                    <p class="card-text">Total Experts</p>
                </div>
                <i class="fas fa-user-md fa-2x align-self-center"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">{{ $activeExperts }}</h4>
                    <p class="card-text">Active Experts</p>
                </div>
                <i class="fas fa-check-circle fa-2x align-self-center"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">{{ $totalExperts - $activeExperts }}</h4>
                    <p class="card-text">Inactive Experts</p>
                </div>
                <i class="fas fa-pause-circle fa-2x align-self-center"></i>
            </div>
        </div>
    </div>
</div>

<!-- 🛒 Sales & Revenue -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3 text-muted">Sales & Revenue</h5>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-secondary">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">{{ $totalOrders }}</h4>
                    <p class="card-text">Total Orders</p>
                </div>
                <i class="fas fa-shopping-cart fa-2x align-self-center"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-dark">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">${{ number_format($totalRevenue, 2) }}</h4>
                    <p class="card-text">Total Revenue</p>
                </div>
                <i class="fas fa-dollar-sign fa-2x align-self-center"></i>
            </div>
        </div>
    </div>
</div>

<!-- 📦 Product Summary -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3 text-muted">Product Summary</h5>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="card-title">{{ $totalProducts }}</h4>
                    <p class="card-text">Total Products</p>
                </div>
                <i class="fas fa-box-open fa-2x align-self-center"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Top Selling Products</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">View All Products</a>
    </div>
    <div class="card-body">
        @if($topProducts->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->total_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No product sales data available.</p>
        @endif
    </div>
</div>

<h2 class="text-xl font-semibold mb-2">Count by Role</h2>
<div style="width: 300px; height: 300px; margin: auto;">
    <canvas id="roleDistributionChart"></canvas>
</div>

<div>
    <h2 class="text-xl font-semibold mb-2">Weekly Orders</h2>
    <canvas id="weeklyOrdersChart" width="200" height="50"></canvas>
</div>

<div>
    <h2 class="text-xl font-semibold mb-2">Top Selling Products</h2>
    <canvas id="topProductsChart" width="200" height="50"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const weeklyOrdersCtx = document.getElementById('weeklyOrdersChart').getContext('2d');
    const weeklyOrdersChart = new Chart(weeklyOrdersCtx, {
        type: 'line',
        data: {
            labels: @json($weeklyOrders->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))),
            datasets: [{
                label: 'Orders',
                data: @json($weeklyOrders->pluck('count')),
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });

    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    const topProductsChart = new Chart(topProductsCtx, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('name')),
            datasets: [{
                label: 'Quantity Sold',
                data: @json($topProducts->pluck('total_quantity')),
                backgroundColor: 'rgba(34, 197, 94, 0.8)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, precision: 0 }
            }
        }
    });

    const ctx = document.getElementById('roleDistributionChart').getContext('2d');
    const roleChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($userRoleCounts->keys()) !!},
            datasets: [{
                label: 'Distribution',
                data: {!! json_encode($userRoleCounts->values()) !!},
                backgroundColor: [
                    '#4CAF50',
                    '#2196F3',
                    '#FF9800', 
                    '#9C27B0'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
        
    });
</script>

@endsection