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
        Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->string('Number_beneficiaries');
        $table->enum('category', ['clothes', 'furniture', 'books', 'other']);
        $table->string('city');
        $table->string('state');
        $table->string('phoen');
        $table->string('backup_number')->nullable();
        $table->enum('status', ['available', 'reserved', 'donated'])->default('available');
        $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('rejection_reason')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
