<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Relationship: A favorite (book/movie) has many tags.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'favorite_tag');
    }
}
