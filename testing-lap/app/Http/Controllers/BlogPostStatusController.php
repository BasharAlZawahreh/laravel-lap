<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostStatusRequest;
use App\Http\Requests\UpdateBlogPostStatusRequest;
use App\Models\BlogPostStatus;

class BlogPostStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreBlogPostStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogPostStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPostStatus  $blogPostStatus
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPostStatus $blogPostStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPostStatus  $blogPostStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPostStatus $blogPostStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogPostStatusRequest  $request
     * @param  \App\Models\BlogPostStatus  $blogPostStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogPostStatusRequest $request, BlogPostStatus $blogPostStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPostStatus  $blogPostStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPostStatus $blogPostStatus)
    {
        //
    }
}
