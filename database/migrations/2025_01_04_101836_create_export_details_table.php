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
        Schema::create('export_details', function (Blueprint $table) {
            $table->string('export');
            $table->string('item');
            $table->integer('quantity');
            $table->primary(['export', 'item']);
            $table->foreign('export')->references('id')->on('exports')->onDelete('cascade');
            $table->foreign('item')->references('item')->on('stocks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_details');
    }
};
