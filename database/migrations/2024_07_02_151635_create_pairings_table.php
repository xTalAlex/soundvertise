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
        Schema::create('pairings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained();
            $table->foreignId('paired_submission_id')->constrained('submissions');
            $table->boolean('is_match')->nullable();
            $table->boolean('accepted')->nullable();
            $table->datetime('answered_at')->nullable();
            $table->datetime('submission_song_added_at')->nullable();
            $table->datetime('submission_song_removed_at')->nullable();
            $table->timestamps();

            $table->unique(['submission_id', 'paired_submission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pairings', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['submission_id']);
                $table->dropForeign(['paired_submission_id']);
            }
        });

        Schema::dropIfExists('pairings');
    }
};
