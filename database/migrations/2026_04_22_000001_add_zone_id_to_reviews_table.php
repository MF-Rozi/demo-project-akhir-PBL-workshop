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
        if (! Schema::hasTable('reviews')) {
            return;
        }

        if (Schema::hasColumn('reviews', 'reviewable_type') && Schema::hasColumn('reviews', 'reviewable_id')) {
            return;
        }

        if (! Schema::hasColumn('reviews', 'attraction_id')) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->nullableMorphs('reviewable');
        });

        DB::table('reviews')
            ->whereNotNull('attraction_id')
            ->update([
                'reviewable_type' => 'App\\Models\\Attraction',
                'reviewable_id' => DB::raw('attraction_id'),
            ]);

        if (Schema::hasColumn('reviews', 'zone_id')) {
            DB::table('reviews')
                ->whereNull('reviewable_id')
                ->whereNotNull('zone_id')
                ->update([
                    'reviewable_type' => 'App\\Models\\Zone',
                    'reviewable_id' => DB::raw('zone_id'),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('reviews')) {
            return;
        }

        if (! Schema::hasColumn('reviews', 'attraction_id')) {
            return;
        }

        if (! Schema::hasColumn('reviews', 'reviewable_type') || ! Schema::hasColumn('reviews', 'reviewable_id')) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropMorphs('reviewable');
        });
    }
};
