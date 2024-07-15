<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('current_team_id', function (Blueprint $table) {
                $table->string('spotify_id')->unique()->nullable();
                $table->string('spotify_name')->nullable();
                $table->text('spotify_avatar')->nullable();
                $table->unsignedInteger('spotify_playlists_total')->nullable();
                $table->unsignedInteger('spotify_filtered_playlists_total')->nullable();
                $table->string('spotify_access_token')->nullable();
                $table->string('spotify_refresh_token')->nullable();
                $table->datetime('spotify_token_expiration')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['spotify_id']);
            $table->dropColumn([
                'spotify_id',
                'spotify_avatar',
                'spotify_access_token',
                'spotify_refresh_token',
                'spotify_token_expiration',
            ]);
        });
    }
};
