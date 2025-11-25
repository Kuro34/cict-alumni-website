<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('raffle_entries', function (Blueprint $table) {
            $table->bigIncrements('entryID');
            $table->unsignedBigInteger('raffleID');
            $table->unsignedBigInteger('alumniID');
            $table->timestamps();

            $table->foreign('raffleID')->references('raffleID')->on('raffles')->onDelete('cascade');
            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('raffle_entries');
    }
};
