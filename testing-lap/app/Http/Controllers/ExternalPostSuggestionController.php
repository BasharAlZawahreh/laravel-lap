<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalnRequest;
use App\Http\Requests\StoreExternalPostSuggestionRequest;
use App\Http\Requests\UpdateExternalPostSuggestionRequest;
use App\Mail\ExternalPostSuggesstedMail;
use App\Models\ExternalPostSuggestion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ExternalPostSuggestionController extends Controller
{
    public function __invoke(ExternalnRequest $request)
    {
        $validated = $request->validated();

        $title = $validated['title'];
        $url = $validated['url'];

        ExternalPostSuggestion::create([
            'title' => $title,
            'url' => $url
        ]);

        Mail::to(User::first())->send(new ExternalPostSuggesstedMail($title, $url));


        session()->flash('success', 'Thanks for your suggesstions!');

        return redirect()->route('index');
    }
}
