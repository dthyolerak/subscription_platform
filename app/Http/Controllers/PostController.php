<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use App\Http\Requests\PostRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Jobs\SendPostNotification;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created post for a particular website.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $website = Website::where('id', $request->website_id)->first();
        $post = $website->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        dispatch(new SendPostNotification($post));
        
        // return response()->json(['message' => 'Post created successfully.']);
        return response('Post created successfully!', 201);
    }

    /**
     * Subscribe a user to a particular website.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscriptionRequest $request)
    {
        $website = Website::where('id', $request->website_id)->first();
        $subscriber = $website->subscribers()->create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // return response()->json(['message' => 'Subscribed successfully.']);
        return response('Post created successfully!', 201);
    }
}
