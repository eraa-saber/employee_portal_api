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
    Schema::table('users', function (Blueprint $table) {
        $table->string('FullName')->nullable();
        $table->string('Phone')->nullable();
        $table->integer('NationalID')->nullable();
        $table->string('DocURL')->nullable();
        $table->boolean('EmailNotifications')->default(false);
        $table->integer('insuranceNo')->nullable();
        $table->boolean('TermsAndConditions')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'FullName',
                'Phone',
                'NationalID',
                'DocURL',
                'EmailNotifications',
                'insuranceNo',
                'TermsAndConditions'
            ]);
        });
    }
};
