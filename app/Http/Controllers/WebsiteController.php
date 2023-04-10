<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:websites,name'
        ]);

        $website = Website::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'message' => 'Website created successfully',
            'website' => $website
        ]);
    }

    public function createPost(Request $request, Website $website)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = $website->posts()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);

        dispatch(new SendPostNotification($post));

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ]);
    }
}
