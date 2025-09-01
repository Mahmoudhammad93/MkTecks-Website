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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('header_message_ar')->nullable();
            $table->string('header_message_en')->nullable();
            $table->string('header_title_ar')->nullable();
            $table->string('header_title_en')->nullable();
            $table->string('header_description_ar')->nullable();
            $table->string('header_description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
