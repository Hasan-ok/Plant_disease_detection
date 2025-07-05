@extends('layouts.gardener')

@section('title', 'Treatment Details')

@section('content')
<div class="container py-4">
    <h2>{{ $treatment->name }} - Details</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Disease:</strong> {{ $treatment->disease }}</p>
            <p><strong>Symptom:</strong> {{ $treatment->symptoms }}</p>
            <p><strong>Care:</strong> {{ $treatment->care }}</p>

            @if($treatment->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $treatment->image) }}" alt="{{ $treatment->name }}" class="img-fluid" style="max-width: 300px;">
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('gardener.treatments.edit', $treatment) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('gardener.treatments.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
