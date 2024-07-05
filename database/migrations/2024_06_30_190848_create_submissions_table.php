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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('song_id')->constrained();
            $table->foreignId('playlist_id')->constrained();
            $table->unsignedInteger('song_popularity_before')->nullable();
            $table->unsignedInteger('song_popularity_after')->nullable();
            $table->unsignedInteger('min_monthly_listeners')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
