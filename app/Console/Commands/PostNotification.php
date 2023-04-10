<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PostNotification extends Command
{
    protected $signature = 'post:notification';
    protected $description = 'Send email notifications to subscribers when a new post is published';
    
    public function handle()
    {
        $posts = Post::where('notified', false)->get();

        foreach ($posts as $post) {
            $subscriptions = Subscription::where('website_id', $post->website_id)->get();

            foreach ($subscriptions as $subscription) {
                Mail::raw("New post: " . $post->title . "\n\n" . $post->description, function ($message) use ($subscription) {
                    $message->to($subscription->user->email)->subject('New post on website');
                });
            }

            $post->notified = true;
            $post->save();
        }

        $this->info('Post notifications sent successfully.');
    }

    // PostNotification Mailable
    public $post;

    public function __construct(Post $post)
    {   parent::__construct();
        $this->post = $post;
        
    }

    public function build()
    {
        return $this->markdown('emails.post-notification')->with([
            'post' => $this->post
        ]);
    }

}
