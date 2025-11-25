<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumni', function (Blueprint $table) {
            $table->bigIncrements('alumniID');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_initial')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable(); // ✅ Added gender
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('current_job')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->string('degree_program')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->string('banner_picture')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumni');
    }
};
