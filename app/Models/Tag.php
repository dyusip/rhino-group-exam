<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

     /**
     * Relationship: A tag belongs to many favorites (books/movies).
     */
    public function favorites()
    {
        return $this->belongsToMany(Favorite::class, 'favorite_tag');
    }
}
