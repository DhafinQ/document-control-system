<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'SOP (Standard Operating Procedure)', 'description' => 'Dokumen yang berisi prosedur operasional standar.'],
            ['name' => 'Rekam Medis', 'description' => 'Dokumen yang terkait dengan data rekam medis pasien, jika diperlukan.'],
            ['name' => 'Laporan Bulanan', 'description' => 'Dokumen laporan bulanan, audit, atau survei terkait.'],
            ['name' => 'Dokumen Pelatihan Staf', 'description' => 'Dokumen yang digunakan untuk pelatihan dan pengembangan staf.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
