<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->bigIncrements('transactionID');
            $table->unsignedBigInteger('alumniID');
            $table->integer('change'); // positive = earn, negative = spend
            $table->string('reason')->nullable(); // e.g., "Completed survey"
            $table->timestamps();

            $table->foreign('alumniID')->references('alumniID')->on('alumni')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('point_transactions');
    }
};
