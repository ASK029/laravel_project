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
        Schema::create('meds', function (Blueprint $table) {
            $table->id();
            $table->string('scientific_name');
            $table->string('commercial_name')->unique();
            $table->string('category');
            $table->string('manufacturer_name');
            $table->float('price');
            $table->date('expiration_date');
            $table->integer('quantity_available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meds');
    }
};
