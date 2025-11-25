<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notificationID');
            $table->unsignedBigInteger('alumniID')->nullable();
            $table->unsignedBigInteger('adminID')->nullable();
            $table->string('type'); // Example: event, job, survey
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
            $table->foreign('adminID')->references('adminID')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};

