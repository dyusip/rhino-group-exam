<?php
namespace App\Services\CustomSort;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class TagCustomSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'desc' : 'asc';

        $query->leftJoin('favorite_tag', 'favorites.id', '=', 'favorite_tag.favorite_id')
            ->leftJoin('tags', 'favorite_tag.tag_id', '=', 'tags.id')
            ->orderBy('tags.name', $direction);
    }
}