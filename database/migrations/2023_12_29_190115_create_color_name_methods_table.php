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
        Schema::create('color_name_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 15);
            $table->unsignedBigInteger('color_method_id');
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
        Schema::dropIfExists('color_name_methods');
    }
};
