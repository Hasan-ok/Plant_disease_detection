<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\DetectionHistory;

class DetectionResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_sees_detection_result_and_it_gets_saved_to_history()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $sessionData = [
            'disease' => 'Apple Scab',
            'confidence' => 0.92,
            'uploaded_image_path' => 'tree_images/sample.jpg',
        ];

        $response = $this->withSession($sessionData)
                         ->get(route('detection.result'));

        $response->assertStatus(200);
        $response->assertSeeText('Apple Scab');
        $response->assertSeeText('92.0%');
        $this->assertDatabaseHas('detection_histories', [
            'user_id' => $user->id,
            'disease_name' => 'Apple Scab',
        ]);
    }

    public function test_guest_user_sees_detection_result_but_not_saved()
    {
        $sessionData = [
            'disease' => 'Powdery Mildew',
            'confidence' => 0.65,
        ];

        $response = $this->withSession($sessionData)
                         ->get(route('detection.result'));

        $response->assertStatus(200);
        $response->assertSeeText('Powdery Mildew');
        $this->assertDatabaseCount('detection_histories', 0);
    }

}