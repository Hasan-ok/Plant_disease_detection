<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Mockery;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_to_stripe_checkout()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 10]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user);

        // Mock Stripe Session
        $mockStripeSession = Mockery::mock('alias:Stripe\Checkout\Session');
        $mockStripeSession->shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => 'https://stripe.test/session']);

        $response = $this->get(route('payment.checkout'));

        $response->assertRedirect('https://stripe.test/session');
    }

    public function test_success_payment_creates_order_and_clears_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 20]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('payment.success'));

        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'total' => 20]);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id]);
        $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
    }
}