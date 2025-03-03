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
        Schema::create('babies', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('guardian_id')->constrained('users')->onDelete('cascade');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('immunization_status', ['Up to date', 'Pending', 'Overdue'])->default('Pending');
            $table->string('last_vaccine_received')->nullable();
            $table->date('next_appointment_date')->nullable();
            $table->date('date_of_birth');
            $table->string('nationality')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('babies');
    }
};
