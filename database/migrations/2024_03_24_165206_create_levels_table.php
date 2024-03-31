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
        Schema::table('levels', function (Blueprint $table) {
            //
            Schema::create('levels', function (Blueprint $table) {
                $table->id();
                $table->string('libele'); // fait allusion a la classe
                $table->integer('scolarite'); //montant de scolarite
                $table->unsignedBigInteger('schoolYear_id');
                $table->foreign('schoolYear_id')->references('id')->on('school_years');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            //
        });
    }
};
