<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ms_graph_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email')->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->string('expires');
            $table->timestamps();

            $table->foreign('user_id', 'fk_token_user')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ms_graph_tokens', function (Blueprint $table) {
            $table->dropForeign('fk_token_user');
        });

        Schema::dropIfExists('ms_graph_tokens');
    }
};
