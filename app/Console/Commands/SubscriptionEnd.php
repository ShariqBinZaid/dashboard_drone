<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Subscriptions;
use Illuminate\Console\Command;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptionStart = Subscriptions::where('start_date', '<', Carbon::now())->get();
        return Command::SUCCESS;
    }
}
