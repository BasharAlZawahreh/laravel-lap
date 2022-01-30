<?php

namespace App\Models;

use App\Http\Requests\ExternalnRequest;
use App\Mail\ExternalPostSuggesstedMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class ExternalPostSuggestion extends Model
{
    use HasFactory;

   protected $guarded = [];
}
