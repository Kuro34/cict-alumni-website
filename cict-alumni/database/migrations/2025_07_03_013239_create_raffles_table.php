<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('raffles', function (Blueprint $table) {
            $table->bigIncrements('raffleID');
            $table->unsignedBigInteger('adminID');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('adminID')->references('adminID')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('raffles');
    }
};
