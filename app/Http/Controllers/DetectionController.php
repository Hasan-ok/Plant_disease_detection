<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\DetectionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DetectionController extends Controller
{
    public function index()
    {
        return view('detection.upload');
    }

    public function detectDisease(Request $request)
    {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ]);

    $image = $request->file('image');
    $imagePath = $image->store('uploads', 'public'); // Store the image and get path

    // Define your treatments dictionary here or import it from config
    $disease_treatments = [
        "Apple___Apple_scab" => "Use fungicides such as captan or mancozeb during the early growing season. Remove fallen leaves and prune infected branches.",
        "Apple___Black_rot" => "Apply fungicides like thiophanate-methyl or captan. Remove mummified fruit and prune cankers.",
        "Apple___Cedar_apple_rust" => "Use fungicides like myclobutanil. Remove nearby juniper trees or prune galls from them.",
        "Apple___healthy" => "No treatment needed. Maintain good orchard hygiene.",
        "Corn_(maize)___Cercospora_leaf_spot Gray_leaf_spot" => "Apply fungicides like azoxystrobin or pyraclostrobin. Practice crop rotation and resistant hybrids.",
        "Corn_(maize)___Common_rust_" => "Use resistant hybrids and apply fungicides such as mancozeb if infection is severe.",
        "Corn_(maize)___healthy" => "No treatment needed. Maintain proper field sanitation.",
        "Corn_(maize)___Northern_Leaf_Blight" => "Apply fungicides like propiconazole or trifloxystrobin. Use resistant hybrids and rotate crops.",
        "Grape___Black_rot" => "Use fungicides like myclobutanil or mancozeb during early growth. Remove infected fruit and prune diseased vines.",
        "Grape___Esca_(Black_Measles)" => "Remove infected vines. Avoid pruning during wet conditions. No effective chemical control exists.",
        "Grape___Leaf_blight_(Isariopsis_Leaf_Spot)" => "Use copper-based fungicides. Remove infected leaves and improve air circulation.",
        "Grape___healthy" => "No treatment needed. Practice regular monitoring and pruning.",
        "Peach___Bacterial_spot" => "Apply copper-based sprays during dormant season. Use resistant varieties and avoid overhead irrigation.",
        "Peach___healthy" => "No treatment needed. Maintain good orchard hygiene.",
        "Potato___Early_blight" => "Use fungicides like chlorothalonil or mancozeb. Rotate crops and remove infected debris.",
        "Potato___Late_blight" => "Apply systemic fungicides like metalaxyl. Remove infected plants immediately and avoid overhead watering.",
        "Potato___healthy" => "No treatment needed. Practice crop rotation and clean cultivation.",
        "Strawberry___Leaf_scorch" => "Use fungicides such as myclobutanil. Remove infected leaves and avoid overcrowding.",
        "Strawberry___healthy" => "No treatment needed. Ensure good air circulation and remove dead leaves.",
        "Tomato___Bacterial_spot" => "Use copper-based bactericides. Avoid working in wet plants and rotate crops.",
        "Tomato___Early_blight" => "Apply fungicides like chlorothalonil or mancozeb. Space plants well and rotate crops.",
        "Tomato___Late_blight" => "Use fungicides like metalaxyl or fluopicolide. Remove infected plants and avoid moisture accumulation.",
        "Tomato___Leaf_Mold" => "Apply fungicides like chlorothalonil. Ensure proper ventilation in greenhouses.",
        "Tomato___Septoria_leaf_spot" => "Use fungicides like mancozeb or copper sprays. Remove infected leaves and improve air circulation.",
        "Tomato___Spider_mites Two-spotted_spider_mite" => "Use miticides or insecticidal soap. Keep humidity high and remove heavily infested leaves.",
        "Tomato___Target_Spot" => "Apply fungicides like azoxystrobin. Remove infected plant debris.",
        "Tomato___Tomato_Yellow_Leaf_Curl_Virus" => "Remove infected plants. Control whiteflies using insecticidal soap or neem oil. Use resistant varieties.",
        "Tomato___Tomato_mosaic_virus" => "Remove infected plants. Disinfect tools. No chemical treatment available.",
        "Tomato___healthy" => "No treatment needed. Maintain proper spacing and monitor regularly."
    ];

    try {
        // Check if AI service is available
        $health = Http::timeout(5)->get('http://127.0.0.1:8001/');
        if (!$health->successful()) {
            return redirect()->route('detection.result')->withErrors(['msg' => 'AI service is unavailable.']);
        }

        // Send image to AI service
        $response = Http::timeout(60)
            ->attach('file', file_get_contents($image->getRealPath()), $image->getClientOriginalName())
            ->post('http://127.0.0.1:8001/detect');

        if ($response->successful()) {
            $result = $response->json();

            // Normalize predicted class name from AI to avoid mismatch (trim spaces)
            $predictedClass = trim($result['predicted_class'] ?? 'Unknown');

            // Lookup treatment locally using normalized key
            $treatment = $disease_treatments[$predictedClass] ?? 'No treatment information available';

            return redirect()->route('detection.result')->with([
                'disease' => $predictedClass,
                'confidence' => $result['confidence'] ?? null,
                'treatment' => $treatment,
                'uploaded_image_path' => $imagePath
            ]);
        } else {
            return redirect()->route('detection.result')->withErrors(['msg' => 'Analysis failed.']);
        }
    } catch (\Exception $e) {
        Log::error('Prediction error: ' . $e->getMessage());
        return redirect()->route('detection.result')->withErrors(['msg' => 'An error occurred.']);
    }
    }

    public function exportHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $histories = Auth::user()->detectionHistories()->get();
        
        $filename = 'plant_detection_history_' . now()->format('Y_m_d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($histories) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Date',
                'Disease Name',
                'Confidence (%)',
                'Detection Time',
            ]);

            foreach ($histories as $history) {
                fputcsv($file, [
                    $history->created_at->format('Y-m-d'),
                    $history->disease_name,
                    number_format($history->confidence * 100, 2),
                    $history->created_at->format('H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function showResult(Request $request)
    {
        $disease = session('disease');
        $confidence = session('confidence');
        $imagePath = session('uploaded_image_path'); // You'll need to store this in session during upload
        
        // Save to user's history if logged in and we have results
        if (Auth::check() && $disease && $confidence) {
            $this->saveToHistory($disease, $confidence, $imagePath);
        }

        return view('detection.result');
    }

    private function saveToHistory($disease, $confidence, $imagePath = null)
    {
        DetectionHistory::create([
            'user_id' => Auth::id(),
            'disease_name' => $disease,
            'confidence' => $confidence,
            'image_path' => $imagePath,
            'additional_data' => [
                'detection_date' => now()->toDateTimeString(),
                'user_agent' => request()->userAgent(),
            ]
        ]);
    }

    public function saveResult(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please log in to save results'], 401);
        }

        $disease = session('disease');
        $confidence = session('confidence');
        $imagePath = session('uploaded_image_path');

        if (!$disease || !$confidence) {
            return response()->json(['error' => 'No detection results to save'], 400);
        }

        try {
            $this->saveToHistory($disease, $confidence, $imagePath);
            return response()->json(['message' => 'Result saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save result'], 500);
        }
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $histories = Auth::user()->detectionHistories()->paginate(10);
        return view('detection.history', compact('histories'));
    }

    public function deleteHistory($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $history = DetectionHistory::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete associated image if exists
        if ($history->image_path && Storage::exists($history->image_path)) {
            Storage::delete($history->image_path);
        }
        
        $history->delete();
        
        return response()->json(['message' => 'History item deleted successfully']);
    }
}
