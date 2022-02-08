<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_status_id',
        'rent_id'
    ];

   
    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_orders', 'order_id', 'book_id')->withPivot('quantity');
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}