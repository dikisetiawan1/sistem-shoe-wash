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
        Schema::create('services_tbl', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name',100);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('estimated_days');
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
