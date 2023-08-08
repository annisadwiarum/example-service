<?php

namespace App\Models;

use Carbon\Carbon;
// use App\Models\Holiday;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'limit_start_time',
        'end_time',
        'limit_end_time',
    ];

    protected $appends = ['attendance_data'];

    protected function attendance_data(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $now = now();
                $startTime = Carbon::parse($this->start_time);
                $limitStartTime = Carbon::parse($this->limit_start_time);

                $endTime = Carbon::parse($this->end_time);
                $limitEndTime = Carbon::parse($this->limit_end_time);

                $isHolidayToday = Holiday::query()
                    ->where('holiday_date', now()->toDateString())
                    ->get();

                return (object) [
                    "start_time" => $this->start_time,
                    "limit_start_time" => $this->limit_start_time,
                    "end_time" => $this->end_time,
                    "limit_end_time" => $this->limit_end_time,
                    "now" => $now->format("H:i:s"),
                    "is_start" => $startTime <= $now && $limitStartTime >= $now,
                    "is_end" => $endTime <= $now && $limitEndTime >= $now,
                    'is_holiday_today' => $isHolidayToday->isNotEmpty()
                ];
            }
        );
    }

    public function scopeForCurrentUser($query, $userPositionId)
    {
        $query->whereHas('positions', function ($query) use ($userPositionId) {
            $query->where('position_id', $userPositionId);
        });
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }
}
