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
      Schema::create('repayments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('farmer_id')->constrained('farmers');
    $table->foreignId('operator_id')->constrained('users');
    $table->decimal('kg_received', 10, 3);
    $table->decimal('commodity_rate', 10, 2);
    $table->decimal('fcfa_value', 10, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};
