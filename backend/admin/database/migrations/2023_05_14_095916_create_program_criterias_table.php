<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_criterias', function (Blueprint $table) {
            $table->uuid();
            $table->foreignUuId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('name');
            $table->string('input_type');

            // Label
            $table->string('label')->nullable()->default(null);

            // Meta
            $table->json('meta')->nullable()->default(null);

            // Validation
            $table->json('pre_validation')->nullable()->default(null);
            $table->json('validation')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_criterias');
    }
};
