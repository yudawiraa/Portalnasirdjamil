<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirations', function (Blueprint $table): void {
            $table->string('priority', 30)->default('normal')->after('status')->index();
            $table->string('assigned_to', 150)->nullable()->after('priority');
            $table->text('verification_result')->nullable()->after('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table): void {
            $table->dropColumn(['priority', 'assigned_to', 'verification_result']);
        });
    }
};
