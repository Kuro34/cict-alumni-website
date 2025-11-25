<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('points', function (Blueprint $table) {
            $table->bigIncrements('pointID');
            $table->unsignedBigInteger('alumniID');
            $table->integer('total_points')->default(0);
            $table->timestamps();

            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('points');
    }
};

