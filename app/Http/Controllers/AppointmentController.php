<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Expert;
use App\Mail\AppointmentBooked;
use App\Mail\AppointmentUpdated;
use Illuminate\Support\Facades\Mail;


class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'expert_id' => 'required|exists:experts,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'tree_type' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'disease' => 'nullable|string|max:255',
            'user_treatment' => 'nullable|string',
            'tree_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('tree_image')) {
            $imagePath = $request->file('tree_image')->store('tree_images', 'public');
        }

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'expert_id' => $request->expert_id,
            'date' => $request->date,
            'time' => $request->time,
            'tree_type' => $request->tree_type,
            'issue' => $request->issue,
            'disease' => $request->disease,
            'user_treatment' => $request->user_treatment,
            'tree_image' => $imagePath,
        ]);
        $expertEmail = Expert::find($request->expert_id)->email ?? null;

        if ($expertEmail) {
            Mail::to($expertEmail)->send(new AppointmentBooked($appointment));
        } else {
            Mail::to('hasanokabalan@gmail.com')->send(new AppointmentBooked($appointment));
            \Log::warning("No email found for expert ID: " . $request->expert_id);
        }

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }

    public function index()
    {
    $appointments = Appointment::where('user_id', auth()->id())->get();
    return view('appointments.index', compact('appointments'));
    }

    public function edit(Appointment $appointment)
    {
    if ($appointment->user_id !== auth()->id()) abort(403);

    return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
        ]);

        $appointment->update([
            'date' => $request->date,
            'time' => $request->time,
        ]);

        $expertEmail = $appointment->expert->email ?? 'hasanok9999@gmail.com';
        Mail::to($expertEmail)->send(new AppointmentUpdated($appointment));

        return redirect()->back()->with('success', 'Appointment updated and expert notified!');
    }

    public function destroy(Appointment $appointment)
    {
    if ($appointment->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $appointment->delete();

    return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
