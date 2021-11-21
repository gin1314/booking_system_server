<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    const SURVEY_TYPE_RELOCATIION_SURVEY = 'relocation_survey';
    const SURVEY_TYPE_SUB_DIVIDE = 'sub_divide';
    const SURVEY_TYPE_FOR_TITLING = 'for_titling';

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';

    protected $fillable = [
        'full_name',
        'address',
        'phone_no',
        'survey_type',
        'status',
        'schedule_date',
        'land_location',
        'appointment_notes',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class, 'id');
    }
}
