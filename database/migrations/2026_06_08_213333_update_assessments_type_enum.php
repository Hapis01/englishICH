<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE assessments MODIFY COLUMN type ENUM('Assignment','Quiz','Mid Test','Final Test','Speaking Test','Speaking','Reading','Listening','Writing','Custom Assessment') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE assessments MODIFY COLUMN type ENUM('Assignment','Quiz','Mid Test','Final Test','Speaking Test','Custom Assessment') NOT NULL");
    }
};
