<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $appends = ['survey_type_word', 'time_slot_word'];

    protected $with = ['timeSlot'];

    const SURVEY_TYPE_RELOCATIION_SURVEY = 'relocation_survey';
    const SURVEY_TYPE_SUB_DIVIDE = 'sub_divide';
    const SURVEY_TYPE_FOR_TITLING = 'for_titling';

    const SURVEY_TYPES = [
        self::SURVEY_TYPE_RELOCATIION_SURVEY,
        self::SURVEY_TYPE_SUB_DIVIDE,
        self::SURVEY_TYPE_FOR_TITLING
    ];

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
        'time_slot_id',
        'user_id',
        'uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function getSurveyTypeWordAttribute()
    {

        switch ($this->survey_type) {
            case 'relocation_survey':
                return 'Relocation Survey';
            case 'sub_divide':
                return 'Sub divide';
            case 'for_titling':
                return 'For titling';
            default:
                return $this->survey_type;
        }

        return '';
    }

    public function getTimeSlotWordAttribute()
    {
        return "{$this->timeSlot->start_time} - {$this->timeslot->end_time}";
    }
}
