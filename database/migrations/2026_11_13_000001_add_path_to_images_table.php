<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Images move to object storage: `path` is the object key on the images disk.
     * `data` (base64) stays as a fallback for rows not copied yet, so it becomes nullable.
     */
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('path')->nullable()->after('checksum');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->text('data')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
};
