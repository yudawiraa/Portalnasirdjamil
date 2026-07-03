<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $this->renameCategory('Keamanan & Ketertiban', 'Kepolisian & Ketertiban Umum');

        $newName = 'Hak Warga dalam Proses Hukum';
        $newSlug = Str::slug($newName);

        $legacy = DB::table('aspirasi_categories')
            ->where('slug', 'hak-asasi-manusia-ham')
            ->orWhere('name', 'Hak Asasi Manusia (HAM)')
            ->first();

        if ($legacy === null) {
            return;
        }

        $target = DB::table('aspirasi_categories')->where('slug', $newSlug)->first();

        if ($target !== null && $target->id !== $legacy->id) {
            DB::table('aspirations')->where('category_id', $legacy->id)->update(['category_id' => $target->id]);
            DB::table('aspirasi_categories')->where('id', $legacy->id)->delete();

            return;
        }

        DB::table('aspirasi_categories')->where('id', $legacy->id)->update([
            'name' => $newName,
            'slug' => $newSlug,
            'is_active' => true,
        ]);
    }

    public function down(): void
    {
        $this->renameCategory('Kepolisian & Ketertiban Umum', 'Keamanan & Ketertiban');

        $newSlug = Str::slug('Hak Warga dalam Proses Hukum');

        $current = DB::table('aspirasi_categories')
            ->where('slug', $newSlug)
            ->orWhere('name', 'Hak Warga dalam Proses Hukum')
            ->first();

        if ($current === null) {
            return;
        }

        $legacy = DB::table('aspirasi_categories')->where('slug', 'hak-asasi-manusia-ham')->first();

        if ($legacy !== null && $legacy->id !== $current->id) {
            DB::table('aspirations')->where('category_id', $current->id)->update(['category_id' => $legacy->id]);
            DB::table('aspirasi_categories')->where('id', $current->id)->delete();

            return;
        }

        DB::table('aspirasi_categories')->where('id', $current->id)->update([
            'name' => 'Hak Asasi Manusia (HAM)',
            'slug' => 'hak-asasi-manusia-ham',
            'is_active' => true,
        ]);
    }

    private function renameCategory(string $fromName, string $toName): void
    {
        $fromSlug = Str::slug($fromName);
        $toSlug = Str::slug($toName);

        $source = DB::table('aspirasi_categories')
            ->where('slug', $fromSlug)
            ->orWhere('name', $fromName)
            ->first();

        if ($source === null) {
            return;
        }

        $target = DB::table('aspirasi_categories')->where('slug', $toSlug)->first();

        if ($target !== null && $target->id !== $source->id) {
            DB::table('aspirations')->where('category_id', $source->id)->update(['category_id' => $target->id]);
            DB::table('aspirasi_categories')->where('id', $source->id)->delete();

            return;
        }

        DB::table('aspirasi_categories')->where('id', $source->id)->update([
            'name' => $toName,
            'slug' => $toSlug,
            'is_active' => true,
        ]);
    }
};
