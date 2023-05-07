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
            $table->longtext('message')->nullable();
            $table->string('status')->default('unread');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('type')->default('text');
            $table->uuid('room_id')->index();
            $table->uuid('broadcast_id')->index()->nullable();
            $table->boolean('soft_deleted_sender')->default(false);
            $table->boolean('soft_deleted_receiver')->default(false);
            $table->boolean('forwarded')->default(false);

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
