<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'published_at',
        'category_id',
        'case',
    ];

    //filter by author
    public function scopebyAuthor($query, $author)
    {
        return $query->where('author', $author);
    }
    //filter by category
    public function scopebyCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id);
    }
    //filter by category
    public function scopebyCase($query, $case)
    {
        return $query->where('case', $case);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    //browsr
    public function borrow()
    {
        return $this->hasMany(BorrowRecord::class);
    }


    public function category()
    {
        return $this->hasone(Category::class);
    }

}
