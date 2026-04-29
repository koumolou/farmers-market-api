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
       Schema::create('debts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('farmer_id')->constrained('farmers');
    $table->foreignId('transaction_id')->constrained('transactions');
    $table->decimal('original_amount', 10, 2);
    $table->decimal('remaining_amount', 10, 2);
    $table->enum('status', ['open', 'partial', 'settled'])->default('open');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
