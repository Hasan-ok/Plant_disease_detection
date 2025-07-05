@extends('layouts.gardener')

@section('title', 'Add Treatment')

@section('content')
<div class="container py-4">
    <h2>Add New Treatment</h2>

    <form action="{{ route('gardener.treatments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('gardener.treatments.partials.form')

        <button type="submit" class="btn btn-success">Create Treatment</button>
        <a href="{{ route('gardener.treatments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

</div>
@endsection
