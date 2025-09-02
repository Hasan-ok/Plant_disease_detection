@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Type</label>
        <input name="type" value="{{ old('type') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
    <button class="btn btn-primary">Save Product</button>
</form>
@endsection
