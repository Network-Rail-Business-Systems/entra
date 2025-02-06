<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->rememberToken();
            $table->timestamps();

            $table->string('azure_id');
            $table->string('business_phone');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_phone');
            $table->string('name');
            $table->string('office');
            $table->string('title');
            $table->string('username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
