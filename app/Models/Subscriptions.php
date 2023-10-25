<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriptions extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getTimeRemaining()
    {
        if ($this->is_active) {
            $startDate = Carbon::parse($this->start_date);
            $currentDate = Carbon::now();
            $endDate = Carbon::parse($this->start_date)->addDays(3);

            $diff = $currentDate->diff($endDate);

            $remaining = [
                'days' => $diff->d,
                'hours' => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
            ];

            return $remaining;
        } else {
            return [
                'days' => 0,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            ];
        }
    }
}
