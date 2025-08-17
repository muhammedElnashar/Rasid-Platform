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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('card_number', 12)->unique(); // CA + 10 digits
            $table->string('kind');
            $table->string('category')->nullable();
            $table->integer('points_value'); // إيجابي/سلبي
            $table->date('issue_date');
            $table->foreignId('issuer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('target_id')->constrained('users')->onDelete('cascade');
            $table->enum('payment_type', ['mandatory', 'optional'])->nullable();
            $table->date('deadline')->nullable();
            $table->enum('restriction_status', ['restricted', 'unrestricted'])->default('unrestricted');
            $table->boolean('notification_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
