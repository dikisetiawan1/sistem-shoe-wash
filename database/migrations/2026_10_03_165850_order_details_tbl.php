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
         Schema::create('order_details_tbl', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('order_id')->constrained('orders_tbl')->onDelete('cascade');
            $table->foreignId('shoe_categories_id')->constrained('shoe_categories_tbl')->onDelete('cascade');
            $table->foreignId('services_id')->constrained('services_tbl')->onDelete('cascade');
            $table->string('brand', 100);
            $table->decimal('price', 10, 2);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
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
