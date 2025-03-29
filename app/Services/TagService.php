<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function __construct() 
    {
        //
    }

    /**
    * Get list
    */
    public function list() 
    {
        return Tag::get();
    }
}