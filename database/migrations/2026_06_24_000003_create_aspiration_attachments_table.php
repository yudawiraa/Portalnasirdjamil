<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspiration_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspiration_id')->constrained('aspirations')->cascadeOnDelete();
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type', 120);
            $table->unsignedBigInteger('size_bytes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspiration_attachments');
    }
};
