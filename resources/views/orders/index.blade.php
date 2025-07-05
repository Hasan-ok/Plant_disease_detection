@extends('layouts.app')

@section('title', 'My Orders')
@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-4">My Orders</h2>

    @foreach($orders as $order)
        <div class="border p-4 rounded mb-4">
            <h3 class="font-bold">Order #{{ $order->id }} — ${{ $order->total }}</h3>
            <p>Status: {{ ucfirst($order->status) }}</p>
            <ul class="list-disc ml-6 mt-2">
                @foreach($order->items as $item)
                    <li>{{ $item->product->name }} x{{ $item->quantity }} — ${{ $item->price }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4">Back to Products</a>
</div>
@endsection
