<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name', 150);
            $table->string('nik', 16)->nullable();
            $table->string('whatsapp', 30);
            $table->string('email', 150)->nullable();
            $table->string('city', 100);
            $table->string('district_village', 150)->nullable();
            $table->foreignId('category_id')->constrained('aspirasi_categories');
            $table->string('title', 200);
            $table->text('body');
            $table->string('status', 40)->default('received')->index();
            $table->text('public_response')->nullable();
            $table->text('internal_note')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['code', 'whatsapp']);
            $table->index(['city', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirations');
    }
};
