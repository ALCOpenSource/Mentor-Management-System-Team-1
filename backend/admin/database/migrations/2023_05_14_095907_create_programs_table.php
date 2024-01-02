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
        Schema::create('programs', function (Blueprint $table) {
            $table->uuid();
            $table->string('name');
            $table->longText('description')->nullable()->default(null);
            $table->foreignIdFor(User::class, 'created_by')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
