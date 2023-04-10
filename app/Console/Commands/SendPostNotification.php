<?php

namespace App\Console\Commands;

use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPostNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-post-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // SendPostNotification command
    public function handle()
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            $posts = $website->posts()->where('created_at', '>', now()->subDay())->get();

            $subscriptions = $website->subscriptions;

            foreach ($subscriptions as $subscription) {
                $user = $subscription->user;

                $sent_posts = $user->sent_posts->pluck('id')->toArray();

                $new_posts = $posts->whereNotIn('id', $sent_posts);

                foreach ($new_posts as $post) {
                    Mail::to($user)->send(new PostNotification($post));

                    $user->sent_posts()->create([
                        'post_id' => $post->id
                    ]);
                }
            }
        }
    }

}
