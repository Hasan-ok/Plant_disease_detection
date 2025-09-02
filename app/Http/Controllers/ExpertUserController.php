<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use Illuminate\Http\Request;

class ExpertUserController extends Controller
{
    public function index(Request $request)
    {
        $experts = Expert::query();

        if ($request->filled('name')) {
            $experts->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('specialty')) {
            $experts->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        $experts = $experts->paginate(9)->withQueryString();

        return view('experts.index', compact('experts'));
    }
}
