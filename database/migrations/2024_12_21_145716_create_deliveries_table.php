<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('courier_id');
            $table->foreign('courier_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('outDate');
            $table->date('returnDate')->nullable();
            $table->decimal('cost', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
}
