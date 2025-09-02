<?php
namespace App\Http\Controllers\Admin;

use App\Models\Expert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\ContactMessage;


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
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalProducts = Product::count();

        $userCounts = [
            'users' => User::where('role', 'user')->count(),
            'gardeners' => User::where('role', 'gardener')->count(),
            'experts' => User::where('role', 'expert')->count(),
        ];

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $weeklyOrders = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $userRoleCounts = User::select('role', \DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');
        $userRoleCounts['expert'] = $totalExperts;

        return view('admin.dashboard', compact(
            'totalExperts', 'activeExperts', 'recentExperts',
            'totalOrders', 'totalRevenue', 'totalProducts',
            'userCounts', 'topProducts', 'weeklyOrders', 'userRoleCounts'));
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

    public function messages()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }
}
