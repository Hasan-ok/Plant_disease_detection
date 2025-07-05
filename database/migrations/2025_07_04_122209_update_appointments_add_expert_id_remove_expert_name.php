<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAppointmentsAddExpertIdRemoveExpertName extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('expert_id')->after('user_id');
            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade');
            $table->dropColumn('expert_name');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('expert_name')->after('email');
            $table->dropForeign(['expert_id']);
            $table->dropColumn('expert_id');
        });
    }
}
