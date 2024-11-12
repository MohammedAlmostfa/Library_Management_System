<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRecord extends Model
{
    use HasFactory;
    protected $fillable = [
    'book_id',
    'user_id',
    'borrowed_at',
    'due_date',
    'returned_at',
    ];

    // scoup by borrowed_at
    public function scopebyborrowed_at($query, $borrowed_at)
    {
        return $query->where('borrowed_at', $borrowed_at);
    }
    //  scoup by borrowed_at
    public function scopebyborrowed_at2($query, $date)
    {
        // return the borrowed recoded  Which was returned
        return $query->where('borrowed_at', '<', $date)
                               ->whereNotNull('due_date')
                               ->get();
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
