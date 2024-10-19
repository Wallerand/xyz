<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /** @var array Predefined categories */
    protected $categories = [
        'Soul',
        'Ambient',
        'Pop',
        'Rap',
        'Funk',
        'Rock',
        'Reggae / Dub',
        'Techno',
        'Electro'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect($this->categories)
            ->map(fn ($name) => [
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->toArray();

        Category::insert($categories);
    }
}
