<?php

namespace Database\Seeders;

use App\Models\PerName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perNames = [
            'user',
            'permission',
            'role',
        ];

        foreach ($perNames as $per) {
            PerName::create([
                'name' => $per,
            ]);
        }
    }
}
