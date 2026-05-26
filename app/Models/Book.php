<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'language',
        'isbn',
        'category',
        'synopsis',
        'cover_image'
    ];
}