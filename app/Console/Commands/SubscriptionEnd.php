<?php

namespace App\Console\Commands;

use App\Models\PostSubscriptions;
use App\Models\UserComments;
use App\Models\UserLikes;
use App\Models\Winners;
use Carbon\Carbon;
use App\Models\Subscriptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:end';
    // protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription End';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $getpostsubscriptions = PostSubscriptions::with('Subscriptions', 'Posts')
                ->whereHas('Subscriptions', function ($q) {
                    $q->where('end_date', '<', Carbon::now()->format('Y-m-d'));
                })
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->get();

            if (!$getpostsubscriptions->isEmpty()) {
                foreach ($getpostsubscriptions as $k => $post) {
                    $isLike = UserLikes::where('user_id', Auth::id())->where('post_id', $post->id)->exists();
                    $post->commentCount += UserComments::where('post_id', $post->id)->count();
                    $post->isLike = $isLike;
                }

                $winnerPositions = [1, 2, 3];
                foreach ($winnerPositions as $position => $winnerPosition) {
                    if (isset($getpostsubscriptions[$position])) {
                        Winners::create([
                            'user_id' => Auth::id(),
                            'subscription_id' => $getpostsubscriptions->subscription_id,
                            'winner' => $winnerPosition,
                            'prize_type' => 'price',
                        ]);
                    }
                }

                $getpostsubscriptions->subscription->is_active = 0;
                $getpostsubscriptions->save();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
