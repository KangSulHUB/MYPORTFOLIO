<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@portfolio.com'],
            [
                'name' => 'Admin Portfolio',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Seed Default Profile
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Nama Anda',
                'title' => 'Data Analyst & Engineer',
                'bio' => 'Saya adalah seorang profesional yang fokus pada pengolahan data, rekayasa data (ETL/ELT), dan pembuatan aplikasi web modern. Selamat datang di portfolio saya.',
                'photo_path' => null,
                'resume_path' => null,
                'email' => 'admin@portfolio.com',
                'github_url' => 'https://github.com/',
                'linkedin_url' => 'https://linkedin.com/in/',
                'skills' => json_encode(['Python', 'SQL', 'Laravel', 'Tailwind CSS', 'ETL Pipelines', 'Data Visualization']),
            ]
        );
    }
}
