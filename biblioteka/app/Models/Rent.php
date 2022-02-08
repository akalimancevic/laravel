<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Rent extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'user_id',
        'status',
    ];
}