<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->bigIncrements('registrationID');
            $table->unsignedBigInteger('eventID');
            $table->unsignedBigInteger('alumniID');
            $table->timestamps();

            $table->foreign('eventID')->references('eventID')->on('events')->onDelete('cascade');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('event_registrations');
    }
};
