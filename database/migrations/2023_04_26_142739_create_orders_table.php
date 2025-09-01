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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->index();
            $table->double('delivery',8,3)->default(0);
            $table->double('discount',8,3)->default(0);
            $table->double('total',8,3)->default(0);
            $table->enum('order_type',['online','table','casher']);
            $table->enum('payment_method',['credit','cash'])->default("credit")->index();
            $table->enum('status',['pending','paid','unpaid'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
