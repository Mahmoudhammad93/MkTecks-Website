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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable();
            $table->string('model');
            $table->bigInteger('model_id');
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('content_ar');
            $table->string('content_en');
            $table->boolean('is_notify')->default(0);
            $table->boolean('is_admin_notify')->default(0);
            $table->dateTime('read_at')->nullable();
            $table->dateTime('admin_read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
