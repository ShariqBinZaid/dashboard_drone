<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriptions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCurrentCounter()
    {
        if ($this->is_active) {
            $startDate = Carbon::parse($this->start_date);
            $currentDate = Carbon::now();
            $endDate = Carbon::parse($this->start_date)->addDays(3); // Adding 3 days to the start_date
            $counter = $endDate->diffInDays($currentDate);

            // Ensure the counter is not negative
            return max(0, $counter);
        } else {
            // Subscription is not active, so counter is 0
            return 0;
        }
    }
}
