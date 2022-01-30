<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostLikeRequest;
use App\Http\Requests\UpdateBlogPostLikeRequest;
use App\Models\BlogPostLike;

class BlogPostLikeController extends Controller
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
     * @param  \App\Http\Requests\StoreBlogPostLikeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPostLikeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPostLike  $blogPostLike
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPostLike $blogPostLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPostLike  $blogPostLike
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPostLike $blogPostLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogPostLikeRequest  $request
     * @param  \App\Models\BlogPostLike  $blogPostLike
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogPostLikeRequest $request, BlogPostLike $blogPostLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPostLike  $blogPostLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPostLike $blogPostLike)
    {
        //
    }
}
