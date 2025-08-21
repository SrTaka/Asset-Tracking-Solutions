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
        Schema::create('assets', function (Blueprint $table) {
            $table->char('id', 8)->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();           
            $table->integer('category_id');
            $table->date('purchase_date');
            $table->decimal('purchase_price', 10, 2);
            $table->text('qr_code_data')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('asset_image_path')->nullable();
            $table->timestamp('qr_code_generated_at')->nullable();
            $table->timestamps(); // creates created_at and updated_at
            $table->foreign('category_id')->references('id')->on('asset_categories')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
