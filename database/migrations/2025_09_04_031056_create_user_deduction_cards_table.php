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
        Schema::create('user_deduction_cards', function (Blueprint $table) {
            $table->id();
            $table->morphs('issued_to'); // user أو group
            $table->foreignId('deduction_card_id')->constrained()->onDelete('cascade');
            $table->dateTime('applied_at')->nullable();
            $table->unsignedInteger('cycle_number')->default(1);
            $table->integer('negative_points_at_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_deduction_cards');
    }
};
