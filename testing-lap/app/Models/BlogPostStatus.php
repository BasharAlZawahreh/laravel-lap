<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostStatus extends Model
{
    use HasFactory;
    public static function DRAFT()
    {
        return [
            'value' => 0
        ];
    }

    public static function PUBLISHED()
    {
        return [
            'value' => 1
        ];
    }
}
