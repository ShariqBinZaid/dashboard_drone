<?php

namespace App\Console\Commands;

use App\Models\Subscriptions;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:start';
    // protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription start';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptionStart = Subscriptions::where('start_date', '>', Carbon::now())->get();
        return Command::SUCCESS;
    }
}
