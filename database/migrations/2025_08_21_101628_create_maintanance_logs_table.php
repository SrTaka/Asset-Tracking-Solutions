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
        Schema::create('maintanance_logs', function (Blueprint $table) {
            $table->id();
            $table->char('asset_id', 8);
            $table->string('requested_by');
            $table->string('technician');
            $table->text('notes');
            $table->date('maintenance_date');
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void   
    {
        Schema::dropIfExists('maintanance_logs');
    }
};
