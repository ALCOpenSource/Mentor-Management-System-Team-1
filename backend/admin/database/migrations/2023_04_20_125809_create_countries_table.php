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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->index();
            $table->string('capital')->nullable();
            $table->string('region')->nullable();
            $table->string('subregion')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('phone_code')->nullable();
            $table->json('timezones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
