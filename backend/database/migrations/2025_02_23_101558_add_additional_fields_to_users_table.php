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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropColumn('username');

            // Add new columns
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('role')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('national_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_contact')->nullable();
            $table->integer('no_of_children')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->dropColumn([
                'phone_number',
                'gender',
                'role',
                'nationality',
                'national_id',
                'date_of_birth',
                'address',
                'marital_status',
                'next_of_kin',
                'next_of_kin_contact',
                'no_of_children'
            ]);
            
            // Recreate the original role_id column and foreign key
            $table->string('role_id', 100)->nullable();
            $table->foreign('role_id')
                  ->references('role_id')
                  ->on('roles')
                  ->onUpdate('cascade');
        });
    }
};
