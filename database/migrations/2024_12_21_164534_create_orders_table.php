<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade'); 
            $table->unsignedBigInteger('product_id'); 
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); 
            $table->integer('baskets');
            $table->string('address');
            $table->integer('postal_code');
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('payment_mode', ['cash', 'credit_card', 'paypal']);
            $table->decimal('total_price', 8, 2);
            $table->enum('status', [ 'pending', 'confirmed', 'in_progress', 'ready_for_pickup', 'out_for_delivery', 'delivered', 'completed', 'cancelled', 'on_hold', 'failed' ])->default('pending');
            $table->date('out_date')->nullable();
            $table->date('return_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
