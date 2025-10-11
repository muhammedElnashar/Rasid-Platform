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
        Schema::create('user_level_histories', function (Blueprint $table) {
            $table->id();
            $table->morphs('issued_to'); // user أو group
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('layer_id')->constrained('layers');
            $table->foreignId('level_id')->constrained('levels');
            $table->date('change_date');
            $table->boolean('notification_sent')->default(false);
            $table->boolean('is_upgrade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_level_histories');
    }
};
