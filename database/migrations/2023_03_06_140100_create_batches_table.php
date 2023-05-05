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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('batchNo');
            $table->integer('cycle');
            $table->date('dateStarted');
            $table->date('endDate')->nullable();
            $table->integer('total_expenses')->nullable();
            $table->integer('totalDays')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
