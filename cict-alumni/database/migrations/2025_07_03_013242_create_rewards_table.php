<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        Schema::create('rewards', function (Blueprint $table) {
            $table->bigIncrements('rewardID');
            $table->string('name');
            $table->string('description');
            $table->integer('point_cost');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rewards');
    }
};
