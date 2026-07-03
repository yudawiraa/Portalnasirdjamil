<?php

namespace Database\Seeders;

use App\Models\AspirasiCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Hukum & Peradilan',
            'Hak Warga dalam Proses Hukum',
            'Kepolisian & Ketertiban Umum',
            'Pertanahan & Agraria',
            'Pelayanan Publik',
            'Pembangunan Daerah Aceh',
            'Korupsi & Penegakan Hukum',
            'Perlindungan Saksi/Korban',
            'Narkoba & BNN',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            AspirasiCategory::updateOrCreate(
                ['slug' => Str::slug($category)],
                ['name' => $category, 'is_active' => true],
            );
        }

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@nasirdjamil.local')],
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => 'admin',
            ],
        );
    }
}
