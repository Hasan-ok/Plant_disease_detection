<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ProductUserController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9);

        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        }

        return view('products.index', compact('products', 'cartCount'));
    }
}
