<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::create('alumni_verifications', function (Blueprint $table) {
        $table->id('verificationID');
        $table->string('email'); // use email, NOT alumniID
        $table->string('otp');
        $table->timestamp('expires_at');
        $table->timestamps();
        
    });

}

};
