@extends('layouts.app')

@section('title', 'My Cart')
@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table-auto w-full mb-6 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 px-2 py-1 border rounded">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center mt-6 ml-5">
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>

            <div class="text-right font-bold text-lg">
                Total: ${{ number_format($totalPrice, 2) }}
            </div>
        </div>

    @endif

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4 ml-5">Back to Products</a>
</div>
@endsection