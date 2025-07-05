<?php
namespace App\Http\Controllers\Admin;

use App\Models\Expert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin');
    }

    public function dashboard()
    {
        $totalExperts = Expert::count();
        $activeExperts = Expert::active()->count();
        $recentExperts = Expert::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalExperts', 'activeExperts', 'recentExperts'));
    }

    public function experts(Request $request)
    {
        $query = Expert::query();

        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $experts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.experts.index', compact('experts'))->with('search', $request->search);
    }

    public function createExpert()
    {
        return view('admin.experts.create');
    }

    public function storeExpert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:experts,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string|max:1000',
            'qualification' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Expert::create($request->all());

        return redirect()->route('admin.experts')
                        ->with('success', 'Expert added successfully!');
    }

    public function showExpert(Expert $expert)
    {
        return view('admin.experts.show', compact('expert'));
    }

    public function editExpert(Expert $expert)
    {
        return view('admin.experts.edit', compact('expert'));
    }

    public function updateExpert(Request $request, Expert $expert)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:experts,email,' . $expert->id,
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string|max:1000',
            'qualification' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $expert->update($request->all());

        return redirect()->route('admin.experts')
                        ->with('success', 'Expert updated successfully!');
    }

    public function destroyExpert(Expert $expert)
    {
        $expert->delete();

        return redirect()->route('admin.experts')
                        ->with('success', 'Expert deleted successfully!');
    }
}