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
        Schema::create('behavior_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools');
            $table->morphs('issued_to'); // user أو group
            $table->foreignId('issuer_by')->constrained('users');
            $table->foreignId('card_item_id')->constrained('card_items')->onDelete('cascade');
            $table->string('issue_number', 12)->unique();
            $table->integer('points_value');
            $table->boolean('active')->default(true);
            $table->dateTime('log_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_logs');
    }
};
