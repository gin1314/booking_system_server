<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $appends = ['survey_type_word', 'time_slot_word'];

    protected $with = ['timeSlot'];

    const SURVEY_TYPE_BOUNDARY = 'boundary';
    const SURVEY_TYPE_CONSTRUCTION = 'construction';
    const SURVEY_TYPE_LOCATION = 'location';
    const SURVEY_TYPE_SITE_PLANNING = 'site_planning';
    const SURVEY_TYPE_SUBDIVISION = 'subdivision';
    const SURVEY_TYPE_TOPOGRAPHIC = 'topographic';

    const SURVEY_TYPES = [
        self::SURVEY_TYPE_BOUNDARY,
        self::SURVEY_TYPE_CONSTRUCTION,
        self::SURVEY_TYPE_LOCATION,
        self::SURVEY_TYPE_SUBDIVISION,
        self::SURVEY_TYPE_TOPOGRAPHIC
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const STATUS = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    protected $fillable = [
        // 'full_name',
        'first_name',
        'last_name',
        // 'address',
        'email',
        'phone_no',
        'survey_type',
        'status',
        'schedule_date',
        'client_street',
        'client_city',
        'client_region',
        'client_postal_code',
        'land_street',
        'land_city',
        'land_region',
        'land_postal_code',
        'requirements',
        // 'land_location',
        'appointment_notes',
        'time_slot_id',
        'user_id',
        'uuid',
        'reference_id',
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
            case 'boundary':
                return 'Boundary';
            case 'construction':
                return 'Construction';
            case 'site_planning':
                return 'Site Planning';
            case 'subdivision':
                return 'Subdivision';
            case 'location':
                return 'Location';
            case 'topographic':
                return 'Topographic';
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
