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
        Schema::create('transfers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('from_warehouse');
            $table->string('to_warehouse');
            $table->date('date');
            $table->foreign('from_warehouse')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('to_warehouse')->references('id')->on('warehouses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
