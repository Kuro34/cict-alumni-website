<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->bigIncrements('jobID');
            $table->unsignedBigInteger('adminID');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('company')->nullable();

            // 🔹 New column for IT job category
            $table->string('category')->nullable(); 
            // Example: "Software Developer", "UI/UX Designer", etc.

            $table->timestamps();

            $table->foreign('adminID')->references('adminID')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_postings');
    }
};
