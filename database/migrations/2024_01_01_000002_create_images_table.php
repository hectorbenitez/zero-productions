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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('kind')->default('gallery'); // cover, gallery
            $table->string('mime_type'); // image/jpeg, image/png, image/webp
            $table->string('filename')->nullable();
            $table->integer('byte_size');
            $table->string('checksum')->nullable();
            $table->binary('data'); // bytea in PostgreSQL
            $table->string('caption')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(['event_id', 'kind']);
        });

        // Add foreign key for events.cover_image_id
        Schema::table('events', function (Blueprint $table) {
            $table->foreign('cover_image_id')->references('id')->on('images')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['cover_image_id']);
        });
        Schema::dropIfExists('images');
    }
};
