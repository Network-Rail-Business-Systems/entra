<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entra_tokens', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->string('expires');

            $table->foreign('user_id', 'fk_entra_token_user')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entra_tokens');
    }
};
