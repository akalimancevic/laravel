<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'book_image_path',
        'author_id',
        'genre_id',
    ];


    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->using(Rent::class);
    }
    
}
