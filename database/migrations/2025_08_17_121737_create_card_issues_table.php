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
        Schema::create('card_issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_number', 12)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('card_item_id')->constrained('card_items')->onDelete('cascade');
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->integer('points');
            $table->integer('remaining_points')->nullable();
            $table->string('deduction_type')->nullable(); //
            $table->date('issue_date')->nullable();
            $table->integer('deduction_duration_days')->nullable();
            $table->date('deduction_deadline')->nullable();
            $table->dateTime('applied_at')->nullable();
            $table->string('status'); // approved,pending,rejected

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_issues');
    }
};
