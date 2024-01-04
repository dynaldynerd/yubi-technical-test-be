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
        Schema::create('color_name_sales_styles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colormethod_sales_id');
            $table->unsignedBigInteger('color_name_id');
            $table->integer('qty');
            $table->foreign('colormethod_sales_id')->references('id')->on('color_method_sales_styles')->onDelete('cascade');
            $table->foreign('color_name_id')->references('id')->on('color_name_methods')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_name_sales_styles');
    }
};
