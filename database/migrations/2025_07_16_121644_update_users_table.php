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
        // All columns in this migration already exist in the users table.
        // This migration is now empty to avoid duplicate column errors.
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
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
