<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',  // Add 'content' to the $fillable array
        'post_id',
        'user_id',
    ];

    // Relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
