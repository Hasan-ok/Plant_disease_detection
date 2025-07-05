@extends('layouts.gardener')

@section('title', 'Gardener Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Welcome, Gardener!</h2>
    <p class="text-muted">Manage your treatments, view disease information, and contribute your expertise here.</p>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Manage Treatments</h5>
                    <p class="card-text">Add, edit, or delete plant treatments.</p>
                    <a href="{{ route('gardener.treatments.index') }}" class="btn btn-success">Go to Treatments</a>
                </div>
            </div>
        </div>

        {{-- Add more cards/links as needed --}}
    </div>
</div>
@endsection
