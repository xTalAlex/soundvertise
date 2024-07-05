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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('genre_id')->nullable()->constrained();
            $table->string('spotify_id');
            $table->string('url')->nullable();
            $table->string('name');
            $table->string('artist_id')->nullable();
            $table->string('artist_name')->nullable();
            $table->string('artist_genres')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->unsignedInteger('popularity')->default(0);
            $table->float('acousticness')->nullable();
            $table->float('instrumentalness')->nullable();
            $table->float('speechiness')->nullable();
            $table->float('danceability')->nullable();
            $table->float('energy')->nullable();
            $table->float('valence')->nullable();
            $table->float('liveness')->nullable();
            $table->float('loudness')->nullable();
            $table->boolean('mode')->nullable();
            $table->integer('key')->nullable();
            $table->float('tempo')->nullable();
            $table->unsignedSmallInteger('time_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['genre_id']);
                $table->dropForeign(['user_id']);
            }
        });

        Schema::dropIfExists('songs');
    }
};
