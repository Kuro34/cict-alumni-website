<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('point_redemptions', function (Blueprint $table) {
            $table->bigIncrements('redemptionID');
            $table->unsignedBigInteger('alumniID');
            $table->unsignedBigInteger('rewardID');
            $table->integer('points_used');
            $table->string('reward_description');

            $table->timestamps();

            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
            $table->foreign('rewardID')->references('rewardID')->on('rewards')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('point_redemptions');
    }
};

