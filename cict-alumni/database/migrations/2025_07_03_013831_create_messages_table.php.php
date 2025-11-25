<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('messageID');
            $table->unsignedBigInteger('sender_adminID')->nullable();
            $table->unsignedBigInteger('sender_alumniID')->nullable();
            $table->unsignedBigInteger('recipient_adminID')->nullable();
            $table->unsignedBigInteger('recipient_alumniID')->nullable();
            $table->text('message');
            $table->timestamps();

            $table->foreign('sender_adminID')->references('adminID')->on('admins')->onDelete('cascade');
            $table->foreign('sender_alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
            $table->foreign('recipient_adminID')->references('adminID')->on('admins')->onDelete('cascade');
            $table->foreign('recipient_alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};

