@extends('layouts.app')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Available Products</h2>
        <div class="flex justify-between items-center mb-6">        
            <a href="{{ route('cart.index') }}" class="btn btn-primary relative">
                🛒 View Cart
                @if($cartCount > 0)
                    <span class="ml-2 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-0.5">
                        {{ $cartCount }}
                    </span>
                @else
                    <span class="ml-2 text-gray-500 text-sm">(Empty)</span>
                @endif
            </a>
        </div>


        @if($products->count())
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-full h-40 object-cover rounded mb-4">
                        @endif
                        <h3 class="text-xl font-semibold text-green-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mt-2"><strong>Price:</strong> ${{ $product->price }}</p>
                        <p class="text-sm text-gray-600 mt-1"><strong>Type:</strong> {{ ucfirst($product->type) }}</p>
                        <p class="text-xs text-gray-500 mt-2"><strong>{{ Str::limit($product->description, 100) }}</strong></p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center space-x-2 mt-2">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" class="w-16 px-2 py-1 border rounded" required>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-center text-gray-500">No products have been added yet.</p>
        @endif
    </div>
</section>
@endsection