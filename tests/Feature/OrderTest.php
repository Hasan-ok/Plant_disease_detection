<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_checkout_and_order_is_created()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 25]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $this->actingAs($user);

        $response = $this->post(route('orders.store'));

        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHas('success', 'Order placed successfully!');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 50.00,
            'status' => 'pending'
        ]);

        $order = Order::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 25.00
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_checkout_with_empty_cart()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('orders.store'));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Your cart is empty.');

        $this->assertDatabaseCount('orders', 0);
    }
}