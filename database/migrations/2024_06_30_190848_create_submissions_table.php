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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('song_id');
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedSmallInteger('level')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('song_id')->references('id')->on('songs');
            $table->foreign('playlist_id')->references('id')->on('playlists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['song_id']);
                $table->dropForeign(['playlist_id']);
            }
        });

        Schema::dropIfExists('submissions');
    }
};
