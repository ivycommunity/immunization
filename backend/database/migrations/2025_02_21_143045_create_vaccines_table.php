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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('vaccine_name');
            $table->text('description')->nullable();
            $table->string('disease_prevented');
            $table->string('recommended_age');
            $table->string('dosage');
            $table->enum('administration_method', ['Oral', 'Injection', 'Nasal Spray']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
