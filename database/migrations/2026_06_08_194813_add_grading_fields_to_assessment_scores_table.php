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
        Schema::table('assessment_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('assessment_scores', 'maximum_score')) {
                $table->decimal('maximum_score', 5, 2)->default(100.00)->after('score');
            }
            if (!Schema::hasColumn('assessment_scores', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('maximum_score');
            }
            if (!Schema::hasColumn('assessment_scores', 'graded_by')) {
                $table->unsignedBigInteger('graded_by')->nullable()->after('is_published');
                $table->foreign('graded_by')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('assessment_scores', 'graded_at')) {
                $table->timestamp('graded_at')->nullable()->after('graded_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_scores', function (Blueprint $table) {
            $table->dropForeign(['graded_by']);
            $table->dropColumn(['maximum_score', 'is_published', 'graded_by', 'graded_at']);
        });
    }
};
