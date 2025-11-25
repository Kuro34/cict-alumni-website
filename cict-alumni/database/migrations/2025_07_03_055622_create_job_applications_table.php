<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id('applicationID');
            $table->unsignedBigInteger('jobID');
            $table->unsignedBigInteger('alumniID');
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('jobID')->references('jobID')->on('job_postings')->onDelete('cascade');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_applications');
    }
};
