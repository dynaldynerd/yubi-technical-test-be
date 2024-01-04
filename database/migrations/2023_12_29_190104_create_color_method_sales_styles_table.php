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
        Schema::create('color_method_sales_styles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_style_id');
            $table->unsignedBigInteger('color_method_id');
            $table->foreign('sales_style_id')->references('id')->on('sales_styles')->onDelete('cascade');
            $table->foreign('color_method_id')->references('id')->on('color_methods')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_method_sales_styles');
    }
};
