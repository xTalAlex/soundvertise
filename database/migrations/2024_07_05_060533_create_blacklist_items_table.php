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
        Schema::create('blacklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('blacklistable');
            $table->timestamps();

            $table->unique(['user_id', 'blacklistable_id', 'blacklistable_type'], 'blacklist_items_user_id_blacklistable_id_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blacklist_items', function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
                $table->dropUnique('blacklist_items_user_id_blacklistable_id_type_unique');
            }
        });

        Schema::dropIfExists('blacklist_items');
    }
};
