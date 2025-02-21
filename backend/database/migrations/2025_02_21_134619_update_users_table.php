<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add username column after id
            $table->string('username')->unique()->after('id');
            
            // Add role_id column to reference roles table
            $table->string('role_id', 100)->nullable()->after('email');
            
            // Add foreign key constraint
            $table->foreign('role_id')
                  ->references('role_id')
                  ->on('roles')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        // Generate default usernames for existing users based on email
        DB::table('users')->get()->each(function ($user) {
            $username = explode('@', $user->email)[0];
            // Add number suffix if username already exists
            $counter = 1;
            $originalUsername = $username;
            while (DB::table('users')->where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove foreign key constraint
            $table->dropForeign(['role_id']);
            
            // Remove columns
            $table->dropColumn(['role_id', 'username']);
        });
    }
};