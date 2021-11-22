<?php

namespace App\Http\Controllers;

use App\Services\TimeSlotService;
use App\Transformers\TimeSlotTransformer;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{

    /**
     *
     * @var TimeSlotService
     */
    protected $timeSlotService;

    public function __construct(TimeSlotService $timeSlotService) {
        $this->timeSlotService = $timeSlotService;
    }

    public function getAll()
    {
        $timeSlots = $this->timeSlotService->getAll();

        return fractal($timeSlots, new TimeSlotTransformer)->respond();
    }
}
