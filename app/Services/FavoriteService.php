<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Tag;
use App\Services\CustomSort\TagCustomSort;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FavoriteService
{
    public function __construct() 
    {
        //
    }

    /**
    * Get favorite list
    * @param string $filter - Search paramaters
    * return eloquent
    */
    public function list(string $filter)
    {
       $favoritesQuery = QueryBuilder::for(Favorite::with('tags'))
            ->defaultSort('id')
            ->allowedSorts([
                'id', 
                'author', 
                'title', 
                'type',
                //AllowedSort::custom('tag', new TagCustomSort()),
            ]);
        
        $favorites = $this->filter($favoritesQuery, $filter)
        ->paginate(10);

        return $favorites;
    }

    /**
    * Get favorite details
    * @param int $id - Favorite id
    */
    public function show($id) 
    {
        return Favorite::with('tags')->findOrFail($id);
    }

   /**
     * Create favorite record
     * @param string $title - Title of movie or book
     * @param string $author - Author of movie or book
     * @param string $description - Description of movie or book
     * @param string $releaseYear - Release year of movie or book
     * @param string $type - Type enum movie | book
     * @param array $tags - Movie or book tags
     */
    public function create(string $title, string $author, string $description, string $releaseYear, string $type,array $tags) 
    {
        $favorite = Favorite::create([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'release_year' => $releaseYear,
            'type' => $type
        ]);

        if (!empty($tags)) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $favorite->tags()->sync($tagIds);
        }
        return true;
    }
    
     /**
     * Update favorite record
     * @param string $id - Favorite ID
     * @param string $title - Title of movie or book
     * @param string $author - Author of movie or book
     * @param string $description - Description of movie or book
     * @param string $releaseYear - Release year of movie or book
     * @param string $type - Type enum movie | book
     * @param array $tags - Movie or book tags
     */
    public function update(int $id,string $title, string $author, string $description, string $releaseYear, string $type,array $tags) 
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->update([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'release_year' => $releaseYear,
            'type' => $type
        ]);

        if (!empty($tags)) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $favorite->tags()->sync($tagIds);
        }
        return true;
    }

    /**
    * Delete record
    */
    public function delete() 
    {
        //
    }

     /**
    * $favoriteQuery - parent query favorite list
    * string $filter - search filter
    */
    private function filter($favoriteQuery, $filter)
    {
        $filters = explode(' ', $filter);
        return $favoriteQuery->when($filter, function($query) use($filters) {
            $query->where(function($query) use($filters) {
                foreach($filters as $filter)
                {
                    $query->where('favorites.title', 'like', '%'. $filter .'%');
                    $query->orWhere('favorites.author', 'like', '%'. $filter .'%');
                    $query->orWhere('favorites.type', 'like', '%'. $filter .'%');
                }
            })->orWhereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });;
        });
    }
}