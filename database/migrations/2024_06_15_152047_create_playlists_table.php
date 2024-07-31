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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('genre_id')->nullable()->constrained();
            $table->string('spotify_user_id');
            $table->string('spotify_id');
            $table->string('url')->nullable();
            $table->string('name');
            $table->string('cover_image')->nullable();
            $table->string('description')->nullable();
            $table->boolean('collaborative')->default(false);
            $table->unsignedInteger('followers_total')->default(0);
            $table->unsignedInteger('tracks_total')->default(0);
            $table->boolean('approved')->default(false);
            $table->datetime('reviewed_at')->nullable();
            $table->unsignedInteger('monthly_listeners')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlists', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['genre_id']);
                $table->dropForeign(['user_id']);
            }
        });

        Schema::dropIfExists('playlists');
    }
};
