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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->morphs('report');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->longText('details')->nullable();
            $table->string('type')->default('text');

            $table->timestamps();
        });

        Schema::table('reports', function (Blueprint $table) {
            // Alter the report_id to enable it to be nullable
            $table->unsignedBigInteger('report_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
