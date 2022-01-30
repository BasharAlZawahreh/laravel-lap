<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function blogPostLikes()
    {
      return  $this->hasMany(BlogPostLike::class);
    }

    public function isPublished()
    {
        return $this->status == 1;
    }
}
