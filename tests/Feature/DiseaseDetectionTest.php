<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class DiseaseDetectionTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_upload_image_and_get_disease_prediction()
    {
        Storage::fake('public');
        $this->withoutExceptionHandling();

        Http::fake([
            'http://127.0.0.1:8001/' => Http::response('OK', 200),
            'http://127.0.0.1:8001/detect' => Http::response([
                'predicted_class' => 'Tomato___Early_blight',
                'confidence' => 0.95,
            ], 200),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $image = UploadedFile::fake()->image('leaf.jpg');

        $response = $this->post('/detect', [
            'image' => $image,
        ]);

        $response->assertRedirect(route('detection.result'));

        $response->assertSessionHas([
            'disease' => 'Tomato___Early_blight',
            'confidence' => 0.95,
            'treatment' => 'Apply fungicides like chlorothalonil or mancozeb. Space plants well and rotate crops.',
        ]);

        Storage::disk('public')->assertExists('uploads/' . $image->hashName());
    }

    public function test_image_is_required_for_detection()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/detect', []);

        $response->assertSessionHasErrors(['image']);
    }
}