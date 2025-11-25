<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('surveys', function (Blueprint $table) {
            $table->bigIncrements('surveyID');
            $table->unsignedBigInteger('adminID');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('form_url'); // ✅ Google Form link
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('points')->default(0); // ✅ points alumni earn
            $table->timestamps();

            $table->foreign('adminID')->references('adminID')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('surveys');
    }
};
