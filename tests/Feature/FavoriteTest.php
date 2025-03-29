<?php

namespace Tests\Feature;

use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Validate favorite title required
     */
    public function test_it_can_validate_title_required_when_creating_a_favorite(): void
    {
        $response = $this->postJsonWithPrefix('/favorites', [
            'title' => '',
            'author' => 'Christopher Nolan',
            'type' => 'movie',
            'description' => 'A sci-fi epic.',
            'release_year' => 2014,
            'tags' => ['sci-fi', 'drama']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

     /**
     * Validate favorite type is in movie or book
     */
    public function test_it_can_validate_type_is_movie_or_book_when_creating_a_favorite(): void
    {
        $response = $this->postJsonWithPrefix('/favorites', [
            'title' => 'Interstellar',
            'author' => 'Christopher Nolan',
            'type' => 'magazine',
            'description' => 'A sci-fi epic.',
            'release_year' => 2014,
            'tags' => ['sci-fi', 'drama']
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['type']);
    }

   /**
     * Create favorite record test
     */
    public function test_it_can_create_a_favorite(): void
    {
        $response = $this->postJsonWithPrefix('/favorites', [
            'title' => 'Interstellar',
            'author' => 'Christopher Nolan',
            'type' => 'movie',
            'description' => 'A sci-fi epic.',
            'release_year' => 2014,
            'tags' => ['sci-fi', 'drama']
        ]);

        $this->assertDatabaseHas('favorites', ['title' => 'Interstellar']);
    }

    /**
     * Get the favorite list record test
     */
    public function test_it_can_read_favorites(): void
    {
        Favorite::factory()->create();
        $response = $this->getJsonWithPrefix('/favorites');

        $response->assertInertia(fn (Assert $page) => $page
                ->has('favorites')
                ->has('tags')
                ->etc()
        );
    }

     /**
     * Update the favorite record test
     */
    public function test_it_can_update_a_favorite(): void
    {
        $favorite = Favorite::factory()->create();
        
        $this->putJsonWithPrefix("/favorites/{$favorite->id}", [
            'title' => 'Updated Title',
            'author' => $favorite->author,
            'type' => $favorite->type,
            'description' => $favorite->description,
            'release_year' => $favorite->release_year,
            'tags' => ['updated-tag']
        ]);
        
        $this->assertDatabaseHas('favorites', ['title' => 'Updated Title']);
    }

    /**
     * Delete favorite record test
     */
    public function test_it_can_delete_a_favorite()
    {
        $favorite = Favorite::factory()->create();

        $this->deleteJsonWithPrefix("/favorites/{$favorite->id}");

        $this->assertSoftDeleted('favorites', ['id' => $favorite->id]);
    }
}
