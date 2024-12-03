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
            $table->unsignedBigInteger('service_id'); // Correct foreign key type
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade'); // Foreign key constraint
            $table->integer('baskets');
            $table->string('address');
            $table->integer('postal_code');
            $table->text('notes')->nullable();
            $table->enum('payment_mode', ['cash', 'credit_card', 'paypal']);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
