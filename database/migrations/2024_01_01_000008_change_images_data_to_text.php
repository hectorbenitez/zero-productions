<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change data column from bytea to text for base64-encoded image storage.
     * This avoids PostgreSQL UTF-8 encoding issues with raw binary data via PDO.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE images ALTER COLUMN data TYPE text USING encode(data, \'base64\')');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE images ALTER COLUMN data TYPE bytea USING decode(data, \'base64\')');
    }
};
