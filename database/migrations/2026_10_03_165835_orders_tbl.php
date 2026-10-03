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
           Schema::create('orders_tbl', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('order_number')->unique();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customers_id')->constrained('customers_tbl');
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'transfer'])->default('cash');
            $table->datetime('entry_date')->nullable();
            $table->datetime('estimated_completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
