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
        Schema::table('assignments', function (Blueprint $table) {
            // Use raw queries to detect and drop foreign key only if it exists
            $connection = Schema::getConnection();
            $schema = $connection->getDatabaseName();

            $fkExists = $connection->selectOne(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'assignments' AND COLUMN_NAME = 'asset_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1",
                [$schema]
            );

            if ($fkExists) {
                // Determine the FK name to drop
                $constraint = $connection->selectOne(
                    "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'assignments' AND COLUMN_NAME = 'asset_id' AND REFERENCED_TABLE_NAME = 'assets' LIMIT 1",
                    [$schema]
                );
                if ($constraint && isset($constraint->CONSTRAINT_NAME)) {
                    $fkName = $constraint->CONSTRAINT_NAME;
                    $connection->statement("ALTER TABLE `assignments` DROP FOREIGN KEY `{$fkName}`");
                }
            }

            // Without doctrine/dbal, easiest is drop and recreate column only when present
            if (Schema::hasColumn('assignments', 'asset_id')) {
                $connection->statement('ALTER TABLE `assignments` DROP COLUMN `asset_id`');
            }

            // Recreate as CHAR(8) to match assets.id
            $table->char('asset_id', 8);
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $connection = Schema::getConnection();
            $schema = $connection->getDatabaseName();
            $constraint = $connection->selectOne(
                "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'assignments' AND COLUMN_NAME = 'asset_id' AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1",
                [$schema]
            );
            if ($constraint && isset($constraint->CONSTRAINT_NAME)) {
                $fkName = $constraint->CONSTRAINT_NAME;
                $connection->statement("ALTER TABLE `assignments` DROP FOREIGN KEY `{$fkName}`");
            }

            if (Schema::hasColumn('assignments', 'asset_id')) {
                $connection->statement('ALTER TABLE `assignments` DROP COLUMN `asset_id`');
            }

            $table->unsignedBigInteger('asset_id');
        });
    }
};


