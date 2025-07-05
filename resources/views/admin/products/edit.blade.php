@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Type</label>
        <input name="type" value="{{ old('type', $product->type) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Current Image</label><br>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100" class="mb-2">
        @else
            <p>No image uploaded</p>
        @endif
    </div>

    <div class="mb-3">
        <label>Change Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-primary">Update Product</button>
</form>
@endsection