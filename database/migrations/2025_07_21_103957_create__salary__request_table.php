<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('salary_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('request_id')->primary(); // Primary Key
            $table->unsignedBigInteger('user_id');               // Foreign Key to users.id
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
            $table->string('status');
            $table->unsignedBigInteger('voucher_no');
            $table->timestamps(); // created_at and updated_at

            // Define foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_salary__request');
    }
};
