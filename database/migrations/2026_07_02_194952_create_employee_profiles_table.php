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
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number', 200);
            $table->date('date_of_birth');
            $table->string('gender', 100);
            $table->string('address_line_1', 255);
            $table->string('address_line_2', 255)->nullable();
            $table->string('city', 200);
            $table->string('state', 255);
            $table->string('pincode', 255);
            $table->string('country', 255);
            $table->string('profile_photo', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
