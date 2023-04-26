<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            // In app messages
            $table->uuid()->index();
            $table->foreignIdFor(User::class, 'sender_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('status')->default('unread');
            $table->string('type')->default('text');

            // Attachments, morphs to Attachment model
            $table->morphs('attachment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
