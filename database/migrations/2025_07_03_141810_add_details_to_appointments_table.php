<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('tree_type');
            $table->string('issue');
            $table->string('disease')->nullable();
            $table->text('user_treatment')->nullable();
            $table->string('tree_image')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'tree_type',
                'issue',
                'disease',
                'user_treatment',
                'tree_image',
            ]);
        });
    }

};
