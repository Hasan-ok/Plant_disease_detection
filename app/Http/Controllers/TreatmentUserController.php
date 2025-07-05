<?php

namespace App\Http\Controllers;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentUserController extends Controller
{
    public function index()
    {
        $treatments = Treatment::with('user')->latest()->paginate(9); // adjust per-page count if needed
        return view('treatments.index', compact('treatments'));
    }
}
