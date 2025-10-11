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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('fixed_points')->default(0);
            $table->integer('flexible_points')->default(0);
            $table->integer('current_negative_points')->default(0);
            $table->unsignedInteger('current_cycle')->default(1);
            $table->string('settlement_code')->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('leader_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('group_categories')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
