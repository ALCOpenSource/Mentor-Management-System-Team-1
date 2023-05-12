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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('type');
            $table->string('name');
            $table->string('size');
            $table->string('path');
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('thumbnail_size')->nullable();

            // Attachments, morphs to Attachment model
            $table->uuidMorphs('attachment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
