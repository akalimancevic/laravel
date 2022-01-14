<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = ['title','slug','description'];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function user_author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
