<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQualificationAndStatusToExpertsTable extends Migration
{
    public function up()
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->string('qualification')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->after('qualification');
        });
    }

    public function down()
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn(['qualification', 'status']);
        });
    }
}
