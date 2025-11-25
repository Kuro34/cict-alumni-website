<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jobID');
            $table->unsignedBigInteger('alumniID');
            $table->timestamps();

            $table->foreign('jobID')->references('jobID')->on('job_postings')->onDelete('cascade');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
            $table->unique(['jobID', 'alumniID']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_bookmarks');
    }
};
