<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_user_id');
            $table->string('user_id')->nullable();
            $table->string('spotify_id');
            $table->string('url');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('collaborative');
            $table->unsignedInteger('followers_total')->default(0);
            $table->unsignedInteger('tracks_total')->default(0);
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('spotify_user_id')->references('spotify_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlists', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['spotify_user_id']);
            }
        });

        Schema::dropIfExists('playlists');
    }
};
