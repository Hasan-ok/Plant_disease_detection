@extends('layouts.gardener')

@section('title', 'Edit Treatment')

@section('content')
<div class="container py-4">
    <h2>Edit Treatment</h2>

    <form action="{{ route('gardener.treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('gardener.treatments.partials.form')

        <button type="submit" class="btn btn-primary">Update Treatment</button>
        <a href="{{ route('gardener.treatments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
