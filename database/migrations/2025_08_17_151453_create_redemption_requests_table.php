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
        Schema::create('redemption_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->morphs('issued_to'); // user أو group
            $table->foreignId('item_id')->constrained('store_items')->onDelete('cascade');
            $table->dateTime('request_date');
            $table->string('status')->default('pending');
            $table->string('delivery_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemption_requests');
    }
};
