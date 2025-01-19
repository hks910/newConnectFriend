<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
    //  */
    // 'sender_id',
    // 'receiver_id',
    // 'status'
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');  // User who sent the friend request
            $table->unsignedBigInteger('receiver_id'); // User who received the friend request
            $table->enum('status', ['Pending', 'Declined', 'Accepted'])->default('Pending'); // Status of the friend request
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');

            // Optional: Ensure that each relationship can only be represented once
            $table->unique(['sender_id', 'receiver_id'], 'unique_friendships');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
