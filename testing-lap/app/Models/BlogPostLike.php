<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostLike extends Model
{
    use HasFactory;

    public function blogPost()
    {
       return $this->belongsTo(BlogPost::class);
    }
}
