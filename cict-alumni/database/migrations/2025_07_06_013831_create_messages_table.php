<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');

            $table->unsignedBigInteger('sender_id');  // single ID for sender
            $table->unsignedBigInteger('recipient_id'); // single ID for recipient

            $table->text('message');
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};
