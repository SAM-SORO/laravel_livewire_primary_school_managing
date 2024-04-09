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
        Schema::create('inscrires', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');

            $table->enum('etatAffectation', [0, 1])->default(0);

            // Nouvelle colonne pour l'état de l'inscription
            $table->enum('etatInscription', [0, 1])->default(0);

            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels');

            $table->unsignedBigInteger('schoolYear_id');
            $table->foreign('schoolYear_id')->references('id')->on('school_years');

            // Nouvelle colonne pour le montant de l'inscription
            $table->integer('montant');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscrires');
    }
};
