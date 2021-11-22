<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $appends = ['time_slot_word'];

    protected $fillable = [
        'start_time',
        'end_time',
    ];

    public function getTimeSlotWordAttribute()
    {
        return "{$this->start_time} - {$this->end_time}";
    }
}
