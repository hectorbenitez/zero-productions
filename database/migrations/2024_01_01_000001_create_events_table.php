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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('event_datetime');
            $table->string('status')->default('draft'); // draft, published
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('event_datetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
