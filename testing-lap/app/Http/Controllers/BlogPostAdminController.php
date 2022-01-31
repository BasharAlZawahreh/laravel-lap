<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostAdminRequest;
use App\Http\Requests\UpdateBlogPostAdminRequest;
use App\Models\BlogPost;
use App\Models\BlogPostAdmin;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;

class BlogPostAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogPostAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPostAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPostAdmin  $blogPostAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPostAdmin $blogPostAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPostAdmin  $blogPostAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPostAdmin $blogPostAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogPostAdminRequest  $request
     * @param  \App\Models\BlogPostAdmin  $blogPostAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogPostAdminRequest $request,BlogPost $post)
    {
        $validated =   $request->validated();

        $post->update($validated);

        session()->flash('success', 'Post updated successfully!');

        if ($post->isPublished()) {
            session()->flash('published', 'Post published successfully!');
        }

        return redirect()->action([self::class,'edit'],$post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPostAdmin  $blogPostAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPostAdmin $blogPostAdmin)
    {
        //
    }
}
