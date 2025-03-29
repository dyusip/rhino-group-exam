<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 20 random books/movies
        // Favorite::factory(20)->create()->each(function ($favorite) {
        //     // Attach 2-4 random tags to each favorite
        //     $tags = Tag::inRandomOrder()->limit(rand(2, 4))->pluck('id');
        //     $favorite->tags()->attach($tags);
        // });

        $favorites = [
            [
                'title' => 'Inception',
                'author' => 'Christopher Nolan',
                'type' => 'movie',
                'description' => 'A mind-bending thriller about dreams.',
                'release_year' => 2010,
                'tags' => ['sci-fi', 'thriller']
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'type' => 'book',
                'description' => 'An epic fantasy adventure.',
                'release_year' => 1954,
                'tags' => ['fantasy', 'adventure']
            ],
            [
                'title' => 'The Silence of the Lambs',
                'author' => 'Thomas Harris',
                'type' => 'book',
                'description' => 'A psychological horror novel.',
                'release_year' => 1988,
                'tags' => ['horror', 'mystery']
            ],
            [
                'title' => 'Interstellar',
                'author' => 'Christopher Nolan',
                'type' => 'movie',
                'description' => 'A journey beyond the stars.',
                'release_year' => 2014,
                'tags' => ['sci-fi', 'drama']
            ],
            [
                'title' => 'The Matrix',
                'author' => 'The Wachowskis',
                'type' => 'movie',
                'description' => 'A cyberpunk classic.',
                'release_year' => 1999,
                'tags' => ['sci-fi', 'action']
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author' => 'J.K. Rowling',
                'type' => 'book',
                'description' => 'A magical journey begins.',
                'release_year' => 1997,
                'tags' => ['fantasy', 'adventure']
            ],
            [
                'title' => 'The Godfather',
                'author' => 'Francis Ford Coppola',
                'type' => 'movie',
                'description' => 'A legendary crime drama.',
                'release_year' => 1972,
                'tags' => ['crime', 'drama']
            ],
            [
                'title' => 'The Dark Knight',
                'author' => 'Christopher Nolan',
                'type' => 'movie',
                'description' => 'The rise of the Dark Knight.',
                'release_year' => 2008,
                'tags' => ['action', 'drama']
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'type' => 'book',
                'description' => 'A dystopian novel.',
                'release_year' => 1949,
                'tags' => ['dystopian', 'sci-fi']
            ],
            [
                'title' => 'Fight Club',
                'author' => 'David Fincher',
                'type' => 'movie',
                'description' => 'A psychological thriller.',
                'release_year' => 1999,
                'tags' => ['drama', 'thriller']
            ],
        ];

        // Add more entries until we reach 30
        while (count($favorites) < 30) {
            $favorites[] = [
                'title' => 'Random Title ' . count($favorites) + 1,
                'author' => 'Random Author ' . count($favorites) + 1,
                'type' => (rand(0, 1) ? 'book' : 'movie'),
                'description' => 'This is a randomly generated entry.',
                'release_year' => rand(1900, 2024),
                'tags' => ['random', 'example']
            ];
        }

        foreach ($favorites as $data) {
            $favorite = Favorite::create([
                'title' => $data['title'],
                'author' => $data['author'],
                'type' => $data['type'],
                'description' => $data['description'],
                'release_year' => $data['release_year']
            ]);

            // Attach tags
            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $favorite->tags()->attach($tagIds);
        }
    }
}
