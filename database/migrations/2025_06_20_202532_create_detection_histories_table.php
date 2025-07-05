<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetectionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('detection_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('disease_name');
            $table->decimal('confidence', 5, 4); // e.g., 0.9876
            $table->string('image_path')->nullable(); // Store image if needed
            $table->json('additional_data')->nullable(); // For any extra detection data
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detection_histories');
    }
}