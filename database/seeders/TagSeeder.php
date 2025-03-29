<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 unique tags
        $tags = ['sci-fi', 'thriller', 'romance', 'fantasy', 'mystery', 'horror', 'drama', 'comedy'];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }

        //Tag::factory(10)->create();
    }
}
