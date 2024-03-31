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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idBat');
            $table->unsignedBigInteger('idLevel');
            $table->unsignedBigInteger('schoolYear_id');
            $table->foreign('idBat')->references('id')->on('batiments')->onDelete('cascade');
            $table->foreign('idLevel')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('schoolYear_id')->references('id')->on('school_years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
