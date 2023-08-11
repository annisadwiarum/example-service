<?php

namespace App\Models;

use Carbon\Carbon;
// use App\Models\Holiday;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Attendance extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
