<?php

namespace App\Http\Controllers\Gardener;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::where('user_id', Auth::id())->latest()->paginate(10);
        return view('gardener.treatments.index', compact('treatments'));
    }

    public function create()
    {
        return view('gardener.treatments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'disease' => 'required|string|max:255',
            'symptoms' => 'required|string',
            'care' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('treatments', 'public');
        }

        $data['user_id'] = Auth::id();

        Treatment::create($data);

        return redirect()->route('gardener.treatments.index')->with('success', 'Treatment created successfully.');
    }

    public function show(Treatment $treatment)
    {
        $this->authorizeTreatment($treatment);
        return view('gardener.treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment)
    {
        $this->authorizeTreatment($treatment);
        return view('gardener.treatments.edit', compact('treatment'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $this->authorizeTreatment($treatment);

        $data = $request->validate([
            'disease' => 'required|string|max:255',
            'symptoms' => 'required|string',
            'care' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($treatment->image) {
                Storage::disk('public')->delete($treatment->image);
            }
            $data['image'] = $request->file('image')->store('treatments', 'public');
        }

        $treatment->update($data);

        return redirect()->route('gardener.treatments.index')->with('success', 'Treatment updated successfully.');
    }

    public function destroy(Treatment $treatment)
    {
        $this->authorizeTreatment($treatment);

        if ($treatment->image) {
            Storage::disk('public')->delete($treatment->image);
        }

        $treatment->delete();

        return redirect()->route('gardener.treatments.index')->with('success', 'Treatment deleted successfully.');
    }

    private function authorizeTreatment(Treatment $treatment)
    {
        if ($treatment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
