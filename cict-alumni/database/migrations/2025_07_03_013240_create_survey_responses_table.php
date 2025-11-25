<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->bigIncrements('responseID');
            $table->unsignedBigInteger('surveyID');
            $table->unsignedBigInteger('alumniID');
            $table->boolean('completed')->default(false); 
            $table->timestamp('completed_at')->nullable(); 
            $table->integer('points_earned')->default(0); // ✅ for tracking awarded points
            $table->timestamps();

            $table->foreign('surveyID')->references('surveyID')->on('surveys')->onDelete('cascade');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');

            $table->unique(['surveyID', 'alumniID']); // ✅ prevents duplicates
        });
    }

    public function down(): void {
        Schema::dropIfExists('survey_responses');
    }
};
