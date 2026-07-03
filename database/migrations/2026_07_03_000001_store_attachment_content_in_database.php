<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspiration_attachments', function (Blueprint $table): void {
            $table->longText('content')->nullable()->after('size_bytes');
        });
    }

    public function down(): void
    {
        Schema::table('aspiration_attachments', function (Blueprint $table): void {
            $table->dropColumn('content');
        });
    }
};
