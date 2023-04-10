<?php
namespace App\Jobs;

use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new job instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscriptions = Subscription::where('website_id', $this->post->website_id)->get();

        foreach ($subscriptions as $subscription) {
            Mail::raw("New post: " . $this->post->title . "\n\n" . $this->post->description, function ($message) use ($subscription) {
                $message->to($subscription->user->email)->subject('New post on website');
            });
        }
    }
}
